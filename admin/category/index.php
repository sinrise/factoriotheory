<?php
  $area = "product";
  require_once("../../config/config.php");
  include(ADMIN_PATH."admin_header.php");
  if($session->is_logged_in()) {
    include("home.php");    
  } else {
    include(ADMIN_PATH."login.php");
  }
  include(ADMIN_PATH."admin_footer.php");
?>