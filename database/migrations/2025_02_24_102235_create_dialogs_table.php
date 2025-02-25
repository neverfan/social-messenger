<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dialogs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->comment('создатель диалога');
            $table->jsonb('users')->nullable()->comment('участники диалога');
            $table->timestamps();
        });

        DB::statement("SELECT create_distributed_table('dialogs', 'id', 'hash');");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dialogs');
    }
};
