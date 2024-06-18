<?php
  session_start();

  require_once 'components/head.php';
  require_once 'components/header.php';
  require_once 'lib/service/AuthService.php';
  require_once 'lib/orm/Query.php';
  require_once 'db/models/Users.php';
    
    use lib\orm\Query;
    use db\models\Users;
    use lib\service as Service;

  Service\AuthService::checkAuth();
  
  $queryUser = new Query(new Users());
  $users = $queryUser
    ->where('id', $_SESSION['user'])
    ->get()
    ->first();
  
  if ($users->getData()['role'] !== '1') {
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

  </body>
</html>