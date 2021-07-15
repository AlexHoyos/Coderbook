<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('title');
            $table->enum('visibility', ['public', 'private'])->default('public');
            $table->string('category')->default('Blog personal');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('principal_pic_id')->nullable();
            $table->unsignedBigInteger('wallpaper_pic_id')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('principal_pic_id')->references('id')->on('m_media')->nullOnDelete();
            $table->foreign('wallpaper_pic_id')->references('id')->on('m_media')->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
