<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('sex', ['male', 'female', 'no_binary'])->nullable()->after('lastip');
            $table->date('birth_date')->nullable()->after('lastip');
            $table->string('bio_info')->nullable()->after('lastip');
            $table->enum('civil_status', ['alone', 'relationship', 'married', 'divorced', 'widower'])->nullable()->after('lastip');
            $table->unsignedBigInteger('relation_with_id')->nullable()->after('lastip');

            $table->foreign('relation_with_id')->references('id')->on('users')->nullOnDelete();

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
            $table->dropForeign('relation_with_id');
            $table->dropColumn(['sex', 'birth_date', 'bio_info', 'civil_status', 'relation_with_id']);
        });
    }
}
