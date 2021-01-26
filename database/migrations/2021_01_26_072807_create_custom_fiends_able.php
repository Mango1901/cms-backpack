<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFiendsAble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('custom_fields_able', function (Blueprint $table) {
            $table->bigInteger("ctAble_id");
            $table->String("ctAble_type");
            $table->bigInteger("custom_id")->unsigned();
            $table->timestamps();
        });
        Schema::table('custom_fields_able', function (Blueprint $table) {
            $table->primary(['ctAble_id', 'ctAble_type',"custom_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("custom_fields_able");
    }
}
