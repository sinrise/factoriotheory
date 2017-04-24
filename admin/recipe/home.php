<?php
  $msg = "";

  // save
  if(isset($_POST['submit']) && isset($_POST['id'])) {
    $recipe = new Recipe();
    $recipe->id = $_POST['id'];
    $recipe->product_id = isset($_POST['product_id']) ? mysql_prep($_POST['product_id']) : NULL;
    $recipe->ingredient_id = isset($_POST['ingredient_id']) ? mysql_prep($_POST['ingredient_id']) : NULL;
    $recipe->producer_id = isset($_POST['producer_id']) ? mysql_prep($_POST['producer_id']) : "";
    $recipe->qty_need = isset($_POST['qty_need']) ? mysql_prep($_POST['qty_need']) : NULL;
    $recipe->is_disp = isset($_POST['is_disp']) ? 1 : 0;
    $msg .= ($recipe && $recipe->save()) ? "Recipe created successfully" : "Recipe not created";
  }

  // edit/delete
  if(isset($_GET['id']) && isset($_GET['x'])) {
    $recipe = Recipe::find_by_id($_GET['id']);
    if($_GET['x'] == "d") {
      if($recipe && $recipe->delete()) { $msg .= "Recipe successfully deleted."; }
    }
  }

  // view
  $recipes = Recipe::find_all();
  $products = Product::find_all();

  $recipeid = isset($recipe->id) ? $recipe->id : "";
  $product_id = isset($recipe->product_id) ? $recipe->product_id : "";
  $ingredient_id = isset($recipe->ingredient_id) ? $recipe->ingredient_id : "";
  $producer_id = isset($recipe->producer_id) ? $recipe->producer_id : "";
  $qty_need = isset($recipe->qty_need) ? $recipe->qty_need : "";
  $is_disp = isset($recipe->is_disp) ? $recipe->is_disp : 1;
?>
<section id="user">
  <h1>recipe</h1>
  <div id="msg"><p><?php echo $msg; ?></p></div>
  <div class="admin_data">
    <table cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th width="8%">id</th>
          <th width="19%">Product</th>
          <th width="19%">Ingredient</th>
          <th width="15%">Qty</th>
          <th width="19%">Producer</th>
          <th width="8%">visible</th>
          <th width="12%" colspan="2">actions</th>
        </tr>
      </thead>
    </table>
    <table cellspacing="0" cellpadding="0">
      <tbody>
<?php
  foreach($recipes as $r):
    $ingredient = Product::find_by_id($r->ingredient_id);
    $product = Product::find_by_id($r->product_id);
    $producer = Product::find_by_id($r->producer_id)
?>
        <tr>
          <td width="8%"><?php echo $r->id; ?></td>
          <td width="19%"><?php echo $product->name; ?></td>
          <td width="19%"><?php echo $ingredient->name; ?></td>
          <td width="15%"><?php echo $r->qty_need; ?></td>
          <td width="19%"><?php echo $producer->name; ?></td>
          <td width="8%"><?php echo $r->is_disp; ?></td>
          <td width="6%"><a href="?id=<?php echo $r->id; ?>&x">edit</a></td>
          <td width="6%"><a href="?id=<?php echo $r->id; ?>&x=d">del</a></td>
        </tr>
<?php endforeach; ?>
      </tbody>
    </table>
  </div><!-- end .admin_data -->
  <div class="admin_form">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <fieldset>
        <legend><?php if($recipeid) { echo "Edit: <span>{$recipeid}</span>"; } else { echo "New Recipe"; } ?></legend>
      <?php if($recipeid): ?>
        <input type="hidden" name="id" id="id" value="<?php echo $recipeid; ?>">
      <?php endif; ?>
        <p>
          <label for="product_id">product</label>
          <select name="product_id" id="product_id">
          <?php foreach($products as $p): ?>
            <option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
          <?php endforeach; ?>
          </select>
        </p>
        <p>
          <label for="ingredientt_id">ingredient</label>
          <select name="ingredient_id" id="ingredient_id">
          <?php foreach($products as $p): ?>
            <option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
          <?php endforeach; ?>
          </select>
        </p>
        <p>
          <label for="qty_need">qty needed</label>
          <input name="qty_need" id="qty_need" type="text" value="<?php echo $qty_need; ?>">
        </p>
        <p>
          <label for="producer_id">producer</label>
          <select name="producer_id" id="producer_id">
          <?php foreach($products as $p): ?>
            <option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
          <?php endforeach; ?>
          </select>
        </p>
        <p>
          <label for="is_disp">
            <input type="checkbox" name="is_disp" id="is_disp" value="1"<?php echo $is_disp == 1 ? " checked='checked'" : ""; ?>>Visible
          </label>
        </p>
        <p>
          <button type="submit" name="submit">save</button><button type="reset" name="reset">clear</button><?php if($recipeid): ?><button class="btn_cancel" href="index.php?id=<?php echo $recipeid; ?>">done</button><?php endif; ?>
        </p>
      </fieldset>
    </form>
  </div><!-- end .admin_form -->
</section>