<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameReactionsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reactions', function(Blueprint $table) {
            $table->renameColumn('users_id', 'user_id');
            $table->renameColumn('posts_id', 'post_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reactions', function(Blueprint $table) {
            $table->renameColumn('user_id', 'users_id');
            $table->renameColumn('post_id', 'posts_id');
        });
    }
}
