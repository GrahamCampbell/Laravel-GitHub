<?php

namespace GrahamCampbell\Tests\GitHub\Authenticators;

use Github\Client;
use GrahamCampbell\GitHub\Authenticators\PrivateKeyAuthenticator;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;
use Lcobucci\JWT\Token;

class PrivateKeyAuthenticatorTest extends AbstractTestCase
{
    public function testMakeSuccess()
    {
        $authenticator = $this->getAuthenticator();

        $client = \Mockery::mock(Client::class);
        $client
            ->shouldReceive('authenticate')->once()
            ->with(\Mockery::on(function ($token) {
                $this->assertInstanceOf(Token::class, $token);

                return true;
            }), 'jwt');

        $return = $authenticator->with($client)->authenticate([
            'file'   => sprintf('%s/fixtures/key.pem', dirname(__DIR__)),
            'issuer' => 1,
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Private key authentication require `issuer` config.
     */
    public function testMakeWithoutWithoutIssuer()
    {
        $authenticator = $this->getAuthenticator();

        $client = \Mockery::mock(Client::class);

        $return = $authenticator->with($client)->authenticate([
            'file' => __FILE__,
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Private key authentication got not exists file.
     */
    public function testMakeWithoutExistingFile()
    {
        $authenticator = $this->getAuthenticator();

        $client = \Mockery::mock(Client::class);

        $return = $authenticator->with($client)->authenticate([
            'file' => 'test',
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Private key authentication require `file` config.
     */
    public function testMakeWithoutFile()
    {
        $authenticator = $this->getAuthenticator();

        $client = \Mockery::mock(Client::class);

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
            'file'   => 'file',
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
