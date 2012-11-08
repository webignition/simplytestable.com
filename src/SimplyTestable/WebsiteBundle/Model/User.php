<?php
namespace SimplyTestable\WebsiteBundle\Model;

class User {    
    
    /**
     *
     * @var string
     */
    private $username = null; 
    
    
    /**
     * 
     * @param string $username
     * @return SimplyTestable\WebsiteBundle\Model\User
     */
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }
    
    
    /**
     * 
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }
    
    
    /**
     * 
     * @param SimplyTestable\WebsiteBundle\Model\User $user
     * @return boolean
     */
    public function equals(User $user) {
        return $this->getUsername() == $user->getUsername();
    }
    
}