<?php
  function svgInject($image) {
    $svg = SITE_PATH."images/".$image.".svg";
    echo (file_exists($svg)) ? file_get_contents($svg) : "";
  }
  
  function redirect_to( $location = NULL ) {
    if ($location != NULL) {
      header("Location: {$location}");
      exit;
    }
  }

  function datetime_to_text($datetime="") {
    $unixdatetime = strtotime($datetime);
    return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
  }

  function mysql_prep($value) {
    global $database;
    $value = $database->escape_value($value);  
    return $value;
  }

  function log_action($action, $message="") {
    $logfile = SITE_PATH.'logs'.DS.'log.txt';
    $new = file_exists($logfile) ? false : true;
    if($handle = fopen($logfile, 'a')) { // append
      $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
      $content = "{$timestamp} | {$action}: {$message}\n";
      fwrite($handle, $content);
      fclose($handle);
      if($new) { chmod($logfile, 0755); }
    } else {
      echo "Could not open log file for writing.";
    }
  }
?>