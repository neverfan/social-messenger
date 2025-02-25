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
        //Создаем таблицу
        DB::unprepared('
            CREATE TABLE IF NOT EXISTS messages (
               id serial,
               dialog_id bigint NOT NULL,--id диалога
               user_id bigint NOT NULL,--автор сообщения
               text text NOT NULL,--текст сообщения
               created_at timestamp NOT NULL DEFAULT NOW(),--дата сообщения
               --PRIMARY KEY (id, dialog_id),
               CONSTRAINT fk_dialogs FOREIGN KEY (dialog_id) REFERENCES dialogs (id) ON DELETE CASCADE--внешний ключ
            ) PARTITION BY RANGE (created_at);
        ');

        DB::unprepared("SELECT create_distributed_table('messages', 'dialog_id', 'hash', colocate_with := 'dialogs');");

        DB::unprepared('CREATE INDEX IF NOT EXISTS idx_messages_dialog_id ON messages (dialog_id);');
        DB::unprepared('CREATE INDEX IF NOT EXISTS idx_messages_created_at ON messages (created_at);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
