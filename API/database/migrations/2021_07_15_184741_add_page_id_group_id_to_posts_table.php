<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddPageIdGroupIdToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            DB::statement("ALTER TABLE posts MODIFY type ENUM('normal', 'shared', 'to_user', 'profile_pic', 'wallpaper_pic', 'page', 'group') DEFAULT 'normal' NOT NULL");
            $table->unsignedBigInteger('page_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            DB::statement("ALTER TABLE posts MODIFY type ENUM('normal', 'shared', 'to_user', 'profile_pic', 'wallpaper_pic') DEFAULT 'normal' NOT NULL");
            $table->dropColumn(['page_id', 'group_id']);
        });
    }
}
