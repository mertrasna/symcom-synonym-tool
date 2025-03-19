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

composer install

```

exit

8. Database import.
```
cat new_database_synonym_test.sql | docker exec -i mysql mysql -u root -proot symcom_minified_db

```
Afterwards, update table with symptoms

```
cd synonym-tool
cd test-symptoms
cat update_tables.sql | docker exec -i mysql mysql -u root -proot symcom_minified_db
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

## 10. Running Selenium Tests

This project includes Selenium-based UI tests. Follow the steps below to install the dependencies, download the required drivers, and run the tests.

### Prerequisites

- **Python:** Make sure Python is installed.
- **Live Project:** Ensure the project is running live at [http://localhost:8080/](http://localhost:8080/).

### Installation

Open your terminal and install the required packages by running:

```bash
pip install selenium webdriver-manager mysql-connector-python pytest
```

redirect to this path :

```bash
cd /symcom-synonym-tool/synonym-tool/tests-selenium
```

use the following command lines below to run tests:

```bash
python3 test_synonym_management.py
python3 test_rootword.py
python3 test_external.py
python3 nonsecure.py

```


## 11. Running PHP Tests

This project includes PHP tests. Follow the steps below to install the dependencies, download the required drivers, and run the tests.

### Prerequisites

- **Live Project:** Ensure the project is running live at [http://localhost:8080/](http://localhost:8080/).

### Installation

Open your terminal and install the required packages by running:

Install PHPUnit globally:
```bash 
composer global require phpunit/phpunit
```

Then ensure Composer's global bin directory is in your $PATH:
```bash 
echo 'export PATH="$HOME/.composer/vendor/bin:$PATH"' >> ~/.zshrc
source ~/.zshrc
```


use the following command lines below to run tests:

```bash
  
vendor/bin/phpunit --bootstrap vendor/autoload.php synonym-tool/tests/ChatGPT2.php              
vendor/bin/phpunit --bootstrap vendor/autoload.php synonym-tool/tests/FetchWordInfoTest.php
```

if it does not run then use the following commands and run the above test lines again:
```bash
rm -rf vendor/phpunit
composer remove --dev phpunit/phpunit
composer require --dev phpunit/phpunit
vendor/bin/phpunit --version
```

# Developer Guidelines
[Synonym Tool Implementation Guidelines](developer-guidelines.md)