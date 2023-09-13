<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\DiscordClient;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Wohali\OAuth2\Client\Provider\Discord;
use Wohali\OAuth2\Client\Provider\DiscordResourceOwner;

class DiscordController extends AbstractController
{
    /**
     * Link to this controller to start the "connect" process
     */
    #[Route('/connect/discord', name: 'connect_discord_start')]
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('discord')
            ->redirect([
                'identify', 'email'
            ]);
    }

    /**
     * After going to Discord, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     */
    #[Route('/connect/discord/check', name: 'connect_discord_check')]
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        /** @var DiscordClient $client */
        $client = $clientRegistry->getClient('discord');

        try {
            /** @var DiscordResourceOwner $user */
            $user = $client->fetchUser();

            dd($user);
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            dd($e);
        }
    }
}
