<!doctype html>
<html class="tk-camingodos-web">
<head>
  <title><?php echo SITE_TITLE; ?></title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="0.15 Changelog pre-release - What to look forward to"/>
  <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>css/main.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="<?php echo SITE_URL; ?>js/jquery.qtip.min.js"></script>
  <script type="text/javascript" src="<?php echo SITE_URL; ?>js/main.js"></script>
  <script src="https://use.typekit.net/emn3umj.js"></script>
  <script>try{Typekit.load({ async: true });}catch(e){}</script>
</head>
<?php echo file_get_contents(SITE_PATH."config/_credits.html"); ?>
<body>
<header><?php include(NAVMAIN); ?></header>
  <main<?php echo " id='".$area."'"; ?>>