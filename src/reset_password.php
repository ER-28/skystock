<?php
    require_once 'components/head.php';
    session_start();
    require_once 'components/error_toast.php';
    render_error_toast();
?>

<!doctype html>
<html lang="en">

<?php
    render_head('Connexion')
?>

<body>
<div class="flex flex-row justify-center items-center h-screen w-full bg-slate-950">
    <div class="container max-w-xl bg-slate-800 p-8 text-gray-200 rounded border border-blue-300">
        <form action="forms/reset_password.php" method="post" class="w-full flex flex-col gap-5">
            <p class="font-bold text-xl">Mot de passe oublié</p>
            <div class="mb-4">
                <label for="password" class="block text-sm font-bold mb-2">Nouveau mot de passe</label>
                <input
                    type="password" name="password" id="password"
                    class="shadow appearance-none border border-blue-300 rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline bg-slate-800"
                >
            </div>
            <div class="mb-4">
                <label for="password_confirm" class="block text-sm font-bold mb-2">Confirmation</label>
                <input
                    type="password" name="password_confirm" id="password_confirm"
                    class="shadow appearance-none border border-blue-300 rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline bg-slate-800"
                >
            </div>
            <div class="flex items-center justify-between">
                <a href="/login.php">
                    <button class="bg-slate-700 hover:bg-slate-600 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-16" type="button">
                        Cancel
                    </button>
                </a>
                <button class="bg-sky-800 hover:bg-sky-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-16" type="submit">
                    Continuer
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>