<?php

declare(strict_types=1);

namespace App\DTO\Messenger;

use Symfony\Component\Validator\Constraints as Assert;

class DiscordUserDTO
{
    #[Assert\NotBlank(message: 'The discordId value should not be blank.')]
    private string $discordId;

    private ?string $name = null;

    public function getDiscordId(): string
    {
        return $this->discordId;
    }

    public function setDiscordId(string $discordId): DiscordUserDTO
    {
        $this->discordId = $discordId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): DiscordUserDTO
    {
        $this->name = $name;

        return $this;
    }
}
