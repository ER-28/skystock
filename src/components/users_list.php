<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/db/models/Users.php';
    require_once $root . '/lib/orm/Query.php';
    
    use db\models\Users;
    use lib\orm\Query;
    
    if (!isset($_SESSION)) {
        session_start();
    }
    
    function render_users_list(\lib\orm\OrmModel $user): void
    {
        $role = $user->getData()['role'] === '1' ? 'Admin' : 'User';
        
        echo '
            <div class="flex flex-row justify-between items-center bg-slate-900 p-4 rounded-lg w-full mt-8">
                <div class="flex flex-row gap-4 justify-around w-full items-center">
                    <p class="text-white text-xl font-bold">Nom: '.$user->getData()['username'].'</p>
                    <p class="text-white text-md">Email: <span class="font-bold">'.$user->getData()['email'].'</span></p>
                    <p class="text-white">Role: <span class="font-bold">'.$role.'</span></p>
                </div>
                <div class="flex flex-row gap-4">
                    <a href="/edit_product.php?id='.$user->getData()['id'].'">
                        <button class="bg-sky-800 hover:bg-sky-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-4" type="button">
                            Edit
                        </button>
                    </a>
                    <a href="/forms/delete_product.php?id='.$user->getData()['id'].'">
                        <button class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-4" type="button">
                            Delete
                        </button>
                    </a>
                </div>
            </div>
        ';
        
    }