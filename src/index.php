<?php
  session_start();

  require_once 'components/head.php';
  require_once 'components/header.php';
  require_once 'lib/service/AuthService.php';
  use lib\service as Service;

  Service\AuthService::checkAuth();

?>

<!doctype html>
<html lang="en">

  <?php
    render_head('Acceuil')
  ?>

  <body>

    <?php
      render_header();
    ?>

  </body>
</html>