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
        // Установка pg_partman
        DB::unprepared("
            CREATE SCHEMA IF NOT EXISTS partman;
            CREATE EXTENSION IF NOT EXISTS pg_partman WITH SCHEMA partman;
        ");

        // настройка создания партишенов по часу
        DB::unprepared("
            SELECT partman.create_parent(
                p_parent_table := 'public.messages',
                p_control := 'created_at',
                p_interval := '1 hour',
                p_type := 'range',
                p_start_partition := to_char(NOW() - INTERVAL '6 hours', 'YYYY-MM-DD HH24:MI:SS') -- для старых записей
            );

            UPDATE partman.part_config SET retention_keep_table = false, retention = '1 month', infinite_time_partitions = true WHERE parent_table = 'public.messages';
        ");

        // автоматическое создание партишенов раз в час
        DB::unprepared("
            CREATE EXTENSION IF NOT EXISTS pg_cron;
            SELECT cron.schedule('@hourly', $$
              SELECT partman.run_maintenance(p_analyze := false);
            $$);
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
