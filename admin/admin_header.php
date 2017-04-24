<?php date_default_timezone_set("America/Los_Angeles"); ?>
<?php $session_user = $session->is_logged_in() ? User::find_by_id($session->user_id) : ""; ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin | <?php echo SITE_TITLE; ?></title>
<link rel="icon" href="<?php echo IMG_PATH; ?>logo-admin.png" type="image/png">
<link rel="stylesheet" href="<?php echo SITE_URL.'css/main.css?'.time(); ?>">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body id="admin">
<!--[if gte IE 9]>
  <style type="text/css">
    #wrapper {
       filter: none;
    }
  </style>
<![endif]-->
<div id="admin_msg"></div>
<?php //$admin_navs = Nav_menu::find($wh="type_id", $eq=1, $ord="position", $dir="ASC"); ?>
<header>
  <nav role="navigation">
    <ul>
        <li class="nav-brand"><a href="<?php echo SITE_URL.'admin'; ?>"><?php echo SITE_TITLE; ?> Admin</a></li>
        <li class="nav">
          <ul>
            <li><a href="<?php echo ADMIN_URL."product"; ?>">Products</a></li>
            <li><a href="<?php echo ADMIN_URL."category"; ?>">Categories</a></li>
            <li><a href="<?php echo ADMIN_URL."recipe"; ?>">Recipes</a></li>
            <li><a href="<?php echo ADMIN_URL."bonus"; ?>">Bonuses</a></li>
            <li><a href="<?php echo ADMIN_URL."user"; ?>">Users</a></li>
            <li></li>
          </ul>
        </li>
        <!-- <li>
          <a href="#" id="refresh">refresh</a>
          <div id="thinker-cont">
            <div id="thinker">
              <svg width='32px' height='32px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-ripple">
                <rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect>
                <g>
                  <animate attributeName="opacity" dur="2s" repeatCount="indefinite" begin="0s" keyTimes="0;0.33;1" values="1;1;0"></animate>
                  <circle cx="50" cy="50" r="40" stroke="#cccccc" fill="none" stroke-width="5" stroke-linecap="round">
                    <animate attributeName="r" dur="2s" repeatCount="indefinite" begin="0s" keyTimes="0;0.33;1" values="0;22;44"></animate>
                  </circle>
                </g>
                <g>
                  <animate attributeName="opacity" dur="2s" repeatCount="indefinite" begin="1s" keyTimes="0;0.33;1" values="1;1;0"></animate>
                  <circle cx="50" cy="50" r="40" stroke="#cccccc" fill="none" stroke-width="5" stroke-linecap="round">
                    <animate attributeName="r" dur="2s" repeatCount="indefinite" begin="1s" keyTimes="0;0.33;1" values="0;22;44"></animate>
                  </circle>
                </g>
              </svg>
            </div>
          </div> 
        </li>-->
      <?php //foreach($admin_navs as $admin_nav): if($admin_nav->is_disp == 1): ?>
        <?php /*<li><a href="<?php if($admin_nav->link_or != NULL) { echo $admin_nav->link_or; } else { echo SITE_URL."admin/".$admin_nav->name; } ?>"><?php echo $admin_nav->name; ?></a></li> */?>
      <?php //endif; endforeach; ?>
      <?php if($session->is_logged_in()): ?>
        <li id="admin_status"><?php echo $session_user->username; ?><a href="#" id="logout">log out</a></li>
      <?php else: ?>
            <li id="admin_status"><a href="#" id="login_link">Login</a></li>
      <?php endif; ?>
        </li>
        <li><p id="time"></p></li>
        <li class="nav-collapse">
            <a href="#" id="nav-collapse-icon">
                <i></i>
            </a>
        </li>
    </ul>
  </nav>
</header>
<main>