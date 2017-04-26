<section id="login">
<h1>Login</h1>
<?php
  $message = "";
  if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $hashed_password = sha1($password);
    
    $found_user = User::authenticate($username, $hashed_password);
    
    if ($found_user) {
      $session->login($found_user);
      log_action('Login', "{$found_user->username} logged in.");
      redirect_to("index.php");
    } else {
      $message .= "Username/password combination incorrect.";
    }
  } else {
    $username = "";
    $hashed_password = "";
  }
?>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
    <fieldset>
        <?php if($message != "") { echo "<p class=\"message\">{$message}</p>"; } ?>
        <p>
            <label for="username">Email</label>
            <input type="text" name="username" id="username" value="<?php echo htmlentities($username); ?>">
        </p>
        <p>
            <label for="password">Password</label>
            <input name="password" type="password" value="<?php echo htmlentities($password); ?>">
        </p>
        <p>
            <button type="submit" name="submit" value="login">Login</button>
        </p>
    </fieldset>
</form>
<?php /*
<p><a href="user.php?con=user_public&amp;x=reg">register</a></p>
<p><a href="user.php?con=user_public&amp;x=forgot">forgot password</a></p>
<p>Please report any problems to <a href="mailto:sinrise@gmail.com">sinrise@gmail.com</a>*/ ?>
</section>