<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColInRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relations', function (Blueprint $table) {
            $table->renameColumn('type_user', 'type');
            $table->dropColumn('type_friend');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relations', function (Blueprint $table) {
            $table->renameColumn('type', 'type_user');
            $table->char('type_friend', 50);
        });
    }
}
