<?php
    session_start();
    
    require_once 'components/head.php';
    require_once 'components/header.php';
    require_once 'lib/service/AuthService.php';
    require_once 'components/error_toast.php';
    render_error_toast();
    use lib\service as Service;
    
    Service\AuthService::checkAuth();

?>

<!doctype html>
<html lang="en" class="bg-slate-950 text-white">

<?php
    render_head('Sales')
?>

<body>

<?php
    render_header();
?>

</body>
</html>