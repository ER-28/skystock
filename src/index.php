<?php
  session_start();

  require_once 'components/head.php';
  require_once 'components/header.php';
  require_once 'components/query_list.php';
  require_once 'lib/service/AuthService.php';
    require_once 'components/error_toast.php';
    require_once 'components/critical_product_list.php';
    render_error_toast();
  use lib\service as Service;

  Service\AuthService::checkAuth();

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

    <div class="container mx-auto my-8">
      <?php
          render_query_list();
          critical_product_list();
      ?>
    </div>

  </body>
</html>