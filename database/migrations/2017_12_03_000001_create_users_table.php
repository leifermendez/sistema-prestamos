<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->enum('active_user', ['enabled', 'disabled'])->nullable()->default('enabled');
            $table->rememberToken();
            $table->enum('level', ['user', 'agent', 'supervisor', 'admin'])->nullable()->default('user');
            $table->string('last_name')->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->text('province')->nullable()->default(null);
            $table->string('phone', 45)->nullable()->default(null);
            $table->string('nit', 45)->nullable()->default(null);
            $table->enum('status', ['bad', 'good'])->nullable()->default('good');
            $table->text('lng')->nullable()->default(null);
            $table->text('lat')->nullable()->default(null);
            $table->text('country')->nullable()->default(null);
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
