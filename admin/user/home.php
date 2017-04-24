<?php
  $curr_date = strtotime("now");
  $msg = "";

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
  }

  // edit/delete
  if(isset($_GET['id']) && isset($_GET['x'])) {
    $user = User::find_by_id($_GET['id']);
    if($_GET['x'] == "d") {
      if($user && $user->delete()) { $msg .= "User successfully deleted."; }
    }
  }

  // view
  $users = User::find_all();
  $userid = isset($user->id) ? $user->id : NULL;
  $username = isset($user->username) ? $user->username : "";
  $email = isset($user->email) ? $user->email : "";
  $is_active = isset($user->is_active) ? $user->is_active : 1;
?>
<section id="user">
  <h1>user</h1>
  <div id="msg"><p><?php echo $msg; ?></p></div>
  <table>
    <thead>
      <tr>
        <th>username</th>
        <th>email</th>
        <th>active</th>
        <th colspan="2">actions</th>
      </tr>
    </thead>
    <tbody>
<?php foreach($users as $u): ?>
      <tr>
        <td><?php echo $u->username; ?></td>
        <td><?php echo $u->email; ?></td>
        <td><?php echo $u->is_active; ?></td>
        <td><a href="?id=<?php echo $u->id; ?>&x">edit</a></td>
        <td><a href="?id=<?php echo $u->id; ?>&x=d">delete</a></td>
      </tr>
<?php endforeach; ?>
    </tbody>
  </table>
    <div class="admin_form">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <fieldset>
        <legend><?php if($userid) { echo "Edit: <span>{$username}</span>"; } else { echo "New User"; } ?></legend>
      <?php if($userid): ?>
        <input type="hidden" name="id" id="id" value="<?php echo $userid; ?>">
      <?php endif; ?>
        <p>
          <label for="username">username</label>
          <input name="username" id="username" type="text" value="<?php echo $username; ?>">
        </p>
      <?php if(!$userid): ?>
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
          <button type="submit" name="submit">Save</button><button type="reset" name="reset">clear</button><?php if($userid): ?><button class="btn_cancel" href="index.php?id=<?php echo $userid; ?>">done</button><?php endif; ?>
        </p>
      </fieldset>
    </form>
  </div><!-- end .admin_form -->
  <div id="admin_log"><?php echo file_get_contents(SITE_PATH.'logs'.DS."log.txt"); ?></div>
</section>