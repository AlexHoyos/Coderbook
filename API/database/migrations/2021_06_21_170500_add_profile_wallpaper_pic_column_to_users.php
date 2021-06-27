<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileWallpaperPicColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_pic_id')->nullable()->after('password');
            $table->unsignedBigInteger('wallpaper_pic_id')->nullable()->after('password');

            $table->foreign('profile_pic_id')->references('id')->on('m_media')->nullOnDelete();
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['profile_pic_id']);
            $table->dropForeign(['wallpaper_pic_id']);
            $table->dropColumn(['profile_pic_id', 'wallpaper_pic_id']);
        });
    }
}
