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
            $table->string('image')->nullable();
            $table->string('bmdcRegNo');
            $table->boolean('approved')->default(false);
            $table->string('specialist');
            $table->string('uid')->nullable();
            $table->string('gender');
            $table->foreignId('hospital_id')->nullable()->constrained('hospitals')->onDelete('cascade')->onUpdate('cascade');
            $table->mediumText('about')->nullable();
            $table->date('dob')->nullable();
            $table->mediumText('educationHistory');
            $table->mediumText('address');
            $table->string('email');
            $table->string('phone')->nullable();
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
