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
               from_user_id bigint NOT NULL,--автор сообщения
               to_user_id bigint DEFAULT NULL, --для кого сообщение (не обязательно т.к. групповой диалог)
               text text NOT NULL,--текст сообщения
               created_at timestamp NOT NULL DEFAULT NOW(),--дата сообщения
               updated_at timestamp NOT NULL DEFAULT NOW(),--дата изменения сообщения
               PRIMARY KEY (dialog_id, id, created_at),
               CONSTRAINT fk_dialogs FOREIGN KEY (dialog_id) REFERENCES dialogs (id) ON DELETE CASCADE--внешний ключ
            ) PARTITION BY RANGE (created_at);
        ');

        DB::unprepared('
            CREATE UNIQUE INDEX IF NOT EXISTS idx_messages_unique ON messages (dialog_id, id, created_at);
            ALTER TABLE messages REPLICA IDENTITY USING INDEX idx_messages_unique;
        ');
        DB::unprepared('CREATE INDEX IF NOT EXISTS idx_messages_dialog_id_created_at ON messages (dialog_id, created_at DESC);');

        DB::unprepared("SELECT create_distributed_table('messages', 'dialog_id', 'hash', colocate_with := 'dialogs');");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
