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
