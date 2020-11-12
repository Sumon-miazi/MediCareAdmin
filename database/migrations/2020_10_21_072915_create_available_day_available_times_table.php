<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableDayAvailableTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_day_available_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_chamber_id')->constrained('doctor_chambers')->onDelete('cascade');
            $table->foreignId('available_day_id')->constrained('available_days')->onDelete('cascade');
            $table->foreignId('available_time_id')->constrained('available_times')->onDelete('cascade');
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
        Schema::dropIfExists('available_day_available_times');
    }
}
