<?php

namespace App\Tests\Src\Functional\Command\Sitemap;

use App\Command\Sitemap\BuildCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use App\Tests\Src\Functional\AbstractWebTestCase;

class BuildCommandTest extends AbstractWebTestCase
{
    public function testRun()
    {
        $sitemapPath = sprintf(
            '%s%s',
            self::$container->getParameter('kernel.project_dir') . '/public',
            BuildCommand::SITEMAP_RELATIVE_PATH
        );

        if (file_exists($sitemapPath) && is_file($sitemapPath)) {
            unlink($sitemapPath);
        }

        $this->assertFileNotExists($sitemapPath);

        $command = self::$container->get(BuildCommand::class);

        $returnCode = $command->run(new ArrayInput([]), new NullOutput());

        $this->assertEquals(0, $returnCode);
        $this->assertFileExists($sitemapPath);

        $urlRoutesSourcePath =
            self::$container->getParameter('kernel.project_dir') .
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
