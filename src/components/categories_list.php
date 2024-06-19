<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/db/models/Users.php';
    require_once $root . '/lib/orm/Query.php';
    
    use db\models\Users;
    use lib\orm\Query;
    
    if (!isset($_SESSION)) {
        session_start();
    }
    
    function render_category_list(\lib\orm\OrmModel $category): void
    {
        
        echo '
            <div class="flex flex-row justify-between items-center bg-slate-900 p-4 rounded-lg w-full mt-8">
                <div class="flex flex-row gap-4 justify-around w-full items-center">
                    <p class="text-white text-xl font-bold">Nom: '.$category->getData()['name'].'</p>
                </div>
                <div class="flex flex-row gap-4">
                    <a href="/edit_product.php?id='.$category->getData()['id'].'">
                        <button class="bg-sky-800 hover:bg-sky-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-4" type="button">
                            Edit
                        </button>
                    </a>
                    <a href="/forms/delete_product.php?id='.$category->getData()['id'].'">
                        <button class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-4" type="button">
                            Delete
                        </button>
                    </a>
                </div>
            </div>
        ';
        
    }