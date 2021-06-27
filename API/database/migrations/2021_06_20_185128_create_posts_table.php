<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('user_id');
            $table->longText('content');
            $table->enum('privacy', ['public', 'private'])->default('public');
            $table->enum('type', ['normal', 'shared', 'to_user', 'profile_pic', 'wallpaper_pic'])->default('normal');
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->unsignedBigInteger('shared_post_id')->nullable();
            $table->timestamps();

            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shared_post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
