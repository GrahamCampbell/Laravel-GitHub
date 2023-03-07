<?php

declare(strict_types=1);

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\GitHub\Auth;

use GrahamCampbell\GitHub\Auth\Authenticator\ApplicationAuthenticator;
use GrahamCampbell\GitHub\Auth\Authenticator\JwtAuthenticator;
use GrahamCampbell\GitHub\Auth\Authenticator\PrivateKeyAuthenticator;
use GrahamCampbell\GitHub\Auth\Authenticator\TokenAuthenticator;
use GrahamCampbell\GitHub\Auth\AuthenticatorFactory;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;
use InvalidArgumentException;
use TypeError;

/**
 * This is the authenticator factory test class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class AuthenticatorFactoryTest extends AbstractTestCase
{
    public function testMakeApplicationAuthenticator(): void
    {
        $factory = new AuthenticatorFactory();

        self::assertInstanceOf(ApplicationAuthenticator::class, $factory->make('application'));
    }

    public function testMakeJwtAuthenticator(): void
    {
        $factory = new AuthenticatorFactory();

        self::assertInstanceOf(JwtAuthenticator::class, $factory->make('jwt'));
    }

    public function testMakeTokenAuthenticator(): void
    {
        $factory = new AuthenticatorFactory();

        self::assertInstanceOf(TokenAuthenticator::class, $factory->make('token'));
    }

    public function testMakePrivateKeyAuthenticator(): void
    {
        $factory = new AuthenticatorFactory();

        self::assertInstanceOf(PrivateKeyAuthenticator::class, $factory->make('private'));
    }

    public function testMakeInvalidAuthenticator(): void
    {
        $factory = new AuthenticatorFactory();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported authentication method [foo].');

        $factory->make('foo');
    }

    public function testMakeNoAuthenticator(): void
    {
        $factory = new AuthenticatorFactory();

        $this->expectException(TypeError::class);

        $factory->make(null);
    }
}
