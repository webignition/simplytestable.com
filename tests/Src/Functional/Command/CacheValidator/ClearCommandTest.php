<?php

namespace App\Tests\Src\Functional\Command\CacheValidator;

use Doctrine\ORM\EntityRepository;
use App\Command\CacheValidator\ClearCommand;
use App\Entity\CacheValidatorHeaders;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use App\Tests\Src\Functional\AbstractWebTestCase;

class ClearCommandTest extends AbstractWebTestCase
{
    /**
     * @dataProvider runDataProvider
     *
     * @param CacheValidatorHeaders[] $cacheValidatorHeadersCollection
     * @param int $expectedReturnCode
     */
    public function testRun($cacheValidatorHeadersCollection, $expectedReturnCode)
    {
        $entityManager = self::$container->get('doctrine.orm.default_entity_manager');

        /* @var EntityRepository $entityRepository */
        $entityRepository = $entityManager->getRepository(CacheValidatorHeaders::class);

        $this->assertCount(0, $entityRepository->findAll());

        $entityManager = self::$container->get('doctrine.orm.default_entity_manager');
        foreach ($cacheValidatorHeadersCollection as $cacheValidatorHeaders) {
            $entityManager->persist($cacheValidatorHeaders);
            $entityManager->flush($cacheValidatorHeaders);
        }

        $this->assertCount(count($cacheValidatorHeadersCollection), $entityRepository->findAll());

        $command = self::$container->get(ClearCommand::class);

        $returnCode = $command->run(new ArrayInput([]), new NullOutput());

        $this->assertEquals($expectedReturnCode, $returnCode);
        $this->assertCount(0, $entityRepository->findAll());
    }

    /**
     * @return array
     */
    public function runDataProvider()
    {
        return [
            'none to clear' => [
                'cacheValidatorHeadersCollection' => [],
                'expectedReturnCode' => 0,
            ],
            'one to clear' => [
                'cacheValidatorHeadersCollection' => [
                    $this->createCacheValidatorHeaders('foo', new \DateTime()),
                ],
                'expectedReturnCode' => 0,
            ],
        ];
    }

    /**
     * @param string $identifier
     * @param \DateTime $lastModifiedDate
     *
     * @return CacheValidatorHeaders
     */
    private function createCacheValidatorHeaders($identifier, \DateTime $lastModifiedDate)
    {
        $cacheValidatorHeaders = new CacheValidatorHeaders();
        $cacheValidatorHeaders->setIdentifier($identifier);
        $cacheValidatorHeaders->setLastModifiedDate($lastModifiedDate);

        return $cacheValidatorHeaders;
    }
}
