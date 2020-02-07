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

use Github\Client;
use GrahamCampbell\GitHub\Authenticators\ApplicationAuthenticator;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;
use InvalidArgumentException;
use Mockery;

/**
 * This is the application authenticator test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ApplicationAuthenticatorTest extends AbstractTestCase
{
    public function testMakeStandardWithMethod()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('authenticate')->once()
            ->with('your-client-id', 'your-client-secret', 'http_password');

        $return = $authenticator->with($client)->authenticate([
            'clientId'     => 'your-client-id',
            'clientSecret' => 'your-client-secret',
            'method'       => 'application',
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    public function testMakeWithoutMethod()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('authenticate')->once()
            ->with('your-client-id', 'your-client-secret', 'http_password');

        $return = $authenticator->with($client)->authenticate([
            'clientId'     => 'your-client-id',
            'clientSecret' => 'your-client-secret',
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    public function testMakeWithoutClientId()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The application authenticator requires a client id and secret.');

        $authenticator->with($client)->authenticate([
            'clientSecret' => 'your-client-secret',
        ]);
    }

    public function testMakeWithoutClientSecret()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The application authenticator requires a client id and secret.');

        $authenticator->with($client)->authenticate([
            'clientId' => 'your-client-id',
        ]);
    }

    public function testMakeWithoutSettingClient()
    {
        $authenticator = $this->getAuthenticator();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The client instance was not given to the application authenticator.');

        $authenticator->authenticate([
            'clientId'     => 'your-client-id',
            'clientSecret' => 'your-client-secret',
            'method'       => 'application',
        ]);
    }

    protected function getAuthenticator()
    {
        return new ApplicationAuthenticator();
    }
}
