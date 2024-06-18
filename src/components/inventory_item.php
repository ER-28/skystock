<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/db/models/Categories.php';
    require_once $root . '/lib/orm/Query.php';
    
    use db\models\Categories;
    use lib\orm\Query;
    
    if (!isset($_SESSION)) {
        session_start();
    }
    
    function render_inventory_item(\lib\orm\OrmModel $product): void
    {
        
        $query = new Query(new Categories());
        $category = $query
            ->where('id', $product->getData()['category_id'])
            ->get()
            ->first();
        
        echo '
            <div class="flex flex-row justify-between items-center bg-slate-900 p-4 rounded-lg w-full">
                <div class="flex flex-row gap-4 justify-around w-full items-center">
                    <p class="text-white text-xl font-bold">'.$product->getData()['name'].'</p>
                    <p class="text-white text-md">Stock: '.$product->getData()['stock'].'</p>
                    <p class="text-white">Price: $'.$product->getData()['price'].'</p>
                    ' .($category ? '<p class="text-white">Category: '.$category->getData()['name'].'</p>' : '').'
                </div>
                <div class="flex flex-row gap-4">
                    <a href="/forms/edit-product.php?id='.$product->getData()['id'].'">
                        <button class="bg-sky-800 hover:bg-sky-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-4" type="button">
                            Edit
                        </button>
                    </a>
                    <a href="/forms/delete-product.php?id='.$product->getData()['id'].'">
                        <button class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-4" type="button">
                            Delete
                        </button>
                    </a>
                </div>
            </div>
        ';
        
    }