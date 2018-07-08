<?php

namespace AppBundle\Command\Sitemap;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig_Environment;

class BuildCommand extends Command
{
    const SITEMAP_ROUTES_RESOURCE_NAME = '/config/resources/sitemap_routes.json';
    const SITEMAP_RELATIVE_PATH = '/sitemap.xml';

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $kernelProjectDirectory;

    /**
     * @var string
     */
    private $webDirectory;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @param string $kernelProjectDirectory
     * @param string $webDirectory
     * @param RouterInterface $router
     * @param Twig_Environment $twig
     * @param string|null $name
     */
    public function __construct(
        $kernelProjectDirectory,
        $webDirectory,
        RouterInterface $router,
        Twig_Environment $twig,
        $name = null
    ) {
        parent::__construct($name);

        $this->kernelProjectDirectory = $kernelProjectDirectory;
        $this->webDirectory = $webDirectory;

        $this->router = $router;
        $this->twig = $twig;

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

        $sitemapContent = $this->twig->render('sitemap.xml.twig', [
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
            file_get_contents($this->kernelProjectDirectory . self::SITEMAP_ROUTES_RESOURCE_NAME),
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
