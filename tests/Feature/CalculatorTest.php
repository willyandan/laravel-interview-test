<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class CalculatorTest extends TestCase
{
    const USER_BASIC = 'basic';
    const USER_PREMIUM = 'premium';

    /**
     * @dataProvider authenticationDataProvider
     */
    public function testAuthenticationIsRequired(string $action, string $userType)
    {
        $response = $this->getJson($this->buildUrl($action, rand(1, 10), rand(1, 10)));

        $response->assertStatus(401);
    }

    /**
     * @dataProvider authenticationDataProvider
     */
    public function testAuthenticationIsRequiredSuccess(string $action, string $userType)
    {
        $response = $this
            ->actingAs($this->createUserOfType($userType))
            ->getJson($this->buildUrl($action, rand(1, 10), rand(1, 10)));

        $response->assertStatus(200);
    }

    public function testModuloRequiresPremiumAccess()
    {
        $response = $this
            ->actingAs($this->createUserOfType(self::USER_BASIC))
            ->getJson($this->buildUrl('mod', rand(1, 10), rand(1, 10)));

        $response->assertStatus(403);
    }

    public function testModuloRequiresPremiumAccessSuccess()
    {
        $response = $this
            ->actingAs($this->createUserOfType(self::USER_PREMIUM))
            ->getJson($this->buildUrl('mod', rand(1, 10), rand(1, 10)));

        $response->assertStatus(200);
    }

    /**
     * @dataProvider resultsDataProvider
     *
     * @param string $action
     * @param mixed $a
     * @param mixed $b
     * @param int|float $expectedResult
     */
    public function testResults($action, $a, $b, $expectedResult)
    {
        $response = $this
            ->actingAs($this->createUserOfType(self::USER_PREMIUM))
            ->getJson($this->buildUrl($action, $a, $b));

        $response->assertStatus(200);
        $response->assertJson(['result' => $expectedResult]);
    }

    /**
     * @dataProvider validationDataProvider
     * @param string $action
     * @param mixed $a
     * @param mixed $b
     * @param array $invalidParameters
     */
    public function testValidation(string $action, $a, $b, $invalidParameters)
    {
        $response = $this
            ->actingAs($this->createUserOfType(self::USER_PREMIUM))
            ->getJson($this->buildUrl($action, $a, $b));

        $response->assertJsonValidationErrors($invalidParameters);
        $response->assertStatus(422);
    }

    public function testRateLimiting()
    {
        $limit = 60;

        $response = $this
            ->actingAs($this->createUserOfType(self::USER_PREMIUM))
            ->getJson($this->buildUrl('add', 1, 1));

        $response->assertHeader('X-RateLimit-Limit', $limit);
        $response->assertHeader('X-RateLimit-Remaining', 59);
    }

    public function authenticationDataProvider(): array
    {
        return [
            ['add', self::USER_BASIC],
            ['sub', self::USER_BASIC],
            ['div', self::USER_BASIC],
            ['mul', self::USER_BASIC],
            ['mod', self::USER_PREMIUM],
        ];
    }

    public function resultsDataProvider(): array
    {
        return [
            ['add', 1, 4, 5],
            ['add', 0, 4, 4],
            ['sub', 1, 4, -3],
            ['sub', 10, 5, 5],
            ['div', 1, 1, 1],
            ['div', 10, 5, 2],
            ['div', 10, 3, 10 / 3],
            ['mul', 0, 1, 0],
            ['mul', 10, 15, 150],
            ['mod', 10, 5, 0],
            ['mod', 10, 6, 4],
        ];
    }

    public function validationDataProvider(): array
    {
        return [
            // add
            ['add', '', '', ['a', 'b']],
            ['add', '', 1, ['a']],
            ['add', 1, '', ['b']],
            ['add', '1.5', 'Abc', ['a', 'b']],
            ['add', '1a', 5, ['a']],
            ['add', 5, '0.0', ['b']],
            ['add', 5.5, 1.3, ['a', 'b']],
            // sub
            ['sub', '', '', ['a', 'b']],
            ['sub', '', 2, ['a']],
            ['sub', 3, '', ['b']],
            ['sub', '8!', 10, ['a']],
            ['sub', 15, '33.33', ['b']],
            ['add', 2.33, 4.13, ['a', 'b']],
            // mul
            ['mul', '', '', ['a', 'b']],
            ['mul', '', 1, ['a']],
            ['mul', 1, '', ['b']],
            ['mul', '1a', 5, ['a']],
            ['mul', 5, '0.0', ['b']],
            ['mul', 56.11, 5.1, ['a', 'b']],
            // div
            ['div', '', '', ['a', 'b']],
            ['div', '', 8, ['a']],
            ['div', 7, '', ['b']],
            ['div', 'Aaaa', 54, ['a']],
            ['div', 65, '0.0', ['b']],
            ['div', 75, 0, ['b']],
            ['div', 57.1, 4.6, ['a', 'b']],
            // mod
            ['mod', '', '', ['a', 'b']],
            ['mod', '', 54, ['a']],
            ['mod', 23, '', ['b']],
            ['mod', 'zzz', 38, ['a']],
            ['mod', 257, '0.5', ['b']],
            ['mod', 156, 0, ['b']],
            ['mod', 33.16, 14.3, ['a', 'b']],
        ];
    }

    private function buildUrl(string $action, $a, $b): string
    {
        return '/api/calculator/'.$action.'?'.http_build_query(['a' => $a, 'b' => $b]);
    }

    private function createUserOfType(string $userType): User
    {
        if ($userType === self::USER_PREMIUM) {
            return factory(User::class)->state('premium')->create();
        }

        return factory(User::class)->create();
    }
}
