<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('uid')->nullable();
            $table->string('gender');
            $table->foreignId('hospital_id')->constrained('hospitals')->onDelete('cascade')->nullable();
            $table->string('about');
            $table->string('review')->nullable();
            $table->date('dob')->nullable();
            $table->longText('education_history');
            $table->mediumText('address');
            $table->string('phone');
            $table->string('token')->nullable();
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
        Schema::dropIfExists('doctors');
    }
}
