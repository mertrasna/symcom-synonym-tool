# Developer Guidelines for implementation of Synonym Classification Tool
### File Structure
Inside the project root directory, the folder `synonym-tool` will be responsible for Synonym Classification tool. Any new scripts, functions, dependencies should be done in this directory. 
In case of addition of new codes in the root directory, do let us know. 

Currently the `synonym-tool` folder has `all-symptoms.php` script which is redirected in the browser when a source is clicked from the "Materia Medica" webpage. 

The source ID is sent as a GET parameter along with the URL and this ID is used for symptoms retrieval in the `all-symptoms.php` page. 
**This script is just an example on how the code works inside this folder.**

### Database Help
The provided database needs to be imported.

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
