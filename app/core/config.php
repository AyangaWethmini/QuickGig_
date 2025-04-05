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

define('APP_NAME', "QuickGig");
define('APP_DESC', "On-Demand job searching platform");

/** true means show errors **/
define('DEBUG', true);

/**Stripe API keys**/
define('STRIPE_SECRET_KEY', 'sk_test_51QsoGLFq0GU0Vr5TTiRggaMjqVi3G7pT4HYuYvnA5Kh9mfuUzjbaq30DUVi8xSkjNWWUGfMWDathbTGImKakqrL800kKKsqd4Y');
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51QsoGLFq0GU0Vr5TlrQlsKQR7BGw4Ander7Yu8s1koQDaQR0qFY9c7QXJMKkpKNoGLuST4xEIj8S1tdvUA0azg0Y00ucoa4ozu');

/* 'webhook_secret'  => 'whsec_your_webhook_secret',
    'currency'        => 'USD'?*/
	//add these if needed later