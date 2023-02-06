<?php

    include_once('verify_url.php');

    class Charla extends Connect{

        public $cant = 0;

        public function getCharlasAbiertas() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM charlas_abiertas");
                
                while($row = $stmt->fetchAll()){
                    return $row;
                }

                //return($stmt->fetch_all(MYSQLI_ASSOC));
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally{

                //$stmt->close();
            }
            
        }

        public function getLastCharlas() {

            settype($cant, "integer");

            try{
                $stmt = $this->connection()->query("SELECT * FROM charlas_abiertas ORDER BY id DESC LIMIT $this->cant");
                
                while($row = $stmt->fetchAll()) {
                    return $row;
                }
                //return($stmt->fetch_all(MYSQLI_ASSOC));
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally{

                //$stmt->close();
            }
            
        }

        
    }