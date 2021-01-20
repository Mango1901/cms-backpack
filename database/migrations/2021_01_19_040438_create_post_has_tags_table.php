<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostHasTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_has_tags', function (Blueprint $table) {
            $table->bigInteger("tagable_id");
            $table->string("tagable_type");
            $table->bigInteger("tag_id")->unsigned();
            $table->timestamps();
        });
        Schema::table('post_has_tags', function (Blueprint $table) {
            $table->primary(['tagable_id', 'tag_id',"tagable_type"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_has_tags');
    }
}