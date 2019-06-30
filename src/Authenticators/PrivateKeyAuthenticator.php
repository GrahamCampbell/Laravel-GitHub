<?php

declare(strict_types=1);

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\GitHub\Authenticators;

use DateTimeImmutable;
use GitHub\Client;
use InvalidArgumentException;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;

/**
 * This is private key github authenticator.
 *
 * @author Pavel Zhytomirsky <r3volut1oner@gmail.com>
 */
class PrivateKeyAuthenticator extends AbstractAuthenticator
{
    /**
     * Build JWT token from provided private key file and authenticate with it.
     *
     * @param array $config
     *
     * @throws \Exception
     *
     * @return \Github\Client
     */
    public function authenticate(array $config)
    {
        if (!$this->client) {
            throw new InvalidArgumentException('The client instance was not given to the private key authenticator.');
        }

        if (!array_key_exists('keyPath', $config)) {
            throw new InvalidArgumentException('The private key authenticator requires the key path to be configured.');
        }

        if (!array_key_exists('appId', $config)) {
            throw new InvalidArgumentException('The private key authenticator requires the application id to be configured.');
        }

        $token = (new Builder())
            ->expiresAt((new DateTimeImmutable('+10 minutes'))->getTimestamp())
            ->issuedAt((new DateTimeImmutable())->getTimestamp())
            ->issuedBy($config['appId'])
            ->getToken(new Sha256(), new Key('file://'.$config['keyPath']));

        $this->client->authenticate($token, Client::AUTH_JWT);

        return $this->client;
    }
}
