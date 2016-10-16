-- add table prefix if you have one
DROP TABLE IF EXISTS icommkt_emailexporter_email_store;
DROP TABLE IF EXISTS icommkt_emailexporter_email;
DELETE FROM core_resource WHERE code = 'icommkt_emailexporter_setup';
DELETE FROM core_config_data WHERE path like 'icommkt_emailexporter/%';