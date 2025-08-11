<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('questionnaire_attempts', function (Blueprint $table) {
            $table->uuid('session_id')->unique()->after('questionnaire_id');
            $table->timestamp('started_at')->nullable()->after('session_id');
            $table->timestamp('completed_at')->nullable()->after('started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questionnaire_attempts', function (Blueprint $table) {
            $table->dropColumn(['session_id', 'started_at', 'completed_at']);
        });
    }
};
