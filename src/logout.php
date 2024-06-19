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
    render_head('Logout')
?>

<body>

<?php
    render_header();
?>

    <div class="container mx-auto">
        <div class="flex flex-row mt-8">
            <div class="w-full bg-slate-800 p-8 text-gray-200 rounded border border-blue-300">
                <p class="font-bold text-xl">Logout</p>
                <div class="mb-4">
                    <p class="block text
                    -sm font-bold mb-2">Are you sure you want to logout?</p>
                </div>
                <div class="flex items center justify-between">
                    <a href="/forms/logout.php" class="bg-sky-800 hover:bg-sky-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-16">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>