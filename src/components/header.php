<?php

function render_header(): void
{
    $colors = [
        'red', 'blue', 'green', 'yellow', 'indigo', 'purple', 'pink', 'gray', 'white', 'black', 'slate', 'sky'
    ];
    
    $variant= [500, 600, 700, 800, 900];
    
    $color = $colors[array_rand($colors)];
    $variant = $variant[array_rand($variant)];
    
    $username = "test"; // get the user with _session['user']
    
    echo "
<header class='flex flex-row justify-between items-center bg-slate-950 p-4 border-b border-slate-600'>
    <p class='text-4xl font-bold text-white'><span class='text-blue-400'>Sky</span><span>stock</span></p>
    <div class='flex flex-row gap-5'>
        <p>test</p>
        <p>test</p>
        <p>test</p>
    </div>
    <a>
        <div class='flex flex-column justify-center content-center w-10 h-10 p-1 text-center rounded-full ring-2 ring-gray-300 dark:ring-gray-500 bg-".$color."-".$variant."'>
            <p class='text-white text-xl'>".$username[0]."</p>
        </div>
    </a>
</header>
    ";
}