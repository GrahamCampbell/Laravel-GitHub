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

namespace GrahamCampbell\Tests\GitHub\Authenticators;

use GrahamCampbell\GitHub\Authenticators\ApplicationAuthenticator;
use GrahamCampbell\GitHub\Authenticators\AuthenticatorFactory;
use GrahamCampbell\GitHub\Authenticators\JwtAuthenticator;
use GrahamCampbell\GitHub\Authenticators\PasswordAuthenticator;
use GrahamCampbell\GitHub\Authenticators\PrivateKeyAuthenticator;
use GrahamCampbell\GitHub\Authenticators\TokenAuthenticator;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;
use InvalidArgumentException;
use TypeError;

/**
 * This is the authenticator factory test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AuthenticatorFactoryTest extends AbstractTestCase
{
    public function testMakeApplicationAuthenticator()
    {
        $factory = $this->getFactory();

        $return = $factory->make('application');

        $this->assertInstanceOf(ApplicationAuthenticator::class, $return);
    }

    public function testMakeJwtAuthenticator()
    {
        $factory = $this->getFactory();

        $return = $factory->make('jwt');

        $this->assertInstanceOf(JwtAuthenticator::class, $return);
    }

    public function testMakePasswordAuthenticator()
    {
        $factory = $this->getFactory();

        $return = $factory->make('password');

        $this->assertInstanceOf(PasswordAuthenticator::class, $return);
    }

    public function testMakeTokenAuthenticator()
    {
        $factory = $this->getFactory();

        $return = $factory->make('token');

        $this->assertInstanceOf(TokenAuthenticator::class, $return);
    }

    public function testMakePrivateKeyAuthenticator()
    {
        $factory = $this->getFactory();

        $return = $factory->make('private');

        $this->assertInstanceOf(PrivateKeyAuthenticator::class, $return);
    }

    public function testMakeInvalidAuthenticator()
    {
        $factory = $this->getFactory();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported authentication method [foo].');

        $factory->make('foo');
    }

    public function testMakeNoAuthenticator()
    {
        $factory = $this->getFactory();

        $this->expectException(TypeError::class);

        $factory->make(null);
    }

    protected function getFactory()
    {
        return new AuthenticatorFactory();
    }
}
