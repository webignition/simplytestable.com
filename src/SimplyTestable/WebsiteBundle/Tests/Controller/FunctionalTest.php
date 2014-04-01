<?php

namespace SimplyTestable\WebsiteBundle\Tests\Controller;

use SimplyTestable\WebsiteBundle\Tests\Controller\BaseTest;

abstract class FunctionalTest extends BaseTest {    
    
    abstract protected function getRoute();
    
    protected function getCurrentRequestUrl($parameters = null) {
        $parameters = (is_array($parameters)) ? $parameters : array();
        
        return $this->getCurrentController()->generateUrl($this->getRoute(), $parameters);
    } 
    
    protected function publicUserNavbarContainsSignInButtonTest(\Symfony\Component\DomCrawler\Crawler $crawler) {        
        $button = $this->getNavbar($crawler)->filter('a:contains("Sign in")');        
        $this->assertEquals(1, $button->count());     
    }    
    
    protected function publicUserNavbarSignInButtonUrlTest(\Symfony\Component\DomCrawler\Crawler $crawler) {        
        $button = $this->getNavbar($crawler)->filter('a:contains("Sign in")');
        $this->assertEquals(array('/signin/'), $button->extract('href'));              
    }
    
    protected function publicUserNavbarContainsCreateAccountButtonTest(\Symfony\Component\DomCrawler\Crawler $crawler) {        
        $button = $this->getNavbar($crawler)->filter('a:contains("Create account")');        
        $this->assertEquals(1, $button->count());          
    }
    
    protected function publicUserNavbarCreateAccountButtonUrlTest(\Symfony\Component\DomCrawler\Crawler $crawler) {        
        $button = $this->getNavbar($crawler)->filter('a:contains("Create account")');        
        $this->assertEquals(array('/signup/'), $button->extract('href'));         
    }
    
    protected function privateUserNavbarContainsAccountLinkTest(\Symfony\Component\DomCrawler\Crawler $crawler) {        
        if (!$this->hasUser()) {
            $this->fail('Cannot verify authorised user navbar content; no user set');
        }
        
        $button = $this->getNavbar($crawler)->filter('a:contains("'.$this->getUser()->getUsername().'")');        
        $this->assertEquals(1, $button->count(), "Navbar does not contain account link");
    }    
    
    protected function privateUserNavbarAccountLinkUrlTest(\Symfony\Component\DomCrawler\Crawler $crawler) {        
        if (!$this->hasUser()) {
            $this->fail('Cannot verify authorised user navbar content; no user set');
        }
        
        $button = $this->getNavbar($crawler)->filter('a:contains("'.$this->getUser()->getUsername().'")');        
        $this->assertEquals(array('/account/'), $button->extract('href'));
    } 
    
    protected function privateUserNavbarContainsSignOutButtonTest(\Symfony\Component\DomCrawler\Crawler $crawler) {        
        if (!$this->hasUser()) {
            $this->fail('Cannot verify authorised user navbar content; no user set');
        }
        
        $button = $this->getNavbar($crawler)->filter('button:contains("Sign out")');        
        $this->assertEquals(1, $button->count());
    }    
    
    protected function privateUserNavbarSignOutFormUrlTest(\Symfony\Component\DomCrawler\Crawler $crawler) {        
        if (!$this->hasUser()) {
            $this->fail('Cannot verify authorised user navbar content; no user set');
        }
        
        $form = $this->getNavbar($crawler)->filter('form');        
        $this->assertEquals(array('/signout/'), $form->extract('action'));
    }    
    
    
    /**
     * 
     * @param \Symfony\Component\DomCrawler\Crawler $crawler
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    private function getNavbar(\Symfony\Component\DomCrawler\Crawler $crawler) {
        return $crawler->filter('.navbar');
    }
    
    protected function domNodeToHtml(\DOMNode $node) {
        return $node->ownerDocument->saveHTML($node);        
    }
    
    protected function assertDomNodeContainsNext(\DOMNode $node, $text) {
        $markup = $this->domNodeToHtml($node); 
        $content = strip_tags($markup);
        $content = preg_replace('/\s/', ' ', $content);
        
        while (substr_count($content, '  ')) {
            $content = str_replace('  ', ' ', $content);
        }
        
        $content = trim($content);

        if (substr_count($content, $text) < 1) {
            $this->fail('Markup "'.$markup.'" does not contain text "'.$text.'"');
        }
    }
    
    protected function assertDomNodeDoesNotContainNext(\DOMNode $node, $text) {
        $markup = $this->domNodeToHtml($node);
        
        if (substr_count($markup, $text) > 0) {
            $this->fail('Markup "'.$markup.'" does contain text "'.$text.'"');
        }
    }    
    
    
    protected function assertTitleContainsText($crawler, $text) {
        $titles = $crawler->filter('title');        
        $this->assertEquals(1, $titles->count());
        
        foreach ($titles as $title) {
            $this->assertDomNodeContainsNext($title, $text);
        }          
    }
    
    
    protected function assertTitleDoesNotContainText($crawler, $text) {
        $titles = $crawler->filter('title');        
        $this->assertEquals(1, $titles->count());
        
        foreach ($titles as $title) {
            $this->assertDomNodeDoesNotContainNext($title, $text);
        }          
    }
    
}


