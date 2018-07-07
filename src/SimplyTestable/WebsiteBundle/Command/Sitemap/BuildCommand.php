<?php

namespace SimplyTestable\WebsiteBundle\Command\Sitemap;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class BuildCommand extends Command
{
    const SITEMAP_ROUTES_RESOURCE_NAME = '/config/config/sitemap_routes.json';
    const SITEMAP_RELATIVE_PATH = '/sitemap.xml';

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $kernelRootDirectory;

    /**
     * @var string
     */
    private $webDirectory;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @param string $kernelRootDirectory
     * @param string $webDirectory
     * @param RouterInterface $router
     * @param EngineInterface $templating
     * @param string|null $name
     */
    public function __construct(
        $kernelRootDirectory,
        $webDirectory,
        RouterInterface $router,
        EngineInterface $templating,
        $name = null
    ) {
        parent::__construct($name);

        $this->kernelRootDirectory = $kernelRootDirectory;
        $this->webDirectory = $webDirectory;

        $this->router = $router;
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

        $sitemapContent = $this->templating->render('sitemap.xml.twig', [
            'urls' => $decoratedUrls,
        ]);

        $sitemapPath = $this->webDirectory . self::SITEMAP_RELATIVE_PATH;

        file_put_contents($sitemapPath, $sitemapContent);
        $output->writeln('Generated sitemap at [' . $sitemapPath . ']');
    }

    /**
     * @return string[]
     */
    private function getUrls()
    {
        $urls = [];

        $routes = json_decode(
            file_get_contents($this->kernelRootDirectory . self::SITEMAP_ROUTES_RESOURCE_NAME),
            true
        );

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
