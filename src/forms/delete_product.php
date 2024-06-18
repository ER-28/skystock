<?php
    
    session_start();
    
    require_once "../lib/orm/Query.php";
    require_once "../db/models/Product.php";
    
    use db\models\Categories;
    use db\models\Product;
    use JetBrains\PhpStorm\NoReturn;
    use lib\orm\Query;
    
    #[NoReturn] function redirect_to_page($err): void
    {
        header('Location: /add_product.php?error=' . $err);
        exit();
    }
    
    if (
        !isset($_GET['id'])
    ) {
        redirect_to_page('empty fields');
    }
    
    $id = $_GET['id'];
    
    if (empty($id)) {
        redirect_to_page('empty fields');
    }
    
    if (!is_numeric($id)) {
        redirect_to_page('id is not a number');
    }
    
    if ($id < 0) {
        redirect_to_page('id is negative');
    }
    
    $query = new Query(new Product());
    $product = $query
        ->where('id', $id)
        ->get()
        ->first();
    
    if ($product === null) {
        redirect_to_page('product does not exist');
    }
    
    $product->delete();
    
    header('Location: /inventory.php');
    
