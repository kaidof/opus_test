<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CreateExtensionFuzzystrmatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Config::get('database.default') === 'pgsql') {
            DB::statement('CREATE EXTENSION IF NOT EXISTS fuzzystrmatch;');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Config::get('database.default') === 'pgsql') {
            DB::statement('DROP EXTENSION IF EXISTS fuzzystrmatch;');
        }
    }
}
