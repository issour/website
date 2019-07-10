<?php

namespace Tests;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp() :void
    {
        parent::setUp();

        Storage::makeDirectory('public/testing');
    }

    public function tearDown() :void
    {
        Storage::deleteDirectory('public/testing');

        parent::tearDown();
    }

    public function spew()
    {
        $this->withoutExceptionHandling();
    }
}
