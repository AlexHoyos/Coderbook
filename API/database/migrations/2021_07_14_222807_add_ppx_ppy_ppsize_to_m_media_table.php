<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPpxPpyPpsizeToMMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_media', function (Blueprint $table) {
            $table->integer('pp_x')->default(0)->after('url');
            $table->integer('pp_y')->default(0)->after('url');
            $table->integer('pp_size')->default(120)->after('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_media', function (Blueprint $table) {
            $table->dropColumn(['pp_x', 'pp_y', 'pp_size']);
        });
    }
}
