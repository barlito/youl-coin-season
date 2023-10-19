<?php

declare(strict_types=1);

namespace App\DTO\Messenger;

use Symfony\Component\Validator\Constraints as Assert;

class WalletDTO
{
    #[Assert\NotBlank(message: 'The amount value should not be blank.')]
    private string $amount;

    #[Assert\NotBlank(message: 'The DiscordUser value should not be blank.', allowNull: true)]
    #[Assert\Valid]
    private ?DiscordUserDTO $discordUser = null;

    #[Assert\NotBlank(message: 'The Wallet Type value should not be blank.')]
    private string $type;

    private ?string $name = null;

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): WalletDTO
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDiscordUser(): ?DiscordUserDTO
    {
        return $this->discordUser;
    }

    public function setDiscordUser(?DiscordUserDTO $discordUser): WalletDTO
    {
        $this->discordUser = $discordUser;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): WalletDTO
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): WalletDTO
    {
        $this->name = $name;

        return $this;
    }
}
