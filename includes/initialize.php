<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null :
  define('SITE_ROOT', DS.'Users'.DS.'Tfruehe-mac'.DS.'Sites'.DS.'btb_testsite');

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

require_once("config.php");
require_once("functions.php");

require_once("session.php");
require_once("database.php");
require_once("pagination.php");


require_once("db_object.php");
require_once("user.php");
require_once("photograph.php");
require_once("comment.php");

?>
