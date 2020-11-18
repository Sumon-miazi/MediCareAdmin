<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->default('');
            $table->string('name')->nullable();
            $table->string('image')->nullable();;
            $table->string('gender')->default('');
            $table->boolean('is_blood_donor')->default(false);
            $table->date("dob")->nullable();
            $table->double("weight", 6, 2)->default(0);
            $table->string('blood_group')->default('');
            $table->mediumText('address')->default('');
            $table->string('phone')->default('');
            $table->string('token')->default('');
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
        Schema::dropIfExists('patients');
    }
}
