# manual-testing-web-interface
Web interface to a database for manual tests and test results (CRUD - create/read/update/delete). Written in PHP with CodeIgniter (and JavaScript with jQuery). Designed with MySQL and Apache server in mind.

Originally written as a revision exercise for SENG365 - Web Computing Architectures to simplify the manual testing for SENG302 - Software Engineering Group Project.

Started by Amy Martin, May 2015.

## Configuration
1. Clone this repository to your web server.
1. Configure directory-level authentication 
1. Configure the backend database and connect it to the website.

### Clone the Repo
`git clone $THIS_REPO $SOMEWHERE_ON_YOUR_WEB_SERVER`

At this stage, visiting the website through your browser should present a login dialog which never lets you in, or if you don't get the login dialog you'll get a "401: Access Denied". Don't worry, it's all part of the plan...

### Authentication

> Do *not* edit the `application/.htaccess` file. It comes with CodeIgniter and need not be modified. The following instructions refer to the `.htaccess` file in the *root directory* of the site.

If you're happy to allow anyone with an internet connection to create, read, update and delete your manual tests and test results, delete the `.htaccess` file in the root directory of the site.

Otherwise, if you'd like to use a rudimentary login system (bundled with the Apache server) to prevent unauthorised access to the site, use the `htpasswd` commandline utility (or http://www.htpasswdgenerator.net) to generate a `.htpasswd` file. Move it to the root directory of the site (ie. *sibling* to the `application` directory). The `.htaccess` file in this repository is already set up to use it.

At this stage, visiting the website through your browser should present a login dialog, and your recently generated username-password combination should allow you to see the site. It will probably give you a "500: Internal Server Error" because the website hasn't been configured to access the backend database yet... never fear!

### Database Configuration
The web interface is an *interface* to a backend database. This means you must have a database somewhere. The database must include a table called Tests and a table called TestResults. The column names in these tables must match the following specification exactly, but the datatypes are only recommendations. In both tables, `id` is the primary key. 

#### Tests
id      | title        | steps        | expectedResult | creator     | creationDate
:-------|:-------------|:-------------|:---------------|:------------|:------------
int(11) | varchar(300) | varchar(300) | varchar(300)   | varchar(15) | date

#### TestResults
id      | testId  | date | tester      | operatingSystem | build        | result              | comment
:-------|:--------|:-----|:------------|:----------------|:-------------|:--------------------|:------------
int(11) | int(11) | date | varchar(15) | varchar(30)     | varchar(30)  | enum('pass','fail') | varchar(200)

#### CodeIgniter Database Configuration
Now you need to tell CodeIgniter how to connect to this database.

Rename `application/config/database-template.php` to `application/config/database.php` and edit the relevant fields to describe your database setup. 

## Potential Additions
This is a list of potentially useful additions to the site. I'll probably not get around to implementing any of them unless there is sufficient demand. Hint: if you would find any of these useful, say so! Ditto if you have any suggestions not yet on the list.
* [x] logout button
* [ ] button to export Test and TestsResults tables in csv format (or similar)
* [ ] login functionality implemented via session variables rather than at the server level, so that tester/creator/OS fields can be automatically populated
* [ ] color coding results in list based on pass/fail state
* [ ] color coding tests in list based on average/threshold/latest pass/fail state of their corresponding results
* [ ] better css
* [ ] clear fields after a new item is successfully created [this is a usability bug imo]
* [ ] summary statistics
* [ ] some sort of automatic backup for the database tables (not sure if possible from frontend)
* [ ] undo/redo
