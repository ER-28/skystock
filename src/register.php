<?php
require_once 'components/head.php';
session_start();
?>

<!doctype html>
<html lang="en">

<?php
render_head("S'enregistrer")
?>

<body>
<div class="flex flex-row justify-center items-center h-screen w-full bg-gray-800">
    <div class="container max-w-xl bg-gray-500 p-8 text-gray-200">
        <form action="forms/register.php" method="post" class="w-full flex flex-col gap-5">
            <p class="font-bold">S'enregister</p>
            <div class="mb-4">
                <label for="username" class="block text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-bold mb-2">Email</label>
                <input type="text" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="password_confirm" class="block text-sm font-bold mb-2">Password</label>
                <input type="password" name="password_confirm" id="password" class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Register
                </button>
            </div>
    </div>
</div>

</body>
</html>