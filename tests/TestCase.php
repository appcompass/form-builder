<?php
namespace AppCompass\Tests;

use AppCompass\Providers\FormBuilderServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Faker\Factory as Faker;

class TestCase extends OrchestraTestCase
{
    protected $faker;

    protected function getPackageProviders($app)
    {
        return [FormBuilderServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        $this->artisan('migrate')->run();
    }

    public function tearDown(): void
    {
        $this->artisan('migrate:reset')->run();
        parent::tearDown();
    }
}
