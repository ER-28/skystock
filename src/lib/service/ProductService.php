<?php
    
    namespace lib\service {
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        require_once $root . '/db/models/Product.php';
        require_once $root . '/lib/orm/Query.php';
        
        use db\models\Product;
        use lib\orm\Query;
        
        class ProductService
        {
            
            public static function getAllProducts(): array
            {
                $product = new Product();
                $query = new Query($product);
                $products = $query->get();
                
                return $products->arr();
            }
        }
    }