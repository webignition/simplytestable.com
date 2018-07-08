<?php

namespace App\Services;

use App\Model\Testimonial;

class TestimonialService
{
    /**
     * @var array
     */
    private $testimonialData = array(
        array(
            'content' =>
                'I like to validate a site before it goes live, but for large sites this is a pain. '
                .'However, simplytestable takes the pain right out of it. Fire off the test, make '
                .'yourself a cuppa and bickety bam! Your whole site validated.',
            'name' => 'Ian Jenkins (@jenko)',
            'url' => 'https://twitter.com/jenko/'
        ),
        array(
            'content' =>
                'Simply Testable saves us time and effort when it comes to web testing and QA. It\'s quick to '
                .'run, even on our larger sites, and the reports are invaluable. Simply Testable is now a regular '
                .'part of our QA process.',
            'name' => 'Matcha Labs',
            'url' => 'http://www.matchalabs.com/'
        )
    );

    /**
     * @return Testimonial
     */
    public function getRandom()
    {
        $testimonialIndex = rand(0, $this->getTestimonialTotal() - 1);
        $testimonialData = $this->testimonialData[$testimonialIndex];

        $testimonial = new Testimonial();
        $testimonial->setContent($testimonialData['content']);
        $testimonial->setName($testimonialData['name']);
        $testimonial->setUrl($testimonialData['url']);

        return $testimonial;
    }

    /**
     * @return int
     */
    private function getTestimonialTotal()
    {
        return count($this->testimonialData);
    }
}
