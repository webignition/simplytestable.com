<?php

namespace Tests\WebsiteBundle\Functional\Command\Sitemap;

use SimplyTestable\WebsiteBundle\Command\Sitemap\BuildCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Templating\EngineInterface;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class BuildCommandTest extends AbstractWebTestCase
{
    /**
     * @var string
     */
    private $sitemapPath;

    /**
     * @var string
     */
    private $webRootPath;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->webRootPath = realpath($this->container->get('kernel')->getRootDir() . '/../web');
        $this->sitemapPath = $this->webRootPath . BuildCommand::SITEMAP_RELATIVE_PATH;
    }

    public function testGetAsService()
    {
        $this->assertInstanceOf(
            BuildCommand::class,
            $this->container->get('simplytestable.command.sitemap.build')
        );
    }

    public function testRun()
    {
        if (file_exists($this->sitemapPath) && is_file($this->sitemapPath)) {
            unlink($this->sitemapPath);
        }

        $this->assertFileNotExists($this->sitemapPath);

        /* @var EngineInterface $templating */
        $templating = $this->container->get('templating');

        $command = new BuildCommand(
            $this->container->get('router'),
            $this->container->get('simplytestable.services.resourcelocator'),
            $this->container->get('kernel')->getRootDir(),
            $templating
        );

        $returnCode = $command->run(new ArrayInput([]), new NullOutput());

        $this->assertEquals(0, $returnCode);
        $this->assertFileExists($this->sitemapPath);

        $resourceLocator = $this->container->get('simplytestable.services.resourcelocator');

        $urlRoutesSource = file_get_contents(
            $resourceLocator->locate(BuildCommand::SITEMAP_ROUTES_RESOURCE_NAME)
        );
        $urlRoutes = json_decode($urlRoutesSource, true);

        $sitemapContent = file_get_contents($this->sitemapPath);
        $sitemapDOM = new \DOMDocument();
        $sitemapDOM->loadXML($sitemapContent);

        $this->assertEquals(1, $sitemapDOM->getElementsByTagName('urlset')->length);
        $this->assertEquals(count($urlRoutes), $sitemapDOM->getElementsByTagName('url')->length);
    }
}
