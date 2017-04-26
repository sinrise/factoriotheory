<style data-name="icon map" type="text/css">
<?php $ps = Product::find_all(); foreach($ps as $k=>$p): if($p->is_disp != 0):  ?>
  .picon-<?php echo str_replace(" ", "-", $p->name); ?>::before { background-image: url('<?php echo IMG_PATH.'icon/'.str_replace(" ", "-", $p->name); ?>.png'); }
<?php endif; endforeach; ?>
  .picon-stopwatch::before { background-image: url('<?php echo IMG_PATH; ?>icon/stopwatch.svg'); }
</style>
<section id="home">
  <h1>Factorio TheoryCrafting</h1>
  <h2>Coming soon! Stay Tuned!</h2>
  <p><a href="<?php echo SITE_URL; ?>changelog">In the meantime, checkout the list of upcoming changes and new features for Factorio v0.15!</a></p>
</section>
<section>
  <div class="crafting-container">
  <h3>crafting</h3>
<?php $categorys = Category::find_all(); ?>
    <div class="categories">
      <div class="tab-heads">
<?php foreach($categorys as $k=>$cath): ?>
        <div id="tab_head<?php echo $cath->id; ?>" class="tab-head"><a role="presentation tab" aria-controls="tab<?php echo $cath->id; ?>" href="#" data-target="#tab<?php echo $cath->id; ?>" title="<?php echo $cath->name; ?>" class="<?php echo $k == 0 ? ' active' : ''; ?>"><?php echo $cath->name; ?></a></div>
<?php endforeach; ?>
      </div>
    </div>
    <div class="products">
      <div class="tabs">
<?php foreach($categorys as $k=>$cat): $products = Product::find($wh="category_id", $eq=$cat->id); ?>
        <div id="tab<?php echo $cat->id; ?>" class="tab<?php echo $k == 0 ? ' active' : ''; ?>" role="tabpanel">
          <div class="list products">
<?php
  foreach($products as $k=>$p):
    $ingredients = Recipe::find($wh="product_id", $eq=$p->id);
    if($p->is_disp != 0):
?>
            <div id="item<?php echo $p->id; ?>" class="item picon picon-<?php echo str_replace(" ", "-", $p->name); ?> up"><?php echo $p->name; ?></div>
            <div class="tip">
              <p><?php echo $p->qty_produced."x ".$p->name; ?></p>
              <div class="picon picon-stopwatch down"></div><div class="craft-time"><?php echo $p->craft_time; ?></div>
<?php foreach($ingredients as $k=>$i): $rp = Product::find_by_id($i->ingredient_id); ?>
              <div class="ingredient">
                <div class="picon picon-<?php echo str_replace(" ", "-", $rp->name); ?> down"></div><div class="name"><?php echo $i->qty_need."x ".$rp->name; ?></div>
              </div>
<?php endforeach; ?>
            </div>
<?php endif; endforeach; ?>
          </div>
        </div>
<?php endforeach; ?>
      </div>
    </div>
  </div>
  </div>
</section>