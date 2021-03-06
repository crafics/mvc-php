<?php
/* 
 * The config file!
 *
 * @author	Manfred Weber
 * @date		20/11/08
 * @see		http://manfred.dschini.org/
 */

ini_set('display_errors',true);
ini_set('error_reporting', E_ALL);
ini_set('log_errors',1);

/* defines here */
define('DATABASE_NAME', 'blog');
define('DATABASE_USER', 'dschini');
define('DATABASE_PASS', 'dschini');
define('DATABASE_HOST', 'localhost');
define('DATABASE_PORT', 3306);
define('BASEDIR' ,dirname($_SERVER['DOCUMENT_ROOT']).DIRECTORY_SEPARATOR);
define("THEME_DEFAULT" ,BASEDIR."themes/default/");
define("RIGHT_PUBLIC", 0);
define("RIGHT_ADMIN", 1);

/* 
 * PHP Libraries
 * Add you own libraries!!!
 */

/* Proxies */
include(BASEDIR."lib/org/dschini/proxies/BlogpostProxy.php");
include(BASEDIR."lib/org/dschini/proxies/BlogsettingsProxy.php");
include(BASEDIR."lib/org/dschini/proxies/BlogcommentProxy.php");
/* Controllers */
include(BASEDIR."lib/org/dschini/controllers/blogController.php");
include(BASEDIR."lib/org/dschini/controllers/adminController.php");
/* Helpers */
include(BASEDIR."lib/org/dschini/helpers/InputFilterHelper.php");
include(BASEDIR."lib/org/dschini/helpers/RequestHelper.php");
include(BASEDIR."lib/org/dschini/helpers/MySQLDriverHelper.php");
include(BASEDIR."lib/org/dschini/helpers/TemplateHelper.php");
include(BASEDIR."lib/org/dschini/helpers/DateFormatHelper.php");
include(BASEDIR."lib/org/dschini/helpers/URLHelper.php");


/* start session */
session_start();

/* Saving the rights in a session is not secure!!! */
RequestHelper::getInstance()->addUserRight($_SESSION['userRight'],RIGHT_PUBLIC);

