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
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * {@inheritdoc}
     */
    public function getIsListed()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getShortTitle()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getLongTitle()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTitle()
    {
        return '';
    }

    /**
     * {@inheritdoc}
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
            DistinctionInterface::DISTINCTION_GROUP_TEST_LIMITATIONS => [
                DistinctionInterface::DISTINCTION_FULL_SITE_TESTS_PER_SITE => new Distinction(
                    DistinctionInterface::DISTINCTION_FULL_SITE_TESTS_PER_SITE,
                    $this->deriveIntegerOrNullValue(
                        $plans,
                        'test_limitations',
                        'full_site_tests_per_site'
                    )
                ),
                DistinctionInterface::DISTINCTION_SINGLE_PAGE_TESTS_PER_PAGE => new Distinction(
                    DistinctionInterface::DISTINCTION_SINGLE_PAGE_TESTS_PER_PAGE,
                    $this->deriveIntegerOrNullValue(
                        $plans,
                        'test_limitations',
                        'single_page_tests_per_page'
                    )
                ),
                DistinctionInterface::DISTINCTION_PAGES_EXAMINED_PER_TEST => new Distinction(
                    DistinctionInterface::DISTINCTION_PAGES_EXAMINED_PER_TEST,
                    $this->deriveNumericRange(
                        $plans,
                        'test_limitations',
                        'pages_examined_per_test'
                    )
                ),
                DistinctionInterface::DISTINCTION_CREDITS_PER_MONTH => new Distinction(
                    DistinctionInterface::DISTINCTION_CREDITS_PER_MONTH,
                    $this->deriveNumericRange(
                        $plans,
                        'test_limitations',
                        'credits_per_month'
                    )
                ),
            ],
            DistinctionInterface::DISTINCTION_GROUP_ACCESS_TO_RESULTS => [
                DistinctionInterface::DISTINCTION_RESULTS_AVAILABLE_FOR => new Distinction(
                    DistinctionInterface::DISTINCTION_RESULTS_AVAILABLE_FOR,
                    'Forever'
                ),
                DistinctionInterface::DISTINCTION_PRIVATE_TESTS => new Distinction(
                    DistinctionInterface::DISTINCTION_PRIVATE_TESTS,
                    $this->deriveBooleanValue(
                        $plans,
                        DistinctionInterface::DISTINCTION_GROUP_ACCESS_TO_RESULTS,
                        DistinctionInterface::DISTINCTION_PRIVATE_TESTS
                    )
                ),
                DistinctionInterface::DISTINCTION_READ_ONLY_REPORTS => new Distinction(
                    DistinctionInterface::DISTINCTION_READ_ONLY_REPORTS,
                    $this->deriveBooleanValue(
                        $plans,
                        DistinctionInterface::DISTINCTION_GROUP_ACCESS_TO_RESULTS,
                        DistinctionInterface::DISTINCTION_READ_ONLY_REPORTS
                    )
                ),
            ],
            DistinctionInterface::DISTINCTION_GROUP_URL_DISCOVERY => [
                DistinctionInterface::DISTINCTION_DISCOVERY_VIA_SITEMAP => new Distinction(
                    DistinctionInterface::DISTINCTION_DISCOVERY_VIA_SITEMAP,
                    $this->deriveBooleanValue(
                        $plans,
                        DistinctionInterface::DISTINCTION_GROUP_URL_DISCOVERY,
                        DistinctionInterface::DISTINCTION_DISCOVERY_VIA_SITEMAP
                    )
                ),
                DistinctionInterface::DISTINCTION_DISCOVERY_VIA_CRAWL => new Distinction(
                    DistinctionInterface::DISTINCTION_DISCOVERY_VIA_CRAWL,
                    $this->deriveBooleanValue(
                        $plans,
                        DistinctionInterface::DISTINCTION_GROUP_URL_DISCOVERY,
                        DistinctionInterface::DISTINCTION_DISCOVERY_VIA_CRAWL
                    )
                ),
            ],
            DistinctionInterface::DISTINCTION_GROUP_TEST_TYPES => [
                DistinctionInterface::DISTINCTION_HTML_VALIDATION => new Distinction(
                    DistinctionInterface::DISTINCTION_HTML_VALIDATION,
                    $this->deriveBooleanValue(
                        $plans,
                        DistinctionInterface::DISTINCTION_GROUP_TEST_TYPES,
                        DistinctionInterface::DISTINCTION_HTML_VALIDATION
                    )
                ),
                DistinctionInterface::DISTINCTION_CSS_VALIDATION => new Distinction(
                    DistinctionInterface::DISTINCTION_CSS_VALIDATION,
                    $this->deriveBooleanValue(
                        $plans,
                        DistinctionInterface::DISTINCTION_GROUP_TEST_TYPES,
                        DistinctionInterface::DISTINCTION_CSS_VALIDATION
                    )
                ),
                DistinctionInterface::DISTINCTION_JS_STATIC_ANALYSIS => new Distinction(
                    DistinctionInterface::DISTINCTION_JS_STATIC_ANALYSIS,
                    $this->deriveBooleanValue(
                        $plans,
                        DistinctionInterface::DISTINCTION_GROUP_TEST_TYPES,
                        DistinctionInterface::DISTINCTION_JS_STATIC_ANALYSIS
                    )
                ),
                DistinctionInterface::DISTINCTION_LINK_INTEGRITY_CHECKING => new Distinction(
                    DistinctionInterface::DISTINCTION_LINK_INTEGRITY_CHECKING,
                    $this->deriveBooleanValue(
                        $plans,
                        DistinctionInterface::DISTINCTION_GROUP_TEST_TYPES,
                        DistinctionInterface::DISTINCTION_LINK_INTEGRITY_CHECKING
                    )
                ),
            ],
            DistinctionInterface::DISTINCTION_GROUP_ADVANCED_OPTIONS => [
                DistinctionInterface::DISTINCTION_HTTPS_SITES => new Distinction(
                    DistinctionInterface::DISTINCTION_HTTPS_SITES,
                    $this->deriveBooleanValue(
                        $plans,
                        DistinctionInterface::DISTINCTION_GROUP_ADVANCED_OPTIONS,
                        DistinctionInterface::DISTINCTION_HTTPS_SITES
                    )
                ),
                DistinctionInterface::DISTINCTION_HTTP_AUTHENTICATION => new Distinction(
                    DistinctionInterface::DISTINCTION_HTTP_AUTHENTICATION,
                    $this->deriveBooleanValue(
                        $plans,
                        DistinctionInterface::DISTINCTION_GROUP_ADVANCED_OPTIONS,
                        DistinctionInterface::DISTINCTION_HTTP_AUTHENTICATION
                    )
                ),
                DistinctionInterface::DISTINCTION_CUSTOM_COOKIES => new Distinction(
                    DistinctionInterface::DISTINCTION_CUSTOM_COOKIES,
                    $this->deriveBooleanValue(
                        $plans,
                        DistinctionInterface::DISTINCTION_GROUP_ADVANCED_OPTIONS,
                        DistinctionInterface::DISTINCTION_CUSTOM_COOKIES
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
