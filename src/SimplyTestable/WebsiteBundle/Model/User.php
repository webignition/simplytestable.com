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
     * @var string
     */
    private $password = null;    
        
    
    
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
     * @param string $password
     * @return SimplyTestable\WebsiteBundle\Model\User
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }
    
    
    /**
     * 
     * @return string
     */
    public function getPassword() {
        return $this->password;
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