# Introduction
This repo contains parts and extracts of the Symcom Program, which is a web based application for Homeopathy doctors and scholars to carry research based work on Homeopathy sources, symptoms and medicines.
In order to get the program running, the repo along with database is needed. 

# Local Setup Guidelines With Docker
1. Clone the git repo.
2. Check Docker.
```
docker --version
docker-compose --version
```
3. Change the ownership of the cloned directory.
```
sudo chown -R $USER:$USER location-directory-location/symcom-synonym-tool
```
4. Build Docker Images and Run.
```
sudo docker-compose build
sudo docker-compose up -d
```
5. Check if contianers are running. If errors are encountered for already used ports. Deactivate the ports.
```
sudo docker ps
```
6. Go to the PHP container.
```
docker exec -it php-apache bash
```
7. Check composer and install dependencies.
```
composer --version 
composer install
```
8. Database import.
```
# Go the mySQL container:
sudo docker exec -it mysql bash

# Login using password defined in yml file:
mysql -u root -p

# Check Databases:
show databases;

# If database mentioned in yml file is not creaated, create the database:
create database symcom_minified_db;

# Exit the mysql bash and container:
exit

# Import the SQL provided in the repo root to Docker temp.
sudo docker cp /location-of-cloned-root-folder/new_database_synonym_test.sql mysql:/tmp/

# Access mySQL container again:
sudo docker exec -it mysql bash

# Import the SQL to newly created database symcom_minified_db:
mysql -u root -p symcom_minified_db < /tmp/new_database_synonym_test.sql

# Check to verify the tables inside the database going to mySQL bash
mysql -u root -p
use database symcom_minified_db;
show all tables;

```
9. If in any case, the database and apache configurations are chaneged, make edits in `config/routes.php`.
```
Change PHP variable $absoluteUrl.
Change $dbHost, $dbUsername, $dbPassword, $dbName.
```

The project should be runnign live at `http://localhost:8080/`.







