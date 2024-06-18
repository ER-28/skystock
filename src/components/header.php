<?php
    
    use db\models\Users;
    
    if (!isset($_SESSION)) {
        session_start();
    }

    function render_header(): void
    {
        $colors = [
            'red', 'blue', 'green', 'yellow', 'indigo', 'purple', 'pink', 'gray', 'white', 'black', 'slate', 'sky'
        ];
        $variants = [500, 600, 700];
        
        if (isset($_SESSION['color'])) {
            $color = $_SESSION['color'];
        }
        if (isset($_SESSION['variant'])) {
            $variant = $_SESSION['variant'];
        }
        
        if (!isset($color)) {
            $color = $colors[rand(0, count($colors) - 1)];
        }
        if (!isset($variant)) {
            $variant = $variants[rand(0, count($variants) - 1)];
        }
        
        
        $user = new Users();
        $user = $user->getById($_SESSION['user']);
        
        echo "
            <header class='flex flex-row justify-between items-center bg-slate-950 p-4 border-b border-slate-600'>
                <p class='text-4xl font-bold text-white'><span class='text-blue-400'>Sky</span><span>stock</span></p>
                <div class='flex flex-row gap-10'>
                    <a href='' class='text-white border-b py-3 px-6 hover:border-blue-500 transition-colors'>
                        Dashboard
                    </a>
                    <a href='' class='text-white border-b py-3 px-6 hover:border-blue-500 transition-colors'>
                        Inventory
                    </a>
                    <a href='' class='text-white border-b py-3 px-6 hover:border-blue-500 transition-colors'>
                        Sales
                    </a>
                </div>
                <a>
                    <div class='flex flex-column justify-center content-center w-10 h-10 p-1 text-center rounded-full ring-2 ring-gray-300 dark:ring-gray-500 bg-".$color."-".$variant."'>
                        <p class='text-white text-xl'>".$user->getData()['username'][0]."</p>
                    </div>
                </a>
            </header>
        ";
    }