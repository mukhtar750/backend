<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('training_sessions', function (Blueprint $table) {
            $table->string('meeting_link')->nullable()->after('target_roles');
        });
    }

    public function down()
    {
        Schema::table('training_sessions', function (Blueprint $table) {
            $table->dropColumn('meeting_link');
        });
    }
}; 