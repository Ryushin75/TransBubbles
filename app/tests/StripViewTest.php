<?php

class StripViewTest extends TestCase {

    public function setUp() {
        parent::setUp();
        Artisan::call('db:seed');
    }

    public function testStripAddNoLogin() {
        $this->client->request('GET', '/comic/1/strip/create');
        
        $this->assertRedirectedToRoute('user.signin');
    }

    public function testStripAddLogin() {
        Auth::loginUsingId(1);

        $this->client->request('GET', '/comic/1/strip/create');
        $this->assertResponseOk();
    }

    public function testEditFirstStripNoLogin() {
        $this->client->request('GET', '/comic/1/strip/1/edit');
        $this->assertRedirectedToRoute('user.signin');
    }

    public function testEditFirstStripLogin() {
        Auth::loginUsingId(1);

        $this->client->request('GET', '/comic/2/strip/1/edit');
        $this->assertResponseOk();
    }
}