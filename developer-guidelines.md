# Developer Guidelines for implementation of Synonym Classification Tool
### Basics
For simplicity only one medicine source is provided. All symptoms would be shown under this source. This source is listed in the materia medica with title "Testing Source". The icon appearing with this source under Synonym Classification column should be clicked to initiate the Synonym Classification Program.

When this icon is clicked, the browser is redirected to `all-symptoms.php` script at present. This can be changed to the landing page of the Synonym Tool Program. The codes to retrieve symptoms from the database for this particular source is mentioned in the `all-symptoms.php` scripts with comments.

### Requirements
- Worksheet where the synonym classification will be carried out.
- Synonym Database UI table with all synonym categories, symptom associations etc.

Currently, the Synonym Tables which can be accessed from the side menu bar only displays 4 categories of the synonym. New additions need to be added, a complete new UI with all required details can also be done.

### File Structure
Inside the project root directory, the folder `synonym-tool` will be responsible for Synonym Classification tool. Any new scripts, functions, dependencies should be done in this directory. 
In case of addition of new codes in the root directory, do let us know. 

Currently the `synonym-tool` folder has `all-symptoms.php` script which is redirected in the browser when a source is clicked from the "Materia Medica" webpage. 

The source ID is sent as a GET parameter along with the URL and this ID is used for symptoms retrieval in the `all-symptoms.php` page. 
**This script is just an example on how the code works inside this folder.**

Scripts associated to stop words and synonyms can be found inside `dev-exp` as `stop-words.php`, `synonym-de.php` and `synonym-en.php`.

### Database Help
The provided database needs to be imported. Follow the main readme guidelines for database setup.

In order to add the new test symptoms to the database, use the `update-tables.sql` file present under `synonym-tool/test-symptoms/` directory.
Once all the docker containers are running, try the below command to update the database with new symptoms.

```SQL
cat update_tables.sql | docker exec -i mysql mysql -u root -proot symcom_minified_db
```

Replace `symcom_minified_db` with your database name if it has changed.

SQL tables related to Synonyms:
```
--- SQL Table Name => Description ---

synonym_de => for german synonyms.
synonym_en => for english synonyms.
synonym_reference => all synonym references.
synonym_de_synonym_reference => contains german synonyms with synonyn reference.
synonym_en_synonym_reference => contains english synonyms with synonyn reference.
quelle_import_test => contains all the symptoms from all the sources.
rel_symptom_english_synonym => symptom assigned to english synonym (to be used in classification process).
rel_symptom_german_synonym => symptom assigned to german synonym (to be used in classification process).
stop_words => all stop words.
```

##### Synonyms
```
--- Column name associated with the Synonym Tables | synonym_de | synonym_en ---
word => for the root word
synonym => for the synonyms
cross_reference => for cross-references
generic_term => for generic term
sub_term => for sub term
non_secure_flag => non secure flag
comment => comment for the synonym
```

If relational tables of synonym and symptoms `rel_symptom_english_synonym` and `rel_symptom_german_synonym` are not present in the database. Use the below commands to import it to the database:
```SQL
cat rel_symptom_german_synonym.sql | docker exec -i mysql mysql -u root -proot symcom_minified_db
```
```SQL
cat rel_symptom_english_synonym.sql | docker exec -i mysql mysql -u root -proot symcom_minified_db
```
These tables will hold the relationship between the synonyms and the symptoms. Table structure could be modified as per new requirements.

##### Stop Words
The stop words or the filler word code section are complete functional. Words can be newly added, deactivated etc.
