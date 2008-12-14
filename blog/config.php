<?php
ini_set('display_errors',true);
ini_set('error_reporting', E_ALL);
ini_set('log_errors',1);

/* database settings */
define('DATABASE_NAME', 'blog');
define('DATABASE_USER', 'dschini');
define('DATABASE_PASS', 'dschini');
define('DATABASE_HOST', 'localhost');
define('DATABASE_PORT', 3306);

/* define basedir */
//$basedir = "/srv/www/dschini/blog/";
define('BASEDIR' ,dirname($_SERVER['DOCUMENT_ROOT']).DIRECTORY_SEPARATOR);

/* defines */
define("THEME_DEFAULT" ,BASEDIR."themes/default/");

/* simple bit rights */
define("RIGHT_PUBLIC"	,0);
define("RIGHT_PRIVATE"	,1);

/* load proxies */
include(BASEDIR."lib/org/dschini/proxies/BlogpostProxy.php");
include(BASEDIR."lib/org/dschini/proxies/BlogsettingsProxy.php");
include(BASEDIR."lib/org/dschini/proxies/BlogcommentProxy.php");

/* load controllers */
include(BASEDIR."lib/org/dschini/controllers/blogController.php");
include(BASEDIR."lib/org/dschini/controllers/adminController.php");

/* load helpers */
include(BASEDIR."lib/org/dschini/helpers/AccountHelper.php");
include(BASEDIR."lib/org/dschini/helpers/RequestHelper.php");
include(BASEDIR."lib/org/dschini/helpers/MySQLDriverHelper.php");
include(BASEDIR."lib/org/dschini/helpers/TemplateHelper.php");
include(BASEDIR."lib/org/dschini/helpers/DateFormatHelper.php");
include(BASEDIR."lib/org/dschini/helpers/URLHelper.php");

$GLOBALS['rights'] = pow(2,RIGHT_PUBLIC);
if(AccountHelper::isLoggedIn()){
	$GLOBALS['rights'] = $GLOBALS['rights'] | AccountHelper::getAccountRights();
}

/* load urls */
include(BASEDIR."urls.php");

session_start();
