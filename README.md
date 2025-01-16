# Introduction
This repo contains parts and extracts of the Symcom Program, which is a web based application for Homeopathy doctors and scholars to carry research based work on Homeopathy sources, symptoms and medicines.
In order to get the program running, the repo along with database is needed. 

# Local Setup Guidelines With Docker
1. Clone the git repo.
2. Check Docker.
```
docker --version
```
3. Change the ownership of the cloned directory.
```
sudo chown -R $USER:$USER location-directory-location/symcom-synonym-tool
```
4. Build Docker Images and Run.
```
sudo docker compose build
sudo docker compose up -d
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
cat new_database_synonym_test.sql | docker exec -i mysql mysql -u root -proot symcom_minified_db
```

Afterwards, check to verify the tables inside the database going to MySQL bash
```
docker exec -it mysql mysql -u root -proot symcom_minified_db
show tables;
```

9. (Optional) If in any case, the database and apache configurations are changed, make edits in `config/routes.php`.
```
Change PHP variable $absoluteUrl.
Change $dbHost, $dbUsername, $dbPassword, $dbName.
```

The project should be runnign live at `http://localhost:8080/`.







