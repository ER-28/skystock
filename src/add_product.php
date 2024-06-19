<?php
    session_start();
    
    require_once 'components/head.php';
    require_once 'lib/service/AuthService.php';
    require_once 'lib/orm/Query.php';
    require_once 'db/models/Categories.php';
    require_once 'components/error_toast.php';
    render_error_toast();
    
    use db\models\Categories;
    use lib\orm\Query;
    use lib\service as Service;
    
    Service\AuthService::checkAuth();

?>

<!doctype html>
<html lang="en" class="bg-slate-950 text-white">

    <?php
        render_head('Ajouter un produit');
        
        $query = new Query(new Categories());
        $categories_array = $query->get()->arr();
    ?>
    
    
    <body>
    <div class="flex flex-row justify-center items-center h-screen w-full bg-slate-950">
        <div class="container max-w-xl bg-slate-800 p-8 text-gray-200 rounded border border-blue-300">
            <form action="forms/add_product.php" method="post" class="w-full flex flex-col gap-5">
                <p class="font-bold text-xl">Ajout d'un produit</p>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-bold mb-2">Nom</label>
                    <input
                        type="text" name="name" id="name" placeholder="Nom du produit"
                        class="shadow appearance-none border border-blue-300 rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline bg-slate-800"
                    >
                </div>
                <div class="mb-6">
                    <label for="price" class="block text-sm font-bold mb-2">Prix</label>
                    <input
                        type="number" name="price" id="price" placeholder="Prix du produit"
                        class="shadow appearance-none border border-blue-300 rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline bg-slate-800"
                    >
                </div>
                <div class="mb-6">
                    <label for="stock" class="block text-sm font-bold mb-2">Stock</label>
                    <input
                        type="number" name="stock" id="stock" placeholder="Stock du produit"
                        class="shadow appearance-none border border-blue-300 rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline bg-slate-800"
                    >
                </div>
                <div class="mb-6">
                    <label for="category" class="block text-sm font-bold mb-2">Category</label>
                    <select
                        name="category" id="category"
                        class="shadow appearance-none border border-blue-300 rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline bg-slate-800"
                    >
                        <?php
                            foreach ($categories_array as $category) {
                                echo "<option value='".$category->getData()['id']."'>".$category->getData()['name']."</option>";
                            }
                        ?>
                    </select>
                </div>
                
                <div class="flex items-center justify-between">
                    <a href="/inventory.php">
                        <button class="bg-slate-700 hover:bg-slate-600 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-16" type="button">
                            Annuler
                        </button>
                    </a>
                    <button class="bg-sky-800 hover:bg-sky-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-16" type="submit">
                        Creer
                    </button>
                </div>
        </div>
    </div>
    
    </body>
</html>