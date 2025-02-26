FROM citusdata/citus:12.1.3

# Установка pg_partman через пакетный менеджер
RUN apt-get update && apt-get install -y \
    postgresql-16-partman && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y postgresql-16-cron

COPY init.sql /docker-entrypoint-initdb.d/

# Добавляем pg_cron в shared_preload_libraries
RUN echo "shared_preload_libraries = 'citus,pg_cron'" >> /usr/share/postgresql/postgresql.conf.sample
RUN echo "cron.database_name = 'messenger'" >> /usr/share/postgresql/postgresql.conf.sample;
