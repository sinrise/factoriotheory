<?php
  defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
  defined("SITE_OWNER") ? null : define("SITE_OWNER", "");

  // -SERVER
  error_reporting(E_ALL);
  defined("SITE_ROOT") ? null : define("SITE_ROOT", "c:".DS."source".DS."site_name".DS);
  defined("SITE_PATH") ? null : define("SITE_PATH", SITE_ROOT."source".DS."root".DS);
  defined("SITE_URL") ? NULL : define("SITE_URL", "http://localhost:8000/site_name/");
  defined("IMG_PATH") ? null : define("IMG_PATH", SITE_URL."images/");
  defined("ADMIN_PATH") ? null : define("ADMIN_PATH", SITE_PATH."admin".DS);
  defined("ADMIN_URL") ? NULL : define("ADMIN_URL", SITE_URL."/admin/");

  defined("DB_USER")   ? NULL : define("DB_USER", "root");
  defined("DB_PASS")   ? NULL : define("DB_PASS", "");

  // -DATABASE
  defined("DB_SERVER") ? NULL : define("DB_SERVER", "localhost");
  defined("DB_NAME")   ? NULL : define("DB_NAME", "db_name");

  defined("SITE_TITLE") ? NULL : define("SITE_TITLE", "Site Title");

  $area = (isset($area)) ? $area : "";

  defined("HEADER") ? null : define("HEADER", SITE_PATH."header.php");
  defined("FOOTER") ? null : define("FOOTER", SITE_PATH."footer.php");
  defined("NAVMAIN") ? null : define("NAVMAIN", SITE_PATH."nav_main.php");
  
  require_once("functions.php");
  require_once("database.php");
  require_once("database_object.php");
  require_once("tables.php");
  require_once("session.php");
?>
