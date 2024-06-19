<?php

    namespace lib {
        
        use Exception;
        
        class SaveRequest
        {
            static function save(string $query): void
            {
                // call api to save in files
                
                try {
                    $db = new \mysqli('db', 'isitech', 'isitech', 'isitech');
                } catch (Exception $e) {
                    return;
                }
                
                $safeQuery = $db->real_escape_string($query);
                
                $sql = "CREATE TABLE IF NOT EXISTS requests (id INT AUTO_INCREMENT PRIMARY KEY, query TEXT)";
                $db->query($sql);
                
                $sql = "INSERT INTO requests (query) VALUES ('$safeQuery')";
                $db->query($sql);
            }
            
            static function get(): array {
                $db = new \mysqli('db', 'isitech', 'isitech', 'isitech');
                $sql = "SELECT query FROM requests ORDER BY id DESC";
                $result = $db->query($sql);
                $requests = [];
                while ($row = $result->fetch_assoc()) {
                    $requests[] = $row;
                }
                return $requests;
            }
            
            public static function drop()
            {
                $db = new \mysqli('db', 'isitech', 'isitech', 'isitech');
                $sql = "DROP TABLE requests";
                $db->query($sql);
            }
        }
    }