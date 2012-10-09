<?php

namespace SimplyTestable\WebsiteBundle\Model;

class Testimonial {
    
    /**
     *
     * @var string
     */
    private $content;
    
    /**
     *
     * @var string
     */
    private $name;
    
    
    /**
     *
     * @var string
     */
    private $url;
    
    
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
    
    public function getUrl()
    {
        return $this->url;
    }    
    
    
}
