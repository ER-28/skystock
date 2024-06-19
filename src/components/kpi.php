<?php
    
    use db\models\Users;
    use lib\orm\Query;
    
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/lib/orm/Query.php';
    require_once $root . '/db/models/Users.php';
    require_once $root . '/db/models/Product.php';
    require_once $root . '/db/models/Categories.php';
    
    
    function render_kpi(): void
    {
        // kpi : user number category number product number total price total stock
        $query = new Query(new Users());
        $users = $query->get()->arr();
        $user_number = count($users);
        
        $query = new Query(new \db\models\Categories());
        $categories = $query->get()->arr();
        $category_number = count($categories);
        
        $query = new Query(new \db\models\Product());
        $products = $query->get()->arr();
        $product_number = count($products);
        
        $total_price = 0;
        $total_stock = 0;
        
        foreach ($products as $product) {
            $total_price += $product->getData()['price'] * $product->getData()['stock'];
            $total_stock += $product->getData()['stock'];
        }
        
        echo '
            <div class="flex flex-col bg-slate-800 text-gray-200 rounded border border-blue-300 p-4">
                <div class="flex flex-row justify-between items-center rounded-lg">
                    <div class="flex flex-row gap-4 justify-around w-full items-center">
                        <p class="text-white text-xl font-bold">KPI</p>
                    </div>
                </div>
        ';
        
        echo '
                <div class="flex flex-row justify-between items-center">
                    <div class="flex flex-row gap-4 justify-around w-full items-center">
                        <p class="text-white text-xl font-bold">User number: '.$user_number.'</p>
                        <p class="text-white text-xl font-bold">Category number: '.$category_number.'</p>
                        <p class="text-white text-xl font-bold">Product number: '.$product_number.'</p>
                        <p class="text-white text-xl font-bold">Total price: '.$total_price.'$</p>
                        <p class="text-white text-xl font-bold">Total stock: '.$total_stock.'</p>
                    </div>
                </div>
            </div>
        ';
        
    }