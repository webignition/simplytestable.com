<?php

namespace Tests\AppBundle\Functional;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\Factory\TestServiceProvider;
use webignition\SimplyTestableUserModel\User;
use webignition\SimplyTestableUserSerializer\UserSerializer;

abstract class AbstractWebTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var TestServiceProvider
     */
    protected $testServiceProvider;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->client = static::createClient();
        $this->testServiceProvider = new TestServiceProvider(self::$container);

        self::$container->get('doctrine')->getConnection()->beginTransaction();
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
     * @param array $options
     *
     * @return Crawler
     */
    protected function getCrawler($options)
    {
        if (!isset($options['url'])) {
            $options['url'] = '';
        }

        if (!isset($options['method'])) {
            $options['method'] = 'GET';
        }

        if (!isset($options['parameters'])) {
            $options['parameters'] = [];
        }

        if (!isset($options['files'])) {
            $options['files'] = [];
        }

        if (!isset($options['server'])) {
            $options['server'] = [];
        }

        if ($this->hasUser()) {
            $userSerializerService = self::$container->get('test.' . strtolower(UserSerializer::class));

            $cookie = new Cookie(
                'simplytestable-user',
                $userSerializerService->serializeToString($this->user)
            );

            $this->client->getCookieJar()->set($cookie);
        }

        $crawler = $this->client->request(
            $options['method'],
            $options['url'],
            $options['parameters'],
            $options['files'],
            $options['server']
        );

        return $crawler;
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

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        self::$container->get('doctrine')->getConnection()->close();

        parent::tearDown();

        $refl = new \ReflectionObject($this);
        foreach ($refl->getProperties() as $prop) {
            if (!$prop->isStatic() && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }
    }
}
