<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifi', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id_to');
            $table->integer('user_id_from');
            $table->integer('notifiable_id')->unsigned();
            $table->string('notifiable_type');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->string('action')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
