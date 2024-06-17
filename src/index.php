<?php

use lib\service\AuthService;
use function lib\components\render_head;
use function lib\components\render_header;

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