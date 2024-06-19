<?php
  session_start();

  require_once 'components/head.php';
  require_once 'components/header.php';
  require_once 'components/users_list.php';
  require_once 'components/categories_list.php';
  require_once 'lib/service/AuthService.php';
  require_once 'lib/orm/Query.php';
  require_once 'db/models/Users.php';
  require_once 'db/models/Categories.php';
    require_once 'components/error_toast.php';
    render_error_toast();
    
    use db\models\Categories;
    use lib\orm\Query;
    use db\models\Users;
    use lib\service as Service;

  Service\AuthService::checkAuth();
  
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
    render_head('Dashboard')
  ?>

  <body>

    <?php
      render_header();
    ?>

    <div class="container mx-auto">
      <form action="/forms/add_category.php" method="post" class="flex flex-row mt-8">
        <div class="w-full bg-slate-800 p-8 text-gray-200 rounded border border-blue-300">
          <p class="font-bold text-xl">Ajouter une catégorie</p>
          <div class="mb-4">
            <label for="name" class="block text-sm font-bold mb-2">Nom</label>
            <input
              type="text" name="name" id="name"
              class="shadow appearance-none border border-blue-300 rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline bg-slate-800"
            >
          </div>
          <div class="flex items-center justify-between">
            <button class="bg-sky-800 hover:bg-sky-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-16" type="submit">
              Ajouter
            </button>
          </div>
        </div>
      </form>

      <p class="font-bold text-xl my-8 mx-4">Liste des catégories</p>
        
        <?php
            $query = new Query(new Categories());
            $categories = $query
                ->get()->arr();
            
            if (empty($categories)) {
                echo '<p class="text-white text-center">Aucune catégorie n\'a été trouvée</p>';
            }
            
            foreach ($categories as $category) {
                render_category_list($category);
            }
        ?>
      <p class="font-bold text-xl my-8 mx-4">Liste des utilisateurs</p>
        
        <?php
            $query = new Query(new Users());
            $users = $query
                ->get()
                ->arr();
            
            if (empty($users)) {
                echo '<p class="text-white text-center">Aucun utilisateur n\'a été trouvé</p>';
            }
            
            foreach ($users as $user) {
                render_users_list($user);
            }
        ?>
    </div>

  </body>
</html>