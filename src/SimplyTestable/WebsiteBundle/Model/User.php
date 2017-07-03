<?php
namespace SimplyTestable\WebsiteBundle\Model;

class User
{
    /**
      * @var string
     */
    private $username = null;

    /**
     * @var string
     */
    private $password = null;

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function equals(User $user)
    {
        return $this->getUsername() == $user->getUsername();
    }
}
