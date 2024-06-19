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
        
        //echo tailwind css toast
        echo "<div class='absolute right-0 bg-red-500 text-white font-bold rounded-lg border shadow-lg p-4 m-4 flex flex-row gap-16'>
            <p class='text-center'>$error</p>
            <a href='?'>
                <button class='bg-red-700 hover:bg-red-600 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-16' type='button'>
                    Ok
                </button>
            </a>
        </div>";
    }