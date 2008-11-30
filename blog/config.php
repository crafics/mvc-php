<?php
session_start();

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
$basedir = "C:/Programme/Apache Software Foundation/Apache2.2/htdocs/dschini/blog/";

/* defines */
define('URL_BLOG_HOME'		,'http://dschini.localhost/blog/');
define("THEME_DEFAULT"		,$basedir."themes/default/");

/* load proxies */
include($basedir."lib/org/dschini/proxies/BlogpostProxy.php");
include($basedir."lib/org/dschini/proxies/BlogsettingsProxy.php");

/* load controllers */
include($basedir."lib/org/dschini/controllers/blogController.php");

/* load helpers */
include($basedir."lib/org/dschini/helpers/MySQLDriverHelper.php");
include($basedir."lib/org/dschini/helpers/TemplateHelper.php");
include($basedir."lib/org/dschini/helpers/DateFormatHelper.php");
include($basedir."lib/org/dschini/helpers/URLHelper.php");

/* load urls */
include($basedir."urls.php");
