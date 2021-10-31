<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PartnerPreference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partnerPreference', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer('minExpectedIncome');
            $table->integer('maxExpectedIncome');
            $table->string('occupation');
            $table->string('familyType');
            $table->string("manglik");
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
        //
    }
}
