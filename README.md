s2h_cake
========
The CakePHP version of S2H

Directions
----------

1. Download CakePHP from http://cakephp.org and extract it into wherever you want.
2. While still in the directory where your localhost serves websites clone this repository
> git clone https://github.com/brett9897/s2h_cake.git
3. After cloning don't forget to create the following folders in the main s2h_cake directory and make sure they have 777 privileges on linux.
	1. tmp
	2. tmp/cache
	3. tmp/logs
	4. tmp/cache/models
	5. tmp/cache/persistent
4. Go to the webroot directory and copy index.php.default to index.php.  After doing that you will need to edit index.php and set the CAKE_CORE_INCLUDE_PATH to point to your
cake/lib directory in the CakePHP download.

5. Go to the Config directory and copy database.php.default to database.php.  Then edit database.php to fill in your database connection information.
6. Copy core.php.default to core.php.  Then edit core.php, uncommenting the line that reads
`Configure::write('Routing.prefixes', array('admin'));`

7. The database schema is in the sql folder.  Make sure to create a database and import those tables.
