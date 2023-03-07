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

namespace GrahamCampbell\Tests\GitHub\Auth\Authenticators;

use Github\Client;
use GrahamCampbell\GitHub\Auth\Authenticator\TokenAuthenticator;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;
use InvalidArgumentException;
use Mockery;

/**
 * This is the token authenticator test class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class TokenAuthenticatorTest extends AbstractTestCase
{
    public function testMakeWithMethod(): void
    {
        $authenticator = new TokenAuthenticator();

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('authenticate')->once()
            ->with('your-token', 'access_token_header');

        $return = $authenticator->with($client)->authenticate([
            'token'  => 'your-token',
            'method' => 'token',
        ]);

        self::assertInstanceOf(Client::class, $return);
    }

    public function testMakeWithoutMethod(): void
    {
        $authenticator = new TokenAuthenticator();

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('authenticate')->once()
            ->with('your-token', 'access_token_header');

        $return = $authenticator->with($client)->authenticate([
            'token'  => 'your-token',
        ]);

        self::assertInstanceOf(Client::class, $return);
    }

    public function testMakeWithoutToken(): void
    {
        $authenticator = new TokenAuthenticator();

        $client = Mockery::mock(Client::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The token authenticator requires a token.');

        $authenticator->with($client)->authenticate([]);
    }

    public function testMakeWithoutSettingClient(): void
    {
        $authenticator = new TokenAuthenticator();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The client instance was not given to the authenticator.');

        $authenticator->authenticate([
            'token'  => 'your-token',
            'method' => 'token',
        ]);
    }
}
