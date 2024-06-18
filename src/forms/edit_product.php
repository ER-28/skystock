<?php
    session_start();
    
    require_once "../lib/orm/Query.php";
    require_once "../db/models/Categories.php";
    require_once "../db/models/Product.php";
    
    use db\models\Categories;
    use db\models\Product;
    use JetBrains\PhpStorm\NoReturn;
    use lib\orm\Query;
    
    #[NoReturn] function redirect_to_page($err): void
    {
        header('Location: /add_product.php?error='.$err);
        exit();
    }
    
    if (
        !isset($_GET['id']) ||
        !isset($_POST['name']) ||
        !isset($_POST['price']) ||
        !isset($_POST['stock']) ||
        !isset($_POST['category'])
    ) {
        redirect_to_page('empty fields');
    }
    
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category'];
    
    if (empty($name) || empty($price) || empty($stock) || empty($category_id)) {
        redirect_to_page('empty fields');
    }
    
    if (!is_numeric($price) || !is_numeric($stock) || !is_numeric($_GET['id'])) {
        redirect_to_page('price or stock is not a number');
    }
    
    if ($price < 0 || $stock < 0) {
        redirect_to_page('price or stock is negative');
    }
    
    $query = new Query(new Categories());
    $category = $query
        ->where('id', $category_id)
        ->get()
        ->first();
    
    if ($category === null) {
        redirect_to_page('category does not exist');
    }
    
    $query = new Query(new Product());
    $product = $query
        ->where('id', $_GET['id'])
        ->get()
        ->first();
    
    $product->setData([
        'name' => $name,
        'price' => $price,
        'stock' => $stock,
        'category_id' => $category_id
    ]);
    
    $product->update();
    
    header('Location: /inventory.php');
    
