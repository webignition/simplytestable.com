<?php
namespace SimplyTestable\WebsiteBundle\Command\Sitemap;

use SimplyTestable\WebsiteBundle\Services\ResourceLocator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class BuildCommand extends Command
{
    const SITEMAP_ROUTES_RESOURCE_NAME = '@SimplyTestableWebsiteBundle/Resources/config/sitemap_routes.json';
    const SITEMAP_RELATIVE_PATH = '/sitemap.xml';

    /**
     * @var Router
     */
    private $router;

    /**
     * @var ResourceLocator
     */
    private $resourceLocator;

    /**
     * @var string
     */
    private $webRootDir;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @param Router $router
     * @param ResourceLocator $resourceLocator
     * @param string $kernelRootDir
     * @param EngineInterface $templating
     * @param string|null $name
     */
    public function __construct(
        Router $router,
        ResourceLocator $resourceLocator,
        $kernelRootDir,
        EngineInterface $templating,
        $name = null
    ) {
        parent::__construct($name);
        $this->router = $router;
        $this->resourceLocator = $resourceLocator;
        $this->webRootDir = realpath($kernelRootDir . '/../web');
        $this->templating = $templating;

        $routerContext = $this->router->getContext();
        $routerContext->setHost('simplytestable.com');
        $routerContext->setScheme('https');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('simplytestable:sitemap:build')
            ->setDescription('Build the sitemap.xml file')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTime();
        $lastModified = $now->format('Y-m-d');

        $urls = $this->getUrls();
        $decoratedUrls = [];

        foreach ($urls as $url) {
            $decoratedUrls[] = [
                'location' => $url,
                'last_modified' => $lastModified,
                'change_frequency' => 'monthly',
                'priority' => 1,
            ];
        }

        $sitemapContent = $this->templating->render('SimplyTestableWebsiteBundle::sitemap.xml.twig', [
            'urls' => $decoratedUrls,
        ]);

        $sitemapPath = $this->webRootDir . self::SITEMAP_RELATIVE_PATH;

        file_put_contents($sitemapPath, $sitemapContent);
        $output->writeln('Generated sitemap at [' . $sitemapPath . ']');
    }

    /**
     * @return string[]
     */
    private function getUrls()
    {
        $urls = [];
        $routes = json_decode(file_get_contents(
            $this->resourceLocator->locate(self::SITEMAP_ROUTES_RESOURCE_NAME)
        ), true);

        foreach ($routes as $route) {
            $urls[] = $this->router->generate(
                $route['route'],
                $route['parameters'],
                RouterInterface::ABSOLUTE_URL
            );
        }

        return $urls;
    }
}
