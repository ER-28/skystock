<?php
    session_start();
    
    require_once 'components/head.php';
    require_once 'lib/service/AuthService.php';
    require_once 'lib/orm/Query.php';
    require_once 'db/models/Categories.php';
    require_once 'db/models/Users.php';
    
    use db\models\Categories;
    use db\models\Users;
    use lib\orm\Query;
    use lib\service as Service;
    
    Service\AuthService::checkAuth();
    
    $category_id = $_GET['id'];
    
    $query = new Query(new Categories());
    $category = $query->where('id', $category_id)->get()->first();
    
    $queryUser = new Query(new Users());
    $user = $queryUser
        ->where('id', $_SESSION['user'])
        ->get()
        ->first();
    
    if ($user->getData()['role'] !== '1') {
        header('Location: /');
    }

?>

<!doctype html>
<html lang="en" class="bg-slate-950 text-white">

    <?php
        render_head('Ajouter un produit');
    ?>
    
    
    <body>
    <div class="flex flex-row justify-center items-center h-screen w-full bg-slate-950">
        <div class="container max-w-xl bg-slate-800 p-8 text-gray-200 rounded border border-blue-300">
            <form action="forms/edit_category.php?id=<?php echo $category_id?>" method="post" class="w-full flex flex-col gap-5">
                <p class="font-bold text-xl">Modification d'une catégory</p>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-bold mb-2">Nom</label>
                    <input
                        type="text" name="name" id="name" placeholder="Nom du produit" value="<?php echo $category->getData()['name']; ?>"
                        class="shadow appearance-none border border-blue-300 rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline bg-slate-800"
                    >
                </div>
                
                <div class="flex items-center justify-between">
                    <a href="/admin.php">
                        <button class="bg-slate-700 hover:bg-slate-600 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-16" type="button">
                            Annuler
                        </button>
                    </a>
                    <button class="bg-sky-800 hover:bg-sky-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-16" type="submit">
                        Modifier
                    </button>
                </div>
        </div>
    </div>
    
    </body>
</html>