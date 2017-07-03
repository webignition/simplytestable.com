<?php
namespace SimplyTestable\WebsiteBundle\Services;

class UserAgentDetector
{
    /**
     * @var string
     */
    private $userAgentString;

    /**
     * @param $userAgentString
     */
    public function setUserAgentString($userAgentString)
    {
        $this->userAgentString = $userAgentString;
    }

    /**
     * @return bool
     */
    public function isIE8()
    {
        if (!preg_match('/msie 8\.[0-9]+/i', $this->userAgentString)) {
            return false;
        }

        if (preg_match('/opera/i', $this->userAgentString)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isIE7()
    {
        if (!preg_match('/msie 7\.[0-9]+/i', $this->userAgentString)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isIE6()
    {
        if (!preg_match('/msie 6\.[0-9]+/i', $this->userAgentString)) {
            return false;
        }

        if (preg_match('/opera/i', $this->userAgentString)) {
            return false;
        }

        if (preg_match('/msie 8.[0-9]+/i', $this->userAgentString)) {
            return false;
        }

        return true;
    }
}
