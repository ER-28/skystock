<?php
  require_once 'components/head.php';
  require_once 'components/header.php';
  require_once 'db/models/Users.php';
  require_once 'lib/service/AuthService.php';

  AuthService::checkAuth();
?>

<!doctype html>
<html lang="en">

  <?php
    render_head('test')
  ?>

  <body>

    <?php
      render_header();
    ?>

  </body>
</html>