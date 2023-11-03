<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use App\Service\Messenger\Serializer\TransactionNotificationSerializer;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\ConsumedByWorkerStamp;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;

final class MessengerContext extends KernelTestCase implements Context
{
    private readonly MessageBusInterface $messageBus;
    private readonly TransactionNotificationSerializer $transactionNotificationSerializer;
    private readonly EntityManagerInterface $testEntityManager;

    public function __construct()
    {
        $this->messageBus = self::getContainer()->get(MessageBusInterface::class);
        $this->transactionNotificationSerializer = self::getContainer()->get(TransactionNotificationSerializer::class);
        $this->testEntityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    /**
     * @BeforeStep
     */
    public function beforeStep(): void
    {
        $this->testEntityManager->clear();
    }

    /**
     * @When I send and consume a TransactionNotificationMessage to the queue with body:
     */
    public function iSendATransactionNotificationMessageToTheQueueWithBody(PyStringNode $string)
    {
        // need to improve this step to be agnostic from the message type and fetch the right serializer
        // need to find the serializer linked to the type of message sent
        $envelope = $this->decodeString($string);

        try {
            $this->messageBus->dispatch($envelope->with(new ReceivedStamp('transaction_notification'), new ConsumedByWorkerStamp()));
        } catch (\Throwable $e) {
            // do nothing on exception message thrown while dispatching
            // Exception message should be tested in the logger step
        }
    }

    private function decodeString(PyStringNode $string): Envelope
    {
        return $this->transactionNotificationSerializer->decode(['body' => $string->getRaw()]);
    }
}
