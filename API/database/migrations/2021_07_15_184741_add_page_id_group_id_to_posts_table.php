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
            $table->unsignedBigInteger('page_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

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

            $table->dropForeign(['page_id']);
            $table->dropColumn(['page_id', 'group_id']);
        });
    }
}
