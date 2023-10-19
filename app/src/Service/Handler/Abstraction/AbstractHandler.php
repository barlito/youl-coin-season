<?php

declare(strict_types=1);

namespace App\Service\Handler\Abstraction;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

// todo put this abstractHandler in barlito/utils
abstract class AbstractHandler
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
    ) {
    }

    /**
     * @throws ConstraintDefinitionException
     */
    protected function validate(mixed $data, Constraint | array $constraints = null, string | GroupSequence | array $groups = []): void
    {
        $violations = $this->validator->validate($data, $constraints, $groups);

        if (\count($violations) > 0) {
            $errorsString = (string) $violations;
            throw new ConstraintDefinitionException($errorsString);
        }
    }

    protected function persistOneEntity(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
