## Yii2 framework (employee, construction sites and work items)

App where can be stored information about employees, construction sites and work items.

* Employees - view, create, update, delete information about employees also their roles and access levels.
* Construction sites - view, create, update, delete information about construction sites also access levels.
* Work items - view, create, update, delete information. Can assign employees to construction sites (by access levels), describe work that needs to be done at construction site.

___

Employee roles (admin, manager, employee):

* admin can access full app functionality.
* manager can only assign work items to employees.
* employee can only access work items to view his assigned jobs and construction site locations.

___

Company that works on construction site can get employee names that will work in this object by accessing API request.

___

### How to run App

* run command `composer install`
* configure database connection in `config/db.php`
* SQL scripts for MSSQL server, to create tables and insert test data, can be found in SQL folder
* in terminal navigate to web folder and execute command `php -S localhost:8000` <br>
  <br>
* login with Username: `admin`  Password: `12345`
* to get API response add to domain name url `/site/workers?location={}`  where {} is replaced with construction site location <br>
for example `/site/workers?location=skanstes 30`