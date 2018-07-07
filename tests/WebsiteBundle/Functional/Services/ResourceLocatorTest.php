<?php

namespace Tests\WebsiteBundle\Functional\Services;

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
        $resourceLocator = $this->testServiceProvider->getResourceLocator();

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
            'web client routing' => [
                'name' => '@SimplyTestableWebsiteBundle/Resources/config/webclientrouting.yml',
                'expectedRelativeResourcePath' =>
                    'src/SimplyTestable/WebsiteBundle/Resources/config/webclientrouting.yml',
            ],
        ];
    }
}
