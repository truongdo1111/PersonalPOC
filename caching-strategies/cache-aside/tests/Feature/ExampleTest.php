<?php

use function Pest\Stressless\stress;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

//test('the application returns a successful response with cache', function () {
//    $response = $this->get('/');
//
//    $response->assertStatus(200);
//
//    $this->refreshTestDatabase();
//});

it('has a fast response time', function () {
    $result = stress('http://localhost/')->concurrency(1000)->dump();
    expect($result->requests()->duration()->med())->toBeLessThan(100);
    $this->refreshTestDatabase();
});

it('has a fast response time without cache', function () {
//    $result = stress('http://localhost/without-cache')->concurrency(1000)->dump();
//    expect($result->requests()->duration()->med())->toBeLessThan(100);
//    $this->refreshTestDatabase();
});
