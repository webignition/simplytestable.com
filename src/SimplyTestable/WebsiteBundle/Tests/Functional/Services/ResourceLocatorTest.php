<?php

namespace SimplyTestable\WebsiteBundle\Tests\Functional\Controller;

use SimplyTestable\WebsiteBundle\Tests\Functional\AbstractWebTestCase;

class ResourceLocatorTest extends AbstractWebTestCase
{
    /**
     * @dataProvider locateDataProvider
     *
     * @param string $name
     * @param string $expectedRelativeResourcePath
     */
    public function testLocate($name, $expectedRelativeResourcePath)
    {
        $resourceLocator = $this->container->get('simplytestable.services.resourcelocator');

        $expectedAbsoluteResourcePath = str_replace(
            '/app',
            '/',
            $this->container->get('kernel')->getRootDir() . $expectedRelativeResourcePath
        );

        $this->assertEquals($expectedAbsoluteResourcePath, $resourceLocator->locate($name));
    }

    /**
     * @return array
     */
    public function locateDataProvider()
    {
        return [
            'sitemap routes' => [
                'name' => '@SimplyTestableWebsiteBundle/Resources/config/sitemap_routes.json',
                'expectedRelativeResourcePath' =>
                    'src/SimplyTestable/WebsiteBundle/Resources/config/sitemap_routes.json',
            ],
        ];
    }
}
