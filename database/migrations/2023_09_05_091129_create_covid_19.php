<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCovid19 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('covid_19')){
            return true;
        }
        Schema::create('covid_19', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_id',50)->unique();
            $table->string('unique_id',50)->unique();
            $table->integer('dosage');
            $table->dateTime('date');
            $table->string('brand',50);
            $table->string('vaccinator',50);
            $table->string('lot_no',50);
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
        Schema::dropIfExists('covid_19');
    }
}
