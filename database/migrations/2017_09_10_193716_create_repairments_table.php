<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('identity_number');
            $table->string('phone');
            $table->integer('unit_id')->unsigned();
            $table->integer('bike_type_id')->unsigned();
            $table->text('remark');
            $table->string('latitude');
            $table->string('longitude');
            // Status : WAITING, ON_PROGRESS, DONE, CANCELED
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repairments');
    }
}
