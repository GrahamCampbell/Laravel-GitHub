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

    public function testMakeSuccessPEM()
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
            'keyPath' => '-----BEGIN RSA PRIVATE KEY-----\nMIIEpAIBAAKCAQEAov6ljr4lPgoyyyyhIRp+8QdaSUUpWU6oThOeDzX1NIGNCtW+\nEaGLt0Qbhk8qaEhm/aZRRbdvEqNogDMm9b/+RsiremQ98O/4eGuQTTPD9Y78IkAh\nC+QKNNtbqv1v/QMPFeHm7nvB0PRlurSNf6d2jJ9psij0i6nnkXSsmc/i6Qx0MxwA\n8igdKb98wMGqV2Jj45lw/nFeOP+CJmi2ws27JJt40SaXFbbbm7Ye89y0H0UWa2cf\nMrvwJLNKhHos7atlao+ZZHDNsj9ZA6r7xwAXBv9z6kkes1XSarzr1kxtu7XUqoND\n2b6kNCofGabQDK+QErnk1dmEdskNXJFFhx/CSwIDAQABAoIBADp7ujWkfkJrcFw8\nUDhLhH7BT6D4ouR7d6JEIbN9fdTwIwZfOQqkdzgzxNiFMUcnq2SZt5GXRtBeN5HA\nSNtmnzsQp46LxznbMMEsfyNkToyeWFOFxRW6JftfNd39f6A957zHSJALcbii6Jl8\nTUUfdkbwsAEP9ubh+MfVIFU0JUvO7Ij3RX3NxKm6RkfvwSeUCMk4myyj3KOLz8Hn\nn8RQp4F7n54EcMDv79gtolEWo1d9vaQw9S1h0U1OPb+3KveIzy33IWLfFX4Zx1ck\nDAmS/kIGgWzVVdMAAWW0XXGAdLPilWjipLRTl+OfxRcpvDBStraiwYPg6dgtqO0x\nxw2t0CkCgYEA0DcokJhsnZ+hD9z+pLnyFiJIMC+XjD/cEXYAt84RkKPPGMKTYyJy\ncakeSYPyRa8X4fbmRqJcYXtXTRvbVO3nInAX8g6mWl1xcCo/d2eh7AuM98K13nyW\nk5NJFlx5HDMk7k7Xh6rTwsgCLuIQt+ONpm6a82muwsJMM1zZZ437yGUCgYEAyGa6\nvzwH371XX5hDKvw83DnnnZIUwfGOcSN2mTiCxgG9FtkWkyk0ApELGK0e/5mAYKql\nplcOFbsp/KAT/N1VpTNK3LDPI4IZzn5ZSnWnC4qTqaKpmBDMSIt3U6+8wlOWn33d\ng25wHsFvW6XC46HCAC7/OoI6yOwBFHN1JqA4PO8CgYEAh64J3v+Ud7pXqBCoVwtc\nd5PrWosIxDmw3Cf7G8tKoug7wbS5enYuAWbk957ltwb8FyFeuVR/wn4vS24FpPhK\nD6Tf1bo6KNSPYToGlXaQi1KTj7fv74VcUdo+XDXyLbAeNrRlumBVEa5nzck+f7Xm\nzjdw/YE2gm8+XJH6kYJyOgkCgYBF+ChH0MvnAJLbG6yH+528PrNxvqlktdRICFvG\nT4bJX54HtjA9nWs9Yir/qKJkF9JM7gf8NfUC/WBBhhq0dQsMLQZ8W3dXLHuaL185\nsi5qxy2bUuHn6CWLRraZD4jWSJ0UfruywgJ/moYo940+MSItMjuG0CV6NXyDCXTj\n0ZkRHQKBgQCtLUbdM8rm+VuYSbm5p+HRHo8/U9T8m+O11W3LKE0i3VpAt8WOWe4v\nBbzT84hbb9KPWKJOBtyhaFLn/EG6lQYi2rTSsOeRcOed+njm2RNW9PECEY5WGffj\n8YhyE+wHJgA5Ngf22qYAR4MKYsytDx0iDMvMTTWpN+5G618zBfZwwg==\n-----END RSA PRIVATE KEY-----\n',
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    public function testMakeWithInvalidPEM()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('It was not possible to parse your key');

        $authenticator->with($client)->authenticate([
            'appId'   => 1,
            'keyPath' => '-----BEGIN RSA PRIVATE KEY-----',
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
