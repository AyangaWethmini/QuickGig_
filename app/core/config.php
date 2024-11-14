<?php 

if($_SERVER['SERVER_NAME'] == 'localhost')
{
	/** database config **/
	define('DBNAME', 'quickgig');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');
	
	define('ROOT', 'http://localhost/QuickGig/public');

}else
{
	/** database config **/
	define('DBNAME', 'quickgig');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');

	define('ROOT', 'https://www.quickgig.com');

}


define('APPROOT', dirname(dirname(__FILE__)));

define('APP_NAME', "GuickGig");
define('APP_DESC', "On-Demand job searching platform");

/** true means show errors **/
define('DEBUG', true);