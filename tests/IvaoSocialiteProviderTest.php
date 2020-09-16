<?php


namespace Tests;

use Illuminate\Http\Request;
use IvaoSocialite\IvaoProvider;
use IvaoSocialite\UserDataHttpClient;
use PHPUnit\Framework\TestCase;


class IvaoSocialiteProviderTest extends TestCase
{
    public function testGenerateRedirectToCorrectUrl()
    {
        $loginCallbackUrl = "https://br.ivao.aero";
        $provider = $this->makeProvider([
            "redirectUrl" => $loginCallbackUrl
        ]);

        $response = $provider->redirect();

        $this->assertTrue($response->isRedirection());
        $this->assertEquals("https://login.ivao.aero/index.php?url=https://br.ivao.aero", $response->getTargetUrl());
    }

    public function testGetUserWithInvalidToken()
    {
        $provider = $this->makeProvider([
            "request" => (function () {
                $requestMock = $this->createMock(Request::class);
                $requestMock->expects($this->once())->method('input')->willReturn("INVALID_TOKEN");

                return $requestMock;
            })()
        ]);

        $user = $provider->user();

        $this->assertNull($user);
    }

    private function makeProvider(array $dependencies = [])
    {
        $parameters = $dependencies + [
                "request" => $this->createMock(Request::class),
                "httpClient" => new UserDataHttpClient(),
                "redirectUrl" => "https://br.ivao.aero"
            ];

        return new IvaoProvider($parameters["request"], $parameters["httpClient"], $parameters["redirectUrl"]);
    }
}