<?php
  $msg = "";
  $edit=0;

  // save
  if(isset($_POST['submit'])) {
    $product = new Product();
    $product->id = isset($_POST['id']) ? $_POST['id'] : NULL;
    $product->name = isset($_POST['name']) ? mysql_prep($_POST['name']) : "";
    $product->category_id = isset($_POST['category_id']) ? mysql_prep($_POST['category_id']) : NULL;
    $product->craft_speed = isset($_POST['craft_speed']) ? mysql_prep($_POST['craft_speed']) : NULL;
    $product->craft_time = isset($_POST['craft_time']) ? mysql_prep($_POST['craft_time']) : "";
    $product->energy_prod = isset($_POST['energy_prod']) ? mysql_prep($_POST['energy_prod']) : NULL;
    $product->energy_cons = isset($_POST['energy_cons']) ? mysql_prep($_POST['energy_cons']) : NULL;
    $product->producer_id = isset($_POST['producer_id']) ? mysql_prep($_POST['producer_id']) : "";
    $product->qty_produced = isset($_POST['qty_produced']) ? mysql_prep($_POST['qty_produced']) : NULL;
    $product->is_disp = isset($_POST['is_disp']) ? 1 : 0;
    $msg .= ($product && $product->save()) ? "Product saved successfully" : "Product not saved or no change was made";
    $edit=0;
  }

  // edit/delete
  if(isset($_GET['id']) && isset($_GET['x'])) {
    $product = Product::find_by_id($_GET['id']);
    $edit=1;
    if($_GET['x'] == "d") {
      $edit=0;
      if($product && $product->delete()) { $msg .= "Product successfully deleted."; }
    }
  }

  // view
  $products = Product::find_all($ord="name");
  $categorys = Category::find_all();
  $producers = Product::find_all_producers($ord="name");

  // these vars should stay outside the $_GET conditional for edit so the var exists for the form values so the use of a conditional on each form control is not necessary
  $productid = $edit==1 && isset($product->id) ? $product->id : NULL;
  $name = $edit==1 && isset($product->name) ? $product->name : "";
  $category_id = $edit==1 && isset($product->category_id) ? $product->category_id : "";
  $craft_speed = $edit==1 && isset($product->craft_speed) ? $product->craft_speed : NULL;
  $craft_time = $edit==1 && isset($product->craft_time) ? $product->craft_time : "";
  $energy_prod = $edit==1 && isset($product->energy_prod) ? $product->energy_prod : NULL;
  $energy_cons = $edit==1 && isset($product->energy_cons) ? $product->energy_cons : NULL;
  $producer_id = $edit==1 && isset($product->producer_id) ? $product->producer_id : "";
  $qty_produced = $edit==1 && isset($product->qty_produced) ? $product->qty_produced : NULL;
  $is_disp = $edit==1 && isset($product->is_disp) ? $product->is_disp : 1;
?>
<section id="user">
  <h1>product</h1>
  <div class="admin_data">
    <div class="admin_table_head">
      <table cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th width="6%">id</th>
            <th width="10%">name</th>
            <th width="13%">category</th>
            <th width="8%">craft time</th>
            <th width="8%">craft speed</th>
            <th width="8%">energy -</th>
            <th width="8%">energy +</th>
            <th width="9%">produced in</th>
            <th width="10%">qty produced</th>
            <th width="8%">visible</th>
            <th width="12%" colspan="2">actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="admin_table_data">
      <table cellspacing="0" cellpadding="0">
        <tbody>
<?php
  foreach($products as $p):
    $category = Category::find_by_id($p->category_id);
    $producer = Product::find_by_id($p->producer_id)
?>
          <tr>
            <td width="6%"><?php echo $p->id; ?></td>
            <td width="10%"><?php echo $p->name; ?></td>
            <td width="13%"><?php echo $category->name; ?></td>
            <td width="8%"><?php echo $p->craft_time; ?></td>
            <td width="8%"><?php echo $p->craft_speed; ?></td>
            <td width="8%"><?php echo $p->energy_cons; ?></td>
            <td width="8%"><?php echo $p->energy_prod; ?></td>
            <td width="9%"><?php echo $producer->name; ?></td>
            <td width="10%"><?php echo $p->qty_produced; ?></td>
            <td width="8%"><?php echo $p->is_disp; ?></td>
            <td width="6%"><a href="?id=<?php echo $p->id; ?>&x">edit</a></td>
            <td width="6%"><a href="?id=<?php echo $p->id; ?>&x=d">del</a></td>
          </tr>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div><!-- end .admin_data -->
  <div class="admin_form">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <fieldset>
        <legend><?php if($edit==1) { echo "Edit: <span>{$name}</span>"; } else { echo "New Product"; } ?></legend>
<?php if($edit==1): ?>
        <input type="hidden" name="id" id="id" value="<?php echo $productid; ?>">
<?php endif; ?>
        <p>
          <label for="name">name</label>
          <input name="name" id="name" type="text" value="<?php echo $name; ?>">
        </p>
        <p>
          <label for="category_id">category</label>
            <select name="category_id" id="category_id">
<?php foreach($categorys as $c): ?>
              <option value="<?php echo $c->id; ?>"<?php echo $c->id == $category_id ? " selected='selected'" : ""; ?>><?php echo $c->name; ?></option>
<?php endforeach; ?>
            </select>
        </p>
        <p>
          <label for="craft_time">craft time</label>
          <input name="craft_time" id="craft_time" type="text" value="<?php echo $craft_time; ?>">
        </p>
        <p>
          <label for="craft_speed">craft speed</label>
          <input name="craft_speed" id="craft_speed" type="text" value="<?php echo $craft_speed; ?>">
        </p>
        <p>
          <label for="energy_cons">energy consumption</label>
          <input name="energy_cons" id="energy_cons" type="text" value="<?php echo $energy_cons; ?>">
        </p>
        <p>
          <label for="energy_prod">energy production</label>
          <input name="energy_prod" id="energy_prod" type="text" value="<?php echo $energy_prod; ?>">
        </p>
        <p>
          <label for="qty_produced">qty produced</label>
          <input name="qty_produced" id="qty_produced" type="text" value="<?php echo $qty_produced; ?>">
        </p>
        <p>
          <label for="producer_id">producer</label>
          <select name="producer_id" id="producer_id">
<?php foreach($producers as $p): if($p->is_disp !=0): ?>
            <option value="<?php echo $p->id; ?>"<?php echo $p->id ==$producer_id ? " selected='selected'" : ""; ?> ><?php echo $p->name; ?></option>
<?php endif; endforeach; ?>
          </select>
        </p>
        <p>
          <label for="is_disp">
            <input type="checkbox" name="is_disp" id="is_disp" value="1"<?php echo $is_disp == 1 ? " checked='checked'" : ""; ?>>Visible
          </label>
        </p>
        <p>
          <button type="submit" name="submit">save</button><?php if($edit==0): ?><button type="reset" name="reset">clear</button><?php endif; ?><?php if($edit==1): ?><button class="btn_cancel" href="index.php?id=<?php echo $productid; ?>">cancel</button><?php endif; ?>
        </p>
      </fieldset>
    </form>
  </div><!-- end .admin_form -->
  <div id="msg"><p><?php echo $msg; ?></p></div>
</section>