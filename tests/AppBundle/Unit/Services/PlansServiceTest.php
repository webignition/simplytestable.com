<?php

namespace Tests\AppBundle\Unit\Services;

use AppBundle\Model\Plan\DistinctionInterface;
use AppBundle\Model\Plan\PlanInterface;
use AppBundle\Services\PlansService;
use Tests\AppBundle\Utility\ConfigParameterResourceLoader;

class PlansServiceTest extends \PHPUnit\Framework\TestCase
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
            ConfigParameterResourceLoader::load('/plans.yml', 'plans'),
            ConfigParameterResourceLoader::load('/plan-distinctions.yml', 'plan_distinctions')
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
