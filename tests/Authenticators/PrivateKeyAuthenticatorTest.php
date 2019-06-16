<?php

namespace GrahamCampbell\Tests\GitHub\Authenticators;

use Github\Client;
use GrahamCampbell\GitHub\Authenticators\PrivateKeyAuthenticator;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;
use InvalidArgumentException;
use Lcobucci\JWT\Token;
use Mockery;

class PrivateKeyAuthenticatorTest extends AbstractTestCase
{
    public function testMakeSuccess()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);
        $client
            ->shouldReceive('authenticate')->once()
            ->with(Mockery::on(function ($token) {
                $this->assertInstanceOf(Token::class, $token);

                return true;
            }), 'jwt');

        $return = $authenticator->with($client)->authenticate([
            'appId'   => 1,
            'keyPath' => sprintf('%s/fixtures/key.pem', dirname(__DIR__)),
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    public function testMakeWithoutExistingFile()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('You must provide a valid key file');

        $authenticator->with($client)->authenticate([
            'appId'   => 1,
            'keyPath' => 'test',
        ]);
    }

    public function testMakeWithoutWithoutAppId()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The private key authenticator requires the application id to be configured.');

        $authenticator->with($client)->authenticate([
            'keyPath' => __FILE__,
        ]);
    }

    public function testMakeWithoutKeyPath()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The private key authenticator requires the key path to be configured.');

        $authenticator->with($client)->authenticate([]);
    }

    public function testMakeWithoutClient()
    {
        $authenticator = $this->getAuthenticator();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The client instance was not given to the private key authenticator.');

        $authenticator->authenticate([
            'keyPath' => 'file',
            'method'  => 'private',
        ]);
    }

    protected function getAuthenticator()
    {
        return new PrivateKeyAuthenticator();
    }
}
