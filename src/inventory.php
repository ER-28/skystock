<?php
    session_start();
    
    require_once 'components/head.php';
    require_once 'components/header.php';
    require_once 'components/inventory_item.php';
    require_once 'lib/service/AuthService.php';
    require_once 'db/models/Product.php';
    require_once 'db/models/Categories.php';
    require_once 'components/error_toast.php';
    render_error_toast();
    
    use db\models\Categories;
    use db\models\Product;
    use lib\orm\Query;
    use lib\service as Service;
    
    Service\AuthService::checkAuth();
    
    if (isset($_GET['search'])) {
        $query = new Query(new Product());
        $products = $query
            ->where('category_id', $_GET['search'])
            ->get();
    } else {
        $query = new Query(new Product());
        $products = $query->get();
    }

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
    <div class="flex flex-row gap-6 mt-4">
      <a href="?" class='bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-16' type='button'>
        Tout categories
      </a>
        <?php
            $query = new Query(new Categories());
            $categories = $query->get()->arr();
            
            foreach ($categories as $category) {
                echo "
                    <a href='?search={$category->getData()['id']}' class='bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-16' type='button'>
                      {$category->getData()['name']}
                    </a>
                  ";
            }
        ?>
    </div>
    <div class="flex flex-row gap-6 mt-4 ">
      <div class="flex flex-col gap-4 w-full">
        <?php
            if (count($products->arr()) === 0) {
                echo '<p class="text-center">No products found</p>';
            }
            
            foreach ($products->arr() as $product) {
                render_inventory_item($product);
            }
        ?>
      </div>
    </div>

</body>
</html>