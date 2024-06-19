<?php
    session_start();
    
    require_once "../lib/orm/Query.php";
    require_once "../db/models/Categories.php";
    
    use db\models\Categories;
    use JetBrains\PhpStorm\NoReturn;
    use lib\orm\Query;
    
    #[NoReturn] function redirect_to_page($err): void
    {
        header('Location: /admin.php?error='.$err);
        exit();
    }
    
    if (
        !isset($_POST['name'])
    ) {
        redirect_to_page('empty fields');
    }
    
    $name = $_POST['name'];
    
    if (empty($name)) {
        redirect_to_page('empty fields');
    }
    
    if (!is_string($name)) {
        redirect_to_page('name is not a string');
    }
    
    if (strlen($name) < 3) {
        redirect_to_page('name is too short');
    }
    
    $category = new Categories();
    $category->setData([
        'name' => $name,
    ]);
    $category->save();
    
    header('Location: /admin.php');
    
