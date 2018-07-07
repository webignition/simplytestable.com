<?php

namespace AppBundle\Model\Plan;

interface DistinctionInterface
{
    const DISTINCTION_GROUP_TEST_LIMITATIONS = 'test_limitations';
    const DISTINCTION_GROUP_ACCESS_TO_RESULTS = 'access_to_results';
    const DISTINCTION_GROUP_URL_DISCOVERY = 'url_discovery';
    const DISTINCTION_GROUP_TEST_TYPES = 'test_types';
    const DISTINCTION_GROUP_ADVANCED_OPTIONS = 'advanced_options';

    const DISTINCTION_FULL_SITE_TESTS_PER_SITE = 'full_site_tests_per_site';
    const DISTINCTION_SINGLE_PAGE_TESTS_PER_PAGE = 'single_page_tests_per_page';
    const DISTINCTION_PAGES_EXAMINED_PER_TEST = 'pages_examined_per_test';
    const DISTINCTION_CREDITS_PER_MONTH = 'credits_per_month';
    const DISTINCTION_RESULTS_AVAILABLE_FOR = 'results_available_for';
    const DISTINCTION_PRIVATE_TESTS = 'private_tests';
    const DISTINCTION_READ_ONLY_REPORTS = 'read_only_reports';
    const DISTINCTION_DISCOVERY_VIA_SITEMAP = 'discovery_via_sitemap';
    const DISTINCTION_DISCOVERY_VIA_CRAWL = 'discovery_via_crawl';
    const DISTINCTION_HTML_VALIDATION = 'html_validation';
    const DISTINCTION_CSS_VALIDATION = 'css_validation';
    const DISTINCTION_JS_STATIC_ANALYSIS = 'js_static_analysis';
    const DISTINCTION_LINK_INTEGRITY_CHECKING = 'link_integrity_checking';
    const DISTINCTION_HTTPS_SITES = 'https_sites';
    const DISTINCTION_HTTP_AUTHENTICATION = 'http_authentication';
    const DISTINCTION_CUSTOM_COOKIES = 'custom_cookies';

    /**
     * @return string
     */
    public function getId();

    /**
     * @return int
     */
    public function getValue();

    /**
     * @return bool
     */
    public function isInt();

    /**
     * @return bool
     */
    public function isInfinity();

    /**
     * @return bool
     */
    public function isBool();
}
