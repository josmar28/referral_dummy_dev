<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestPatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_patient', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_id',50);
            $table->string('requested_by',50);
            $table->string('approved_by',50);
            $table->string('requesting_facility',50);
            $table->string('requested_facility',50);
            $table->string('status',50);
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
        Schema::dropIfExists('request_patient');
    }
}
