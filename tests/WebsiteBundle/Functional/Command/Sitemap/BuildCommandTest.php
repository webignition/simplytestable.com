<?php

namespace Tests\WebsiteBundle\Functional\Command\Sitemap;

use SimplyTestable\WebsiteBundle\Command\Sitemap\BuildCommand;
use SimplyTestable\WebsiteBundle\Services\KernelParametersService;
use SimplyTestable\WebsiteBundle\Services\ResourceLocator;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class BuildCommandTest extends AbstractWebTestCase
{
    public function testRun()
    {
        $sitemapPath = sprintf(
            '%s%s',
            $this->container->get(KernelParametersService::class)->getWebDir(),
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

        $resourceLocator = $this->container->get(ResourceLocator::class);

        $urlRoutesSource = file_get_contents(
            $resourceLocator->locate(BuildCommand::SITEMAP_ROUTES_RESOURCE_NAME)
        );
        $urlRoutes = json_decode($urlRoutesSource, true);

        $sitemapContent = file_get_contents($sitemapPath);
        $sitemapDOM = new \DOMDocument();
        $sitemapDOM->loadXML($sitemapContent);

        $this->assertEquals(1, $sitemapDOM->getElementsByTagName('urlset')->length);
        $this->assertEquals(count($urlRoutes), $sitemapDOM->getElementsByTagName('url')->length);
    }
}
