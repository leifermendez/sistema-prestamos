<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'credit';

    /**
     * Run the migrations.
     * @table credit
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->float('amount_neto')->nullable()->default('0');
            $table->integer('order_list')->nullable();
            $table->integer('id_user')->nullable()->default(null);
            $table->integer('id_agent')->nullable()->default(null);
            $table->integer('payment_number')->nullable()->default(null);
            $table->float('utility')->nullable()->default(null);
            $table->enum('status', ['close', 'inprogress'])->nullable()->default('inprogress');
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
