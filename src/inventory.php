<?php
    session_start();
    
    require_once 'components/head.php';
    require_once 'components/header.php';
    require_once 'components/inventory_item.php';
    require_once 'lib/service/AuthService.php';
    require_once 'db/models/Product.php';
    
    use db\models\Product;
    use lib\orm\Query;
    use lib\service as Service;
    
    Service\AuthService::checkAuth();

?>

<!doctype html>
<html lang="en" class="bg-slate-950 text-white">

<?php
    render_head('Inventory')
?>

<body>

  <?php
      render_header();
  ?>

  <div class="p-8">
    <div class="flex flex-row justify-between items-center">
      <p class="font-bold text-2xl">Inventory</p>
      <a href="/add_product.php">
        <button class="bg-sky-800 hover:bg-sky-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-16" type="button">
          Add Product
        </button>
      </a>
    </div>
    <div class="flex flex-row gap-6 h-screen mt-4 ">
<!--      <div class="flex flex-row justify-between w-64 bg-slate-900 rounded-xl">-->
<!--        <p>filter</p>-->
<!--      </div>-->
      <div class="flex flex-col gap-4 w-full">
        <?php
            $product = new Product();
            $query = new Query($product);
            $products = $query->get();
            
            foreach ($products->arr() as $product) {
                render_inventory_item($product);
            }
        ?>
    </div>

</body>
</html>