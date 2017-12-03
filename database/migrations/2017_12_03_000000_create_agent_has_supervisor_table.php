<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentHasSupervisorTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'agent_has_supervisor';

    /**
     * Run the migrations.
     * @table agent_has_supervisor
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_user_agent')->nullable()->default(null);
            $table->integer('id_supervisor')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->default(null);
            $table->float('base')->nullable()->default('0');
            $table->integer('id_wallet')->nullable()->default(null);
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
