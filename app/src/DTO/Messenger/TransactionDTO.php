<?php

declare(strict_types=1);

namespace App\DTO\Messenger;

use Symfony\Component\Validator\Constraints as Assert;

class TransactionDTO
{
    #[Assert\NotBlank(message: 'The amount value should not be blank.')]
    private string $amount;

    #[Assert\NotBlank(message: 'The walletFrom value should not be blank.')]
    #[Assert\Valid]
    private WalletDTO $walletFrom;

    #[Assert\NotBlank(message: 'The walletTo value should not be blank.')]
    #[Assert\Valid]
    private WalletDTO $walletTo;

    private ?string $externalIdentifier = null;

    private ?string $type = null;

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): TransactionDTO
    {
        $this->amount = $amount;

        return $this;
    }

    public function getWalletFrom(): WalletDTO
    {
        return $this->walletFrom;
    }

    public function setWalletFrom(WalletDTO $walletFrom): TransactionDTO
    {
        $this->walletFrom = $walletFrom;

        return $this;
    }

    public function getWalletTo(): WalletDTO
    {
        return $this->walletTo;
    }

    public function setWalletTo(WalletDTO $walletTo): TransactionDTO
    {
        $this->walletTo = $walletTo;

        return $this;
    }

    public function getExternalIdentifier(): ?string
    {
        return $this->externalIdentifier;
    }

    public function setExternalIdentifier(?string $externalIdentifier): TransactionDTO
    {
        $this->externalIdentifier = $externalIdentifier;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): TransactionDTO
    {
        $this->type = $type;

        return $this;
    }
}
