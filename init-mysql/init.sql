CREATE DATABASE IF NOT EXISTS maladie_db;
CREATE DATABASE IF NOT EXISTS traitement_db;
CREATE DATABASE IF NOT EXISTS dossier_db;
CREATE DATABASE IF NOT EXISTS auth_db;
CREATE DATABASE IF NOT EXISTS rbac_db;

GRANT ALL PRIVILEGES ON maladie_db.* TO 'rarecare'@'%';
GRANT ALL PRIVILEGES ON traitement_db.* TO 'rarecare'@'%';
GRANT ALL PRIVILEGES ON dossier_db.* TO 'rarecare'@'%';
GRANT ALL PRIVILEGES ON auth_db.* TO 'rarecare'@'%';
GRANT ALL PRIVILEGES ON rbac_db.* TO 'rarecare'@'%';
