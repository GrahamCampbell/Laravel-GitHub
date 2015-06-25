<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\GitHub\Authenticators;

use InvalidArgumentException;

/**
 * This is the authenticator factory class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AuthenticatorFactory
{
    /**
     * Make a new authenticator instance.
     *
     * @param string $method
     *
     * @return \GrahamCampbell\GitHub\Authenticators\AuthenticatorInterface
     */
    public function make($method)
    {
        switch ($method) {
            case 'application':
                return new ApplicationAuthenticator();
            case 'password':
                return new PasswordAuthenticator();
            case 'token':
                return new TokenAuthenticator();
        }

        throw new InvalidArgumentException("Unsupported authentication method [$method].");
    }
}
