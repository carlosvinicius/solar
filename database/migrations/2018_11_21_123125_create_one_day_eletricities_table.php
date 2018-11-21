<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOneDayEletricitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('one_day_electricities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('panel_id');
            $table->date('day');
            $table->integer('sum');
            $table->integer('min');
            $table->integer('max');
            $table->decimal('average');
            $table->timestamps();

            $table->foreign('panel_id')->references('id')->on('panels');
            $table->unique('panel_id', 'day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('one_day_electricities');
    }
}
