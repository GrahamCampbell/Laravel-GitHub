<?php

namespace GrahamCampbell\Tests\GitHub\Authenticators;

use Github\Client;
use GrahamCampbell\GitHub\Authenticators\PrivateKeyAuthenticator;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;
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
            'appId' => 1,
            'keyPath' => sprintf('%s/fixtures/key.pem', dirname(__DIR__)),
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage You must provide a valid key file
     */
    public function testMakeWithoutExistingFile()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $return = $authenticator->with($client)->authenticate([
            'appId' => 1,
            'keyPath' => 'test',
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Private key authentication requires the github application id to be configured.
     */
    public function testMakeWithoutWithoutIssuer()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $return = $authenticator->with($client)->authenticate([
            'keyPath' => __FILE__,
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Private key authentication require the key path to be configured.
     */
    public function testMakeWithoutFile()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $return = $authenticator->with($client)->authenticate([]);

        $this->assertInstanceOf(Client::class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The client instance was not given to the private key authenticator.
     */
    public function testMakeWithoutClient()
    {
        $authenticator = $this->getAuthenticator();

        $authenticator->authenticate([
            'keyPath' => 'file',
            'method' => 'private',
        ]);
    }

    /**
     * @return PrivateKeyAuthenticator
     */
    protected function getAuthenticator()
    {
        return new PrivateKeyAuthenticator();
    }
}