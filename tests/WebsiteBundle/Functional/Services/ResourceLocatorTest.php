<?php

namespace Tests\WebsiteBundle\Functional\Services;

use SimplyTestable\WebsiteBundle\Services\ResourceLocator;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

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
        $resourceLocator = $this->container->get(ResourceLocator::class);

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
