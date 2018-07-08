<?php

namespace Tests\Src\DataProvider;

trait RouteDataProviderTrait
{
    /**
     * @return array
     */
    public function routeDataProvider()
    {
        return [
            'home' => [
                'url' => '/',
            ],
            'plans' => [
                'url' => '/plans/',
            ],
            'features' => [
                'url' => '/features/',
            ],
            'account-benefits' => [
                'url' => '/account-benefits/',
            ],
            'plans/demo' => [
                'url' => '/plans/demo/',
            ],
            'plans/personal' => [
                'url' => '/plans/personal/',
            ],
            'plans/agency' => [
                'url' => '/plans/agency/',
            ],
            'plans/business' => [
                'url' => '/plans/business/',
            ],
            'plans/enterprise' => [
                'url' => '/plans/enterprise/',
            ],
            'outdated-browser' => [
                'url' => '/outdated-browser/',
            ],
            'tms' => [
                'url' => '/tms/',
            ],
        ];
    }
}
