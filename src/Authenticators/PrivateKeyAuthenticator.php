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

use GitHub\Client;
use InvalidArgumentException;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Rsa\Sha256;

/**
 * This is private key github authenticator.
 *
 * @author Pavel Zhytomirsky <r3volut1oner@gmail.com>
 */
class PrivateKeyAuthenticator extends AbstractAuthenticator implements AuthenticatorInterface
{
    /**
     * Build JWT token from provided private key file and authenticate with it.
     *
     * @param array $config
     *
     * @return Client|null
     */
    public function authenticate(array $config)
    {
        if (!$this->client) {
            throw new InvalidArgumentException('The client instance was not given to the private key authenticator.');
        }

        if (!array_key_exists('file', $config)) {
            throw new InvalidArgumentException('Private key authentication require `file` config.');
        }

        if (!file_exists($config['file'])) {
            throw new InvalidArgumentException('Private key authentication got not exists file.');
        }

        if (!array_key_exists('issuer', $config)) {
            throw new InvalidArgumentException('Private key authentication require `issuer` config.');
        }

        $token = (new Builder())
            ->setIssuedAt((new \DateTime())->getTimestamp())
            ->setExpiration((new \DateTime('+5 minutes'))->getTimestamp())
            ->setIssuer($config['issuer'])
            ->sign(new Sha256(), 'file://'.$config['file'])
            ->getToken();

        $this->client->authenticate($token, Client::AUTH_JWT);

        return $this->client;
    }
}
