<?php

namespace SimplyTestable\WebsiteBundle\Tests\Functional;

use SimplyTestable\WebsiteBundle\Model\User;
use SimplyTestable\WebsiteBundle\Services\UserSerializerService;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractWebTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Application
     */
    private $application;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->client = static::createClient();
        $this->container = $this->client->getKernel()->getContainer();
        $this->application = new Application(self::$kernel);
        $this->application->setAutoExit(false);
    }

    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    protected function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    protected function getUser()
    {
        return $this->user;
    }

    /**
     * @return boolean
     */
    protected function hasUser()
    {
        return !is_null($this->user);
    }

    /**
     * @param string $url
     * @param string $method
     *
     * @return Crawler
     */
    protected function getCrawler($url, $method = 'GET')
    {
        if ($this->hasUser()) {
            $cookie = new Cookie(
                'simplytestable-user',
                $this->getUserSerializerService()->serializeToString($this->user)
            );

            $this->client->getCookieJar()->set($cookie);
        }

        $crawler = $this->client->request($method, $url);

        return $crawler;
    }

    /**
     * @return UserSerializerService
     */
    protected function getUserSerializerService()
    {
        return $this->container->get('simplytestable.services.userserializerservice');
    }

    /**
     * @return Response
     */
    protected function getClientResponse()
    {
        /* @var Response $response */
        $response = $this->client->getResponse();

        return $response;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return User
     */
    protected function createUser($email, $password = 'password')
    {
        $user = new User();
        $user->setUsername($email);
        $user->setPassword($password);

        return $user;
    }
}
