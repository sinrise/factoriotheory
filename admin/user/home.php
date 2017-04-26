<?php
  $curr_date = strtotime("now");
  $msg = "";
  $edit=0;

  // save
  if(isset($_POST['submit']) && !isset($_GET['pwdreset'])) {
    if(isset($_POST['id'])) {
      $user = new Update_user();
      $user->id = mysql_prep($_POST['id']);
      $user->username = isset($_POST['username']) ? mysql_prep($_POST['username']) : NULL;
      $user->email = isset($_POST['email']) ? mysql_prep($_POST['email']) : NULL;
      $user->is_active = isset($_POST['is_active']) ? 1 : 0;
    } else {
      $user = new New_user();
      $user->username = isset($_POST['username']) ? mysql_prep($_POST['username']) : NULL;
      $user->email = isset($_POST['email']) ? mysql_prep($_POST['email']) : NULL;
      $user->is_active = isset($_POST['is_active']) ? 1 : 0;
      $user->created_date = $curr_date;
      $user->hashed_password = isset($_POST['password']) ? mysql_prep(sha1($_POST['password'])) : NULL;
      log_action('User Created', "{$_POST['username']} created successfully.");
    }
    $msg .= ($user && $user->save()) ? "user created successfully" : "User not created";
    $edit=0;
  }
  
  //password reset
  if(isset($_POST['submit']) && isset($_GET['pwdreset'])) {
    $curr_user = User::find_by_id(mysql_prep($_POST['id']));
    $user = User::find_by_id(mysql_prep($_POST['id']));
    $pass = isset($_POST['password']) ? mysql_prep(sha1(($_POST['password']))) : NULL;
    if(($pass != $curr_user->hashed_password) && ($pass != NULL)) {
      $user->id = isset($_POST['id']) ? mysql_prep($_POST['id']) : NULL;
      $user->hashed_password = $pass;
    } else {
      $msg .= "You cannot use your old password.";
    }
    if($user->save()) {
      log_action('Password Updated', "{$curr_user->username} changed password.");
      $msg .= ($user->save()) ? "user created successfully" : "User not created";
    }
    $edit=0;
  }

  // edit/delete
  if(isset($_GET['id']) && isset($_GET['x'])) {
    $edit=1;
    $user = User::find_by_id($_GET['id']);
    if($_GET['x'] == "d") {
      $edit=0;
      if($user && $user->delete()) { $msg .= "User successfully deleted."; }
    }
  }

  // view
  $users = User::find_all();

  $userid = $edit==1 && isset($user->id) ? $user->id : NULL;
  $username = $edit==1 && isset($user->username) ? $user->username : "";
  $email = $edit==1 && isset($user->email) ? $user->email : "";
  $is_active = $edit==1 && isset($user->is_active) ? $user->is_active : 1;
?>
<section id="user">
  <h1>user</h1>
  <div class="admin_data">
    <div class="admin_table_head">
      <table cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th width="40%">username</th>
            <th width="40%">email</th>
            <th width="8%">active</th>
            <th width="12%" colspan="2">actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="admin_table_data">
      <table cellspacing="0" cellpadding="0">
        <tbody>
<?php foreach($users as $u): ?>
          <tr>
            <td width="40%"><?php echo $u->username; ?></td>
            <td width="40%"><?php echo $u->email; ?></td>
            <td width="8%"><?php echo $u->is_active; ?></td>
            <td width="6%"><a href="?id=<?php echo $u->id; ?>&x">edit</a></td>
            <td width="6%"><a href="?id=<?php echo $u->id; ?>&x=d">delete</a></td>
          </tr>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="admin_form">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <fieldset>
        <legend><?php if($edit==1) { echo "Edit: <span>{$username}</span>"; } else { echo "New User"; } ?></legend>
      <?php if($edit==1): ?>
        <input type="hidden" name="id" id="id" value="<?php echo $userid; ?>">
      <?php endif; ?>
        <p>
          <label for="username">username</label>
          <input name="username" id="username" type="text" value="<?php echo $username; ?>">
        </p>
      <?php if($edit==0): ?>
        <p>
          <label for="password">password</label>
          <input name="password" id="password" type="password" value="">
        </p>
      <?php endif; ?>
        <p>
          <label for="email">email</label>
          <input name="email" id="email" type="text" value="<?php echo $email; ?>">
        </p>
        <p>
          <label for="is_active">
            <input type="checkbox" name="is_active" id="is_active" value="1"<?php echo $is_active == 1 ? " checked='checked'" : ""; ?>>Active
          </label>
        </p>
        <p>
          <button type="submit" name="submit">Save</button><?php if($edit==0): ?><button type="reset" name="reset">clear</button><?php endif; ?><?php if($edit==1): ?><button class="btn_cancel" href="index.php?id=<?php echo $userid; ?>">cancel</button><?php endif; ?>
        </p>
      </fieldset>
    </form>
  </div><!-- end .admin_form -->
  <div id="admin_log"><?php echo file_get_contents(SITE_PATH.'logs'.DS."log.txt"); ?></div>
  <div id="msg"><p><?php echo $msg; ?></p></div>
</section>