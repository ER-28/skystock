<?php

    namespace lib {
        
        use Exception;
        
        class SaveRequest
        {
            /**
             * @throws Exception
             */
            static function save(string $query): void
            {
                // call api to save in files
                
                try {
                    $db = new \mysqli('db', 'isitech', 'isitech', 'isitech');
                } catch (Exception $e) {
                    throw new Exception('Error creating a database connection ');
                }
                
                $safeQuery = $db->real_escape_string($query);
                
                $sql = "CREATE TABLE IF NOT EXISTS requests (id INT AUTO_INCREMENT PRIMARY KEY, query TEXT)";
                $db->query($sql);
                
                $sql = "INSERT INTO requests (query) VALUES ('$safeQuery')";
                $db->query($sql);
                
            }
            
            static function get(): array {
                $db = new \mysqli('db', 'isitech', 'isitech', 'isitech');
                $sql = "SELECT query FROM requests";
                $result = $db->query($sql);
                $requests = [];
                while ($row = $result->fetch_assoc()) {
                    $requests[] = $row;
                }
                return $requests;
            }
        }
    }