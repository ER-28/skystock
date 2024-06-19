<?php
    
    if (!isset($_SESSION)) {
        session_start();
    }
    
    function render_error_toast(): void
    {
        if (!isset($_GET['error'])) {
            return;
        }
        
        $error = $_GET['error'];
        
        echo "<div class='absolute right-0 bg-slate-900 text-white font-bold rounded-lg border-4 border-red-500 shadow-lg p-4 m-4 flex flex-row gap-16'>
            <div class='flex flex-col justify-center'>
                <p class='text-center'>$error</p>
            </div>
            <a href='?'>
                <button class='bg-slate-900 hover:bg-slate-700 text-red-500 font-bold py-2 rounded focus:outline-none focus:shadow-outline px-6' type='button'>
                    X
                </button>
            </a>
        </div>";
    }