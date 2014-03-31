<?php
namespace SimplyTestable\WebsiteBundle\Services;

use SimplyTestable\WebsiteBundle\Model\User;

class UserService {    
    
    const PUBLIC_USER_USERNAME = 'public';
    const PUBLIC_USER_PASSWORD = 'public';
    
    
    /**
     *
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;
    
    
    /**
     *
     * @var \SimplyTestable\WebsiteBundle\Services\UserSerializerService
     */
    private $userSerializerService;
    
    
    public function __construct(
        \Symfony\Component\HttpFoundation\Session\Session $session,
        \SimplyTestable\WebsiteBundle\Services\UserSerializerService $userSerializerService
    ) {
        $this->session = $session;
        $this->userSerializerService = $userSerializerService;
    }     

    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Model\User
     */
    public function getPublicUser() {
        $user = new User();
        $user->setUsername(static::PUBLIC_USER_USERNAME);
        $user->setPassword(static::PUBLIC_USER_PASSWORD);
        return $user;
    }
    
    /**
     * 
     * @param \SimplyTestable\WebsiteBundle\Model\User $user
     * @return boolean
     */
    public function isPublicUser(User $user) {
        $comparatorUser = new User();
        $comparatorUser->setUsername(strtolower($user->getUsername()));
        
        return $this->getPublicUser()->equals($comparatorUser);
    }    
    
    /**
     * 
     * @param \SimplyTestable\WebsiteBundle\Model\User $user
     */
    public function setUser(User $user) {
        $this->session->set('user', $this->userSerializerService->serialize($user));
    }
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Model\User
     */
    public function getUser() {
        if (is_null($this->session->get('user'))) {
            $this->setUser($this->getPublicUser());
        }
        
        return $this->userSerializerService->unserialize($this->session->get('user'));
    }
    
    
    public function clearUser() {
        $this->session->set('user', null);
    }
    
}