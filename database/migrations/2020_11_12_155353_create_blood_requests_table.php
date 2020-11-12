<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void

        map.put("userId", userId);
        map.put("bloodFor", bloodFor);
        map.put("city", city);
        map.put("hospital", hospital);
        map.put("amount", amount);
        map.put("date", date);
        map.put("bloodGroup", bloodGroup);
     */
    public function up()
    {
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('bloodFor');
            $table->string('city');
            $table->string('hospital');
            $table->string('amount');
            $table->string('bloodGroup');
            $table->dateTime('date');
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
        Schema::dropIfExists('blood_requests');
    }
}
