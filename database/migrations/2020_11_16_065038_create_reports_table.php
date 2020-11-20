<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnostic_center_id')->constrained('diagnostic_centers')->onDelete('cascade')->nullable();
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('cascade')->nullable();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade')->nullable();
            $table->string('title');
            $table->string('file')->nullable();
            $table->boolean('complete')->default(false);
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
        Schema::dropIfExists('reports');
    }
}
