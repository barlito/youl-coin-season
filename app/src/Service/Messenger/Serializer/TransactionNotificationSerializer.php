<?php

declare(strict_types=1);

namespace App\Service\Messenger\Serializer;

use App\DTO\Messenger\TransactionDTO;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as MessengerSerializerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
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
        $transactionNotificationMessage = $this->serializer->deserialize($body, TransactionDTO::class, 'json');

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
