<?php
  $msg = "";
  $edit=0;
  // save
  if(isset($_POST['submit'])) {
    $recipe = new Recipe();
    $recipe->id = isset($_POST['id']) ? $_POST['id'] : NULL;
    $recipe->product_id = isset($_POST['product_id']) ? mysql_prep($_POST['product_id']) : NULL;
    $recipe->ingredient_id = isset($_POST['ingredient_id']) ? mysql_prep($_POST['ingredient_id']) : NULL;
    $recipe->qty_need = isset($_POST['qty_need']) ? mysql_prep($_POST['qty_need']) : NULL;
    $recipe->is_disp = isset($_POST['is_disp']) ? 1 : 0;
    $msg .= ($recipe && $recipe->save()) ? "Recipe created successfully" : "Recipe not created";
    $edit=0;
  }

  // edit/delete
  if(isset($_GET['id']) && isset($_GET['x'])) {
    $edit=1;
    $recipe = Recipe::find_by_id($_GET['id']);
    if($_GET['x'] == "d") {
      $edit=0;
      if($recipe && $recipe->delete()) { $msg .= "Recipe successfully deleted."; }
    }
  }

  // view
  $recipes = Recipe::find_all();
  $products = Product::find_all($ord="name");

  $recipeid = $edit==1 && isset($recipe->id) ? $recipe->id : "";
  $product_id = $edit==1 && isset($recipe->product_id) ? $recipe->product_id : "";
  $ingredient_id = $edit==1 && isset($recipe->ingredient_id) ? $recipe->ingredient_id : "";
  $qty_need = $edit==1 && isset($recipe->qty_need) ? $recipe->qty_need : "";
  $is_disp = $edit==1 && isset($recipe->is_disp) ? $recipe->is_disp : 1;
?>
<section id="user">
  <h1>recipe</h1>
  <div class="admin_data">
    <div class="admin_table_head">
      <table cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th width="8%">id</th>
            <th width="29%">Product</th>
            <th width="28%">Ingredient</th>
            <th width="15%">Qty</th>
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
  foreach($recipes as $r):
    $product = Product::find_by_id($r->product_id);
    $ingredient = Product::find_by_id($r->ingredient_id);
?>
          <tr>
            <td width="8%"><?php echo $r->id; ?></td>
            <td width="29%"><?php echo $product->name; ?></td>
            <td width="28%"><?php echo $ingredient->name; ?></td>
            <td width="15%"><?php echo $r->qty_need; ?></td>
            <td width="8%"><?php echo $r->is_disp; ?></td>
            <td width="6%"><a href="?id=<?php echo $r->id; ?>&x">edit</a></td>
            <td width="6%"><a href="?id=<?php echo $r->id; ?>&x=d">del</a></td>
          </tr>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div><!-- end .admin_data -->
  <div class="admin_form">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <fieldset>
        <legend><?php if($edit==1) { echo "Edit: <span>{$recipeid}</span>"; } else { echo "New Recipe"; } ?></legend>
      <?php if($edit==1): ?>
        <input type="hidden" name="id" id="id" value="<?php echo $recipeid; ?>">
      <?php endif; ?>
        <p>
          <label for="product_id" data-test="<?php echo $r->product_id; ?>">product</label>
          <select name="product_id" id="product_id">
          <?php foreach($products as $p): if($p->is_disp !=0): ?>
            <option value="<?php echo $p->id; ?>"<?php echo ($p->id == $product_id) ? " selected='selected'" : ""; ?>><?php echo $p->name; ?></option>
          <?php endif; endforeach; ?>
          </select>
        </p>
        <p>
          <label for="ingredientt_id">ingredient</label>
          <select name="ingredient_id" id="ingredient_id">
          <?php foreach($products as $p): if($p->is_disp !=0): ?>
            <option value="<?php echo $p->id; ?>"<?php echo $p->id == $ingredient_id ? " selected='selected'" : ""; ?> ><?php echo $p->name; ?></option>
          <?php endif; endforeach; ?>
          </select>
        </p>
        <p>
          <label for="qty_need">qty needed</label>
          <input name="qty_need" id="qty_need" type="text" value="<?php echo $qty_need; ?>">
        </p>
        <p>
          <label for="is_disp">
            <input type="checkbox" name="is_disp" id="is_disp" value="1"<?php echo $is_disp == 1 ? " checked='checked'" : ""; ?>>Visible
          </label>
        </p>
        <p>
          <button type="submit" name="submit">save</button><?php if($edit==0): ?><button type="reset" name="reset">clear</button><?php endif; ?><?php if($edit==1): ?><button class="btn_cancel" href="index.php?id=<?php echo $recipeid; ?>">cancel</button><?php endif; ?>
        </p>
      </fieldset>
    </form>
  </div><!-- end .admin_form -->
  <div id="msg"><p><?php echo $msg; ?></p></div>
</section>