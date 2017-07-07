<?php

namespace SimplyTestable\WebsiteBundle\Model\Plan;

class PseudoPlan implements PlanInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $price;

    /**
     * @var array
     */
    private $distinctions;

    /**
     * @param string $id
     * @param Plan[] $plans
     */
    public function __construct($id, $plans)
    {
        $this->id = $id;
        $this->price = $this->derivePrice($plans);
        $this->distinctions = $this->deriveDistinctions($plans);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function getDistinctions()
    {
        return $this->distinctions;
    }

    /**
     * @param Plan[] $plans
     *
     * @return string
     */
    private function derivePrice($plans)
    {
        $prices = [];

        foreach ($plans as $plan) {
            $prices[] = $plan->getPrice();
        }
        return min($prices);
    }

    /**
     * @param Plan[] $plans
     *
     * @return array
     */
    private function deriveDistinctions($plans)
    {
        return [
            'test_limitations' => [
                'full_site_tests_per_site' => new Distinction(
                    'full_site_tests_per_site',
                    $this->deriveIntegerOrNullValue(
                        $plans,
                        'test_limitations',
                        'full_site_tests_per_site'
                    )
                ),
                'single_page_tests_per_page' => new Distinction(
                    'single_page_tests_per_page',
                    $this->deriveIntegerOrNullValue(
                        $plans,
                        'test_limitations',
                        'single_page_tests_per_page'
                    )
                ),
                'pages_examined_per_test' => new Distinction(
                    'pages_examined_per_test',
                    $this->deriveNumericRange(
                        $plans,
                        'test_limitations',
                        'pages_examined_per_test'
                    )
                ),
                'credits_per_month' => new Distinction(
                    'credits_per_month',
                    $this->deriveNumericRange(
                        $plans,
                        'test_limitations',
                        'credits_per_month'
                    )
                ),
            ],
            'access_to_results' => [
                'results_available_for' => new Distinction(
                    'results_available_for',
                    'Forever'
                ),
                'private_tests' => new Distinction(
                    'private_tests',
                    $this->deriveBooleanValue(
                        $plans,
                        'access_to_results',
                        'private_tests'
                    )
                ),
                'read_only_reports' => new Distinction(
                    'read_only_reports',
                    $this->deriveBooleanValue(
                        $plans,
                        'access_to_results',
                        'read_only_reports'
                    )
                ),
            ],
            'url_discovery' => [
                'discovery_via_sitemap' => new Distinction(
                    'discovery_via_sitemap',
                    $this->deriveBooleanValue(
                        $plans,
                        'url_discovery',
                        'discovery_via_sitemap'
                    )
                ),
                'discovery_via_crawl' => new Distinction(
                    'discovery_via_crawl',
                    $this->deriveBooleanValue(
                        $plans,
                        'url_discovery',
                        'discovery_via_crawl'
                    )
                ),
            ],
            'test_types' => [
                'html_validation' => new Distinction(
                    'html_validation',
                    $this->deriveBooleanValue(
                        $plans,
                        'test_types',
                        'html_validation'
                    )
                ),
                'css_validation' => new Distinction(
                    'css_validation',
                    $this->deriveBooleanValue(
                        $plans,
                        'test_types',
                        'css_validation'
                    )
                ),
                'js_static_analysis' => new Distinction(
                    'js_static_analysis',
                    $this->deriveBooleanValue(
                        $plans,
                        'test_types',
                        'js_static_analysis'
                    )
                ),
                'link_integrity_checking' => new Distinction(
                    'link_integrity_checking',
                    $this->deriveBooleanValue(
                        $plans,
                        'test_types',
                        'link_integrity_checking'
                    )
                ),
            ],
            'advanced_options' => [
                'https_sites' => new Distinction(
                    'https_sites',
                    $this->deriveBooleanValue(
                        $plans,
                        'advanced_options',
                        'https_sites'
                    )
                ),
                'http_authentication' => new Distinction(
                    'http_authentication',
                    $this->deriveBooleanValue(
                        $plans,
                        'advanced_options',
                        'http_authentication'
                    )
                ),
                'custom_cookies' => new Distinction(
                    'custom_cookies',
                    $this->deriveBooleanValue(
                        $plans,
                        'advanced_options',
                        'custom_cookies'
                    )
                ),
            ],
        ];
    }

    /**
     * @param Plan[] $plans
     * @param string $group
     * @param string $key
     *
     * @return string|null
     */
    private function deriveNumericRange($plans, $group, $key)
    {
        $values = [];

        foreach ($plans as $plan) {
            /* @var Distinction $pagesExaminedPerTestDistinction */
            $pagesExaminedPerTestDistinction = $plan->getDistinctions()[$group][$key];

            $values[] = $pagesExaminedPerTestDistinction->getValue();
        }

        return sprintf(
            '%s - %s',
            min($values),
            max($values)
        );
    }

    /**
     * @param Plan[] $plans
     * @param string $group
     * @param string $key
     *
     * @return int|null
     */
    private function deriveIntegerOrNullValue($plans, $group, $key)
    {
        $values = [];
        $areAllNull = true;

        foreach ($plans as $plan) {
            /* @var Distinction $distinction */
            $distinction = $plan->getDistinctions()[$group][$key];
            $value = $distinction->getValue();

            $values[] = $value;
            if (!is_null($value)) {
                $areAllNull = false;
            }
        }

        return $areAllNull
            ? null
            : max($values);
    }

    /**
     * @param Plan[] $plans
     * @param string $group
     * @param string $key
     *
     * @return bool|null
     */
    private function deriveBooleanValue($plans, $group, $key)
    {
        $trueValueCount = 0;
        $falseValueCount = 0;

        foreach ($plans as $plan) {
            /* @var Distinction $distinction */
            $distinction = $plan->getDistinctions()[$group][$key];
            $value = $distinction->getValue();

            if ($value) {
                $trueValueCount++;
            } else {
                $falseValueCount++;
            }
        }

        if ($falseValueCount === 0) {
            return true;
        }

        if ($trueValueCount === 0) {
            return false;
        }

        return null;
    }
}
