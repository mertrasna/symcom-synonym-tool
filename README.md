# Introduction
This repo contains parts and extracts of the Symcom Program, which is a web based application for Homeopathy doctors and scholars to carry research based work on Homeopathy sources, symptoms and medicines.
In order to get the program running, the repo along with database is needed. 

# Local Setup Guidelines
#### Download XAMPP 7.1.33: 
`https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.1.33/xampp-windows-x64-7.1.33-1-VC14-installer.exe/download`

```
Add XAMPP installation location to Path in environment variables.

C:\xampp\php to Path in environment variables if not already done.
```


#### Download Composer Phar 1.6.3: 
`https://getcomposer.org/download/1.6.3/composer.phar`

Navigate to `htdocs` directory inside `XAMPP installtion directory` and clone Git repo: 
`Link`

The whole project will now contain under `symcom-synonym-tool` folder which is the root directory of the cloned project.

Make sure PHP version 7.1.33 is installed and working in the system.
```
php --version
```

Copy `composer.phar` to the cloned directory (root).
Install dependencies using the below commands in terminal.
```
php composer.phar show
php composer.phar install
```

Copy `composer.phar` to  `symcom-synonym-tool\symcom\api`.
Install dependencies using the below commands in terminal.
```
php composer.phar show
php composer.phar install
```

Once all dependencies are installed, it is advised to modify the `php.ini` variables.
```
Go to your xampp installation directory -> php -> (open) php.ini file and make these changes.
    max_execution_time = 12000.
    max_input_time = 6000.
    memory_limit = 1024M.
    upload_max_filesize = 100M.
    post_max_size = 100M.
```
#### Database and Routing Setup
Open the project folder in a code editor and navigate to `symcom-synonym-tool/config/route.php` and change the PHP variable `$dbName` to a desired database name. Example: `synonym_db_test`.

In this file change the PHP variable `$absoluteUrl` to `http://localhost/symcom-synonym-tool`. Here `symcom-synonym-tool` is the root directory of the cloned project.

Navigate to `symcom-synonym-tool/symcom/api` and copy all contents of `.env.example` file to a new `.env` file. Change the `DB_DATABASE` value to the new database name defined. Example: `synonym_db_test`.

Navigate to `symcom-synonym-tool/symcom/api/config/constants.php` and make sure the PHP value for `$configArray2 ['api_base_path']` is set to `http://localhost/symcom-synonym-tool/symcom/api/public/`.


#### Running the program
Open XAMPP control panel `xampp installtion directory/xampp-control.exe` and start `Apache` and `MySQL` services.

Create a new database with name defined in the project files mentioned above. Example: `synonym_db_test`. Can be done with `phpmyadmin` by going to `http://localhost/phpmyadmin/` site in the browser or any other database management tools.

Import the given database to this newly created database. Once database import is complete, the project can be opened at `http://localhost/symcom-synonym-tool/` URL in the browser.

<hr>

# Inside the Symcom Program
Log in using credentials:
```
username: guest
password: guest123
```

Once logged in the Symcom sidemenu can be seen with different topics. The stop words and synonyms can be accessed via this sidemenu.
![image](https://github.com/user-attachments/assets/d4d0b6b7-ffa4-4864-b4f1-8231e208fc14)

The sources inside the program can be viewed going to materia medica from the sidemenu.
Clicking the "Search" button will display all the sources inside the program.
![image](https://github.com/user-attachments/assets/5a77d9d9-c7a0-4637-8211-35bc37ab3b6b)

Clicking the source name will redirect the user to a different webpage which displays all the symptoms associated with the source, including information related to the symptom like synonyms, testers etc.
![image](https://github.com/user-attachments/assets/8685b8fc-49e8-4ed4-89c0-a86e5c0278ec)

The icon under "Synonym Classification" from materia medica can be clicked to start the synonym classification program. Currently it only displays the symptoms associated with the source in a new webpage.

For detailed contribution guidelines, see [developer-guidelines.md](./developer-guidelines.md).






