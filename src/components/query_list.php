<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/lib/SaveRequest.php';
    
    use lib\SaveRequest;
    
    function render_query_list(): void
    {
        $arr = SaveRequest::get();
        
        echo '
            <div class="flex flex-col gap-4">
                <div class="flex flex-row justify-between items-center bg-slate-900 p-4 rounded-lg w-full">
                    <h1 class="text-white text-2xl font-bold">List of queries</h1>
                    <a href="/forms/delete_requests.php">
                        <button class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 rounded focus:outline-none focus:shadow-outline px-4" type="button">
                            Delete all
                        </button>
                    </a>
                </div>
                <div class="h-96 overflow-y-scroll w-full flex flex-col gap-4 bg-slate-900 mt-4 p-4">
        ';
        
        foreach ($arr as $key => $value) {
            
            echo '
                    <p class="text-white font-bold text-nowrap">' . $value['query'] . '</p>
            ';
        }
        
        echo '
                </div>
            </div>
        ';
        
    }