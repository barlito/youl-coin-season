<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class EntityManagerContext extends TestCase implements Context
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected SerializerInterface $serializer,
        protected string $entityNamespace,
    ) {
        parent::__construct();
    }

    /**
     * @Then I create a ":entityClass" entity with data:
     */
    public function iCreateAEntityWithData($entityClass, PyStringNode $data)
    {
        $entity = $this->serializer->deserialize($data->getRaw(), $this->getRepository($entityClass)->getClassName(), 'json');

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    protected function getRepository(string $entityClass): ObjectRepository
    {
        return $this->entityManager->getRepository($this->entityNamespace . '\\' . $entityClass);
    }
}
