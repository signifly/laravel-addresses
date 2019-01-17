<?php

namespace Signifly\Addresses\Test;

use CreateAddressesTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Signifly\Addresses\AddressesServiceProvider;
use Signifly\BuilderMacros\BuilderMacroServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('app.key', 'base64:9e0yNQB60wgU/cqbP09uphPo3aglW3iQJy+u4JQgnQE=');
    }

    protected function getPackageProviders($app)
    {
        return [
            BuilderMacroServiceProvider::class,
            AddressesServiceProvider::class,
        ];
    }

    protected function setUpDatabase()
    {
        $this->createTables();
        $this->seedTables();
    }

    protected function createAddressesTable()
    {
        include_once __DIR__ . '/../migrations/create_addresses_table.php.stub';

        (new CreateAddressesTable())->up();
    }

    protected function createTables()
    {
        $this->app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('token');
            $table->timestamps();
        });

        $this->createAddressesTable();
    }

    protected function seedTables()
    {
        $now = Carbon::now()->toDateTimeString();

        DB::table('users')->insert([
            'name' => 'John Doe',
            'token' => md5('token'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
