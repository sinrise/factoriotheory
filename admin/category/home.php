<?php
  $msg = "";
  $edit=0;

  // save
  if(isset($_POST['submit'])) {
    $category = new Category();
    $category->id = isset($_POST['id']) ? $_POST['id'] : NULL;
    $category->name = isset($_POST['name']) ? mysql_prep($_POST['name']) : "";
    $category->is_disp = isset($_POST['is_disp']) ? 1 : 0;
    $msg .= $category && $category->save() ? "Category created successfully" : "Category not created";
    $edit=0;
  }

  // edit/delete
  if(isset($_GET['id']) && isset($_GET['x'])) {
    $category = Category::find_by_id($_GET['id']);
    $edit=1;
    if($_GET['x'] == "d") {
      $edit=0;
      $msg .= $category && $category->delete() ? "Category successfully deleted." : "Category successfully deleted.";
    }
  }

  // view
  $categorys = Category::find_all();
  
  $categoryid = $edit==1 && isset($category->id) ? $category->id : NULL;
  $name = $edit==1 && isset($category->name) ? $category->name : "";
  $is_disp = $edit==1 && isset($category->is_disp) ? $category->is_disp : 1;
?>
<section id="user">
  <h1>category</h1>
  <div class="admin_data">
    <div class="admin_table_head">
      <table cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th width="10%">id</th>
            <th width="70%">name</th>
            <th width="8%">visible</th>
            <th width="12%" colspan="2">actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="admin_table_data">
      <table cellspacing="0" cellpadding="0">
        <tbody>
<?php foreach($categorys as $c): ?>
          <tr>
            <td width="10%"><?php echo $c->id; ?></td>
            <td width="70%"><?php echo $c->name; ?></td>
            <td width="8%"><?php echo $c->is_disp; ?></td>
            <td width="6%"><a href="?id=<?php echo $c->id; ?>&x">edit</a></td>
            <td width="6%"><a href="?id=<?php echo $c->id; ?>&x=d">del</a></td>
          </tr>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div><!-- end .admin_data -->
  <div class="admin_form">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <fieldset>
        <legend><?php if($edit==1) { echo "Edit: <span>{$name}</span>"; } else { echo "New Category"; } ?></legend>
      <?php if($edit==1): ?>
        <input type="hidden" name="id" id="id" value="<?php echo $categoryid; ?>">
      <?php endif; ?>
        <p>
          <label for="name">name</label>
          <input name="name" id="name" type="text" value="<?php echo $name; ?>">
        </p>
        <p>
          <label for="is_disp">
            <input type="checkbox" name="is_disp" id="is_disp" value="1"<?php echo $is_disp == 1 ? " checked='checked'" : ""; ?>>Visible
          </label>
        </p>
        <p>
          <button type="submit" name="submit">save</button><?php if($edit==0): ?><button type="reset" name="reset">clear</button><?php endif; ?><?php if($edit==1): ?><button class="btn_cancel" href="index.php?id=<?php echo $categoryid; ?>">cancel</button><?php endif; ?>
        </p>
      </fieldset>
    </form>
  </div><!-- end .admin_form -->
  <div id="msg"><p><?php echo $msg; ?></p></div>
</section>