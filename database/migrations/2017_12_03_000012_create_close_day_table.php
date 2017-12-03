<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloseDayTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'close_day';

    /**
     * Run the migrations.
     * @table close_day
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_agent')->nullable()->default(null);
            $table->integer('id_supervisor')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->default(null);
            $table->float('total')->nullable()->default(null);
            $table->float('base_before')->nullable()->default(null);
            $table->float('from_number')->nullable()->default('0');
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
