<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostHasCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_has_categories', function (Blueprint $table) {
            $table->bigInteger("able_id");
            $table->String("able_type");
            $table->bigInteger("category_id")->unsigned();
            $table->timestamps();
        });
        Schema::table('post_has_categories', function (Blueprint $table) {
            $table->primary(['able_id', 'category_id',"able_type"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_has_categories');
    }
}
