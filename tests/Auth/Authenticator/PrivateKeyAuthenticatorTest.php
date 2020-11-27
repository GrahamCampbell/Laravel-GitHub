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
use GrahamCampbell\GitHub\Auth\Authenticator\PrivateKeyAuthenticator;
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
            'keyPath' => sprintf('%s/fixtures/key.pem', dirname(dirname(__DIR__))),
        ]);

        $this->assertInstanceOf(Client::class, $return);
    }

    public function testMakeWithoutExistingFile()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The path "test" does not contain a valid key file');

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

        $key = <<<'KEY'
-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAov6ljr4lPgoyyyyhIRp+8QdaSUUpWU6oThOeDzX1NIGNCtW+
EaGLt0Qbhk8qaEhm/aZRRbdvEqNogDMm9b/+RsiremQ98O/4eGuQTTPD9Y78IkAh
C+QKNNtbqv1v/QMPFeHm7nvB0PRlurSNf6d2jJ9psij0i6nnkXSsmc/i6Qx0MxwA
8igdKb98wMGqV2Jj45lw/nFeOP+CJmi2ws27JJt40SaXFbbbm7Ye89y0H0UWa2cf
MrvwJLNKhHos7atlao+ZZHDNsj9ZA6r7xwAXBv9z6kkes1XSarzr1kxtu7XUqoND
2b6kNCofGabQDK+QErnk1dmEdskNXJFFhx/CSwIDAQABAoIBADp7ujWkfkJrcFw8
UDhLhH7BT6D4ouR7d6JEIbN9fdTwIwZfOQqkdzgzxNiFMUcnq2SZt5GXRtBeN5HA
SNtmnzsQp46LxznbMMEsfyNkToyeWFOFxRW6JftfNd39f6A957zHSJALcbii6Jl8
TUUfdkbwsAEP9ubh+MfVIFU0JUvO7Ij3RX3NxKm6RkfvwSeUCMk4myyj3KOLz8Hn
n8RQp4F7n54EcMDv79gtolEWo1d9vaQw9S1h0U1OPb+3KveIzy33IWLfFX4Zx1ck
DAmS/kIGgWzVVdMAAWW0XXGAdLPilWjipLRTl+OfxRcpvDBStraiwYPg6dgtqO0x
xw2t0CkCgYEA0DcokJhsnZ+hD9z+pLnyFiJIMC+XjD/cEXYAt84RkKPPGMKTYyJy
cakeSYPyRa8X4fbmRqJcYXtXTRvbVO3nInAX8g6mWl1xcCo/d2eh7AuM98K13nyW
k5NJFlx5HDMk7k7Xh6rTwsgCLuIQt+ONpm6a82muwsJMM1zZZ437yGUCgYEAyGa6
vzwH371XX5hDKvw83DnnnZIUwfGOcSN2mTiCxgG9FtkWkyk0ApELGK0e/5mAYKql
plcOFbsp/KAT/N1VpTNK3LDPI4IZzn5ZSnWnC4qTqaKpmBDMSIt3U6+8wlOWn33d
g25wHsFvW6XC46HCAC7/OoI6yOwBFHN1JqA4PO8CgYEAh64J3v+Ud7pXqBCoVwtc
d5PrWosIxDmw3Cf7G8tKoug7wbS5enYuAWbk957ltwb8FyFeuVR/wn4vS24FpPhK
D6Tf1bo6KNSPYToGlXaQi1KTj7fv74VcUdo+XDXyLbAeNrRlumBVEa5nzck+f7Xm
zjdw/YE2gm8+XJH6kYJyOgkCgYBF+ChH0MvnAJLbG6yH+528PrNxvqlktdRICFvG
T4bJX54HtjA9nWs9Yir/qKJkF9JM7gf8NfUC/WBBhhq0dQsMLQZ8W3dXLHuaL185
si5qxy2bUuHn6CWLRraZD4jWSJ0UfruywgJ/moYo940+MSItMjuG0CV6NXyDCXTj
0ZkRHQKBgQCtLUbdM8rm+VuYSbm5p+HRHo8/U9T8m+O11W3LKE0i3VpAt8WOWe4v
BbzT84hbb9KPWKJOBtyhaFLn/EG6lQYi2rTSsOeRcOed+njm2RNW9PECEY5WGffj
8YhyE+wHJgA5Ngf22qYAR4MKYsytDx0iDMvMTTWpN+5G618zBfZwwg==
-----END RSA PRIVATE KEY-----

KEY;

        $return = $authenticator->with($client)->authenticate([
            'appId' => 1,
            'key'   => $key,
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
            'appId' => 1,
            'key'   => '-----BEGIN RSA PRIVATE KEY-----',
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

    public function testMakeWithoutKeyOrKeyPath()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The private key authenticator requires the key or key path to be configured.');

        $authenticator->with($client)->authenticate([
            'appId' => 1,
        ]);
    }

    public function testMakeWithBothKeyAndKeyPath()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock(Client::class);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The private key authenticator requires the key or key path to be configured.');

        $authenticator->with($client)->authenticate([
            'appId'   => 1,
            'key'     => '-----BEGIN RSA PRIVATE KEY-----',
            'keyPath' => __FILE__,
        ]);
    }

    public function testMakeWithoutClient()
    {
        $authenticator = $this->getAuthenticator();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The client instance was not given to the private key authenticator.');

        $authenticator->authenticate([
            'appId'   => 1,
            'keyPath' => __FILE__,
        ]);
    }

    protected function getAuthenticator()
    {
        return new PrivateKeyAuthenticator();
    }
}
