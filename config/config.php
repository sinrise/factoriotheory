<?php
  error_reporting(E_ERROR);
  defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
  defined("SITE_OWNER") ? null : define("SITE_OWNER", "LuziferSenpai");

  defined("SITE_ROOT") ? null : define("SITE_ROOT", "e:".DS."source".DS."factoriotheory".DS."site".DS);
  defined("SITE_PATH") ? null : define("SITE_PATH", SITE_ROOT."source".DS."factoriotheory".DS);
  defined("SITE_URL") ? NULL : define("SITE_URL", "http://localhost:8000/factoriotheory/");

  defined("DB_USER")   ? NULL : define("DB_USER", "root");
  defined("DB_PASS")   ? NULL : define("DB_PASS", "");
  // defined("DB_USER")   ? NULL : define("DB_USER", "s252662_2578367");
  // defined("DB_PASS")   ? NULL : define("DB_PASS", "thisisapw");

  defined("DB_SERVER") ? NULL : define("DB_SERVER", "localhost");
  defined("DB_NAME")   ? NULL : define("DB_NAME", "db252662x2578367");

  defined("SITE_TITLE") ? NULL : define("SITE_TITLE", "Factorio TheoryCrafting");
  defined("IMG_PATH") ? null : define("IMG_PATH", SITE_URL."images/");

  $area = (isset($area)) ? $area : "";
  $dev_stats = true;

  defined("HEADER") ? null : define("HEADER", SITE_PATH."header.php");
  defined("FOOTER") ? null : define("FOOTER", SITE_PATH."footer.php");
  defined("NAVMAIN") ? null : define("NAVMAIN", SITE_PATH."nav_main.php");
  defined("LOCATION") ? null : define("LOCATION", SITE_PATH.$area.DS."home.php");
  
  require_once("functions.php");
  //require_once("database.php");
?>