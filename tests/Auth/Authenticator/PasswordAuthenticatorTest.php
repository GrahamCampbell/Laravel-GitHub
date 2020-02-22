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

namespace GrahamCampbell\Tests\GitHub\Auth\Authenticators;

use Github\Client;
use GrahamCampbell\GitHub\Auth\Authenticator\PasswordAuthenticator;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;
use InvalidArgumentException;
use Mockery;

/**
 * This is the password authenticator test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class PasswordAuthenticatorTest extends AbstractTestCase
{
    public function testMakeWithMethod()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('authenticate')->once()
            ->with('your-username', 'your-password', 'http_password');

        $return = $authenticator->with($client)->authenticate([
            'username' => 'your-username',
            'password' => 'your-password',
            'method'   => 'password',
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    public function testMakeWithoutMethod()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('authenticate')->once()
            ->with('your-username', 'your-password', 'http_password');

        $return = $authenticator->with($client)->authenticate([
            'username' => 'your-username',
            'password' => 'your-password',
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    public function testMakeWithoutUsername()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The password authenticator requires a username and password.');

        $authenticator->with($client)->authenticate([
            'password' => 'your-password',
        ]);
    }

    public function testMakeWithoutPassword()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The password authenticator requires a username and password.');

        $authenticator->with($client)->authenticate([
            'username' => 'your-username',
        ]);
    }

    public function testMakeWithoutSettingClient()
    {
        $authenticator = $this->getAuthenticator();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The client instance was not given to the password authenticator.');

        $authenticator->authenticate([
            'username' => 'your-username',
            'password' => 'your-password',
            'method'   => 'password',
        ]);
    }

    protected function getAuthenticator()
    {
        return new PasswordAuthenticator();
    }
}
