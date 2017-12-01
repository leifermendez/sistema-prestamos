<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersHasRouteTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users_has_route';

    /**
     * Run the migrations.
     * @table users_has_route
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('route_id');
            $table->integer('agent_has_supervisor_id');

            $table->index(["agent_has_supervisor_id"], 'fk_users_has_route_agent_has_supervisor1_idx');

            $table->index(["route_id"], 'fk_users_has_route_route1_idx');


            $table->foreign('agent_has_supervisor_id', 'fk_users_has_route_agent_has_supervisor1_idx')
                ->references('id')->on('agent_has_supervisor')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('route_id', 'users_has_route_route_id')
                ->references('id')->on('route')
                ->onDelete('no action')
                ->onUpdate('no action');
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
