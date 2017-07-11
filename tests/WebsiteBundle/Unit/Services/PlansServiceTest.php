<?php

namespace Tests\WebsiteBundle\Unit\Services;

use SimplyTestable\WebsiteBundle\Model\Plan\DistinctionInterface;
use SimplyTestable\WebsiteBundle\Model\Plan\PlanInterface;
use SimplyTestable\WebsiteBundle\Services\PlansService;
use Tests\WebsiteBundle\Utility\ConfigResourceLoader;

class PlansServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string[]
     */
    private $expectedDistinctionGroupIds = [
        DistinctionInterface::DISTINCTION_GROUP_TEST_LIMITATIONS,
        DistinctionInterface::DISTINCTION_GROUP_ACCESS_TO_RESULTS,
        DistinctionInterface::DISTINCTION_GROUP_URL_DISCOVERY,
        DistinctionInterface::DISTINCTION_GROUP_TEST_TYPES,
        DistinctionInterface::DISTINCTION_GROUP_ADVANCED_OPTIONS,
    ];

    /**
     * @var PlansService
     */
    private $plansService;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->plansService = new PlansService(
            ConfigResourceLoader::load('/plans/plans.yml'),
            ConfigResourceLoader::load('/plans/distinctions.yml')
        );
    }

    /**
     * @dataProvider getPlansDataProvider
     *
     * @param string[] $planIds
     * @param string[] $expectedPlanIds
     */
    public function testGetPlans($planIds, $expectedPlanIds)
    {
        $plans = $this->plansService->getPlans($planIds);
        $this->assertEquals($expectedPlanIds, array_keys($plans));
        foreach ($plans as $plan) {
            /* @var PlanInterface $plan */
            $this->assertEquals($this->expectedDistinctionGroupIds, array_keys($plan->getDistinctions()));
        }
    }

    public function testGetDistinctions()
    {
        $distinctions = $this->plansService->getDistinctions();

        $this->assertEquals($this->expectedDistinctionGroupIds, array_keys($distinctions));
    }

    /**
     * @return array
     */
    public function getPlansDataProvider()
    {
        return [
            'all' => [
                'planIds' => [],
                'expectedPlanIds' => [
                    'demo',
                    'free',
                    'personal',
                    'agency',
                    'business',
                    'enterprise',
                    'premium',
                ],
            ],
            'demo, agency' => [
                'planIds' => [
                    'demo',
                    'agency',
                ],
                'expectedPlanIds' => [
                    'demo',
                    'agency',
                ],
            ],

        ];
    }
}
