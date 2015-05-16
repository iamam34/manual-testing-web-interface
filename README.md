# manual-testing-web-interface
Web interface (CRUD) to a mysql database for manual tests and test results. Written in PHP with CodeIgniter (and JavaScript with jQuery).

Originally written as a revision exercise for SENG365 - Web Computing Architectures, to help with SENG302 - Software Engineering Group Project.

## Configuration
After cloning this repository to your web server, 

### Database Configuration
The web interface is an *interface* to a backend database. This means you must have a database somewhere. The database must include a table called Tests and a table called TestResults. The column names in these tables must match the following specification exactly, but the datatypes are only recommendations.

#### Tests
id  | title        | steps        | expectedResult | creator     | creationDate
:---|:-------------|:-------------|:---------------|:------------|:------------
int | varchar(150) | varchar(150) | varchar(150)   | varchar(50) | date

#### TestResults
id  | testId | date | tester      | operatingSystem | build        | result          | comment
:---|:-------|:-----|:------------|:----------------|:-------------|:----------------|:------
int | int    | date | varchar(50) | varchar(150)    | varchar(150) | enum(PASS,FAIL) | varchar(150)

#### CodeIgniter Database Configuration
Now you need to tell CodeIgniter how to connect to this database.

Rename `application/config/database-template.php` to `application/config/database.php` and edit the relevant fields to describe your database setup. 
