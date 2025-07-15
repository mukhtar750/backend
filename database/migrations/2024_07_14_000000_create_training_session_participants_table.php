<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('training_session_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_session_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('registered_at')->nullable();
            $table->timestamps();

            $table->foreign('training_session_id')->references('id')->on('training_sessions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['training_session_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_session_participants');
    }
}; 