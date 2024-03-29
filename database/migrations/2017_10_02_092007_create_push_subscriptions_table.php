<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('repairment_id')->unsigned()->index();
            $table->string('endpoint')->unique();
            $table->string('public_key')->nullable();
            $table->string('auth_token')->nullable();
            $table->timestamps();

            $table->foreign('repairment_id')
                    ->references('id')
                    ->on('repairments')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('push_subscriptions');
    }
}
