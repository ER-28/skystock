<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/db/models/Categories.php';
    require_once $root . '/db/models/Product.php';
    require_once $root . '/lib/orm/Query.php';
    require_once $root . '/components/inventory_item.php';
    
    
    use lib\orm\Query;
    
    if (!isset($_SESSION)) {
        session_start();
    }
    
    function critical_product_list(): void
    {
        
        $query = new Query(new \db\models\Product());
        $products = $query
            ->where('stock', 10, '<')
            ->get()
            ->arr();
        
        echo '
            <div class="flex flex-row justify-between items-center bg-slate-900 p-4 rounded-lg mt-8">
                <div class="flex flex-row gap-4 justify-around w-full items-center">
                    <p class="text-white text-xl font-bold">Produit bientot en rupture</p>
                </div>
            </div>
        ';
        
        echo count($products) === 0 ? '<p class="text-white text-xl font-bold mt-4">No critical products</p>' : '';
        
        foreach ($products as $product) {
            render_inventory_item($product);
        }
        
    }