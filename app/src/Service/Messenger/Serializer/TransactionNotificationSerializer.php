<?php

declare(strict_types=1);

namespace App\Service\Messenger\Serializer;

use App\Message\TransactionMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as MessengerSerializerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class TransactionNotificationSerializer implements MessengerSerializerInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        dd($body);
        // todo add a rule on Season status and value active to prevent multiple active season ( like for the bank wallet on exchange )
        // todo create a DTO and a handler to handle the message received and update the user score of the current Season

        $transactionNotificationMessage = $this->serializer->deserialize($body, TransactionMessage::class, 'json', [BackedEnumNormalizer::ALLOW_INVALID_VALUES => true, ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true]);

        return new Envelope($transactionNotificationMessage);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @throws ExceptionInterface
     */
    public function encode(Envelope $envelope): array
    {
        throw new \RuntimeException('This app should not send this type of messages.');
    }
}
