<?php

namespace Tests\WebsiteBundle\Functional\Command\Sitemap;

use SimplyTestable\WebsiteBundle\Command\Sitemap\BuildCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class BuildCommandTest extends AbstractWebTestCase
{
    public function testRun()
    {
        $applicationConfigurationService = $this->testServiceProvider->getApplicationConfigurationService();

        $sitemapPath = sprintf(
            '%s%s',
            $applicationConfigurationService->getWebDir(),
            BuildCommand::SITEMAP_RELATIVE_PATH
        );

        if (file_exists($sitemapPath) && is_file($sitemapPath)) {
            unlink($sitemapPath);
        }

        $this->assertFileNotExists($sitemapPath);

        $command = $this->container->get(BuildCommand::class);

        $returnCode = $command->run(new ArrayInput([]), new NullOutput());

        $this->assertEquals(0, $returnCode);
        $this->assertFileExists($sitemapPath);

        $urlRoutesSourcePath =
            $this->container->getParameter('kernel.root_dir') .
            BuildCommand::SITEMAP_ROUTES_RESOURCE_NAME;

        $urlRoutesSource = file_get_contents(
            $urlRoutesSourcePath
        );

        $urlRoutes = json_decode($urlRoutesSource, true);

        $sitemapContent = file_get_contents($sitemapPath);
        $sitemapDOM = new \DOMDocument();
        $sitemapDOM->loadXML($sitemapContent);

        $this->assertEquals(1, $sitemapDOM->getElementsByTagName('urlset')->length);
        $this->assertEquals(count($urlRoutes), $sitemapDOM->getElementsByTagName('url')->length);
    }
}
