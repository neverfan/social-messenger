alter system set wal_level = logical;
alter system set enable_partition_pruning = on;
select run_command_on_workers('alter system set wal_level = logical');
select run_command_on_workers('enable_partition_pruning = on');
select pg_reload_conf();
