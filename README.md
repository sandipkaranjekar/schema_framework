# Schema Framework : PHP
This basic PHP framework to start with  application development. It have very simple and clear directory structure.
Schema Framework is name on behalf of my startup [Tech Schema](http://www.techschema.com/). This framework is already 
powered with Role Based Access Control system.

### Directory structure
* **css** - All style related assests are tobe maintain here. This already contains some standard .css files and images folder.
     You can use CDN links also.
* **font** - Font required in application are tobe maintain here. This already contains some standard fonts.
* **img** - All images are tobe maintain here.
* **includes** - All static pages, common partial of code are tobe maintain here.
* **js** - All javascripts are tobe maintain here. This already contains some standard .js files or you can link it with CDN.
* **lib** - Very important and useful directory. It contain basic required lib like -
  * _auth.php_ - For basic authentication with privileges control.
  * _bread_crumb.php_ - Bread crum functionality.
  * _db.php_ - MySQL database connection with PDO enabled.
  * _db_pg.php_ - PostgreSQL database connecction with PDO enabled.
  * _download.php_ - Help to enable application proper download file mechanism using single method call.
  * _image_manipulation.php_ - Image manipulation code for image resize (in consideration of aspect ratio) and scale.
  * _rbac.php_ - To load all the privilages and check for access to resource.
  * _util.php_ - This php file have some useful functions like pagination and random_password logic.
* **mailer** - Mailer libraries useful for sending SMTP or POP3 mails.
* **templates** - It defines layout of application.
  * _footer.php_ - Footer of application.
  * _header.php_  - Header of application.
  * _javascript.php_ - Includes .js files from js folder.
  * _navigation.php_ - Navigation bar  of application.
  * _stylesheet.php_ - Includes .css files from css folder.
* **uploads** - This directory contains all uploaded medias with or without category/month/year.
* **user_panel** - This directory useful to maintain all admin side code i.e. other static pages. 
  Currently this directory have Role Based Access Control (RBAC) system full logic. For basic reference
  you can [have](https://github.com/sandipkaranjekar/rbac).
* **configuration.php** -  This file contains directory structure routes, database configuration, domain name 
  configuration. You can define other required variables also.
* **db.sql** - Database dump to start with.
* **index.php** - Home page.
