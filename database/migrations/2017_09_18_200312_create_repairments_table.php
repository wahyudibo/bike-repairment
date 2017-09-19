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
            $table->string('identity_number')->nullable();
            $table->string('phone');
            $table->integer('work_unit_id')->unsigned()->nullable();
            $table->integer('bike_type_id')->unsigned()->nullable();
            $table->text('remark');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('report_number')->unique();
            // Status : WAITING, ON_PROGRESS, DONE, CANCELED
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('repairments', function (Blueprint $table) {
            $table->foreign('work_unit_id')
                ->references('id')
                ->on('work_units')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('bike_type_id')
                ->references('id')
                ->on('bike_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repairments', function (Blueprint $table) {
            $table->dropForeign('repairments_work_unit_id_foreign');
            $table->dropForeign('repairments_bike_type_id_foreign');
        });

        Schema::dropIfExists('repairments');
    }
}
