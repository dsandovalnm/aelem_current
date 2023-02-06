<?php

    include_once('verify_url.php');

    class Pais extends Connect{

        public function getPaises() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM paises");
                
                while($row = $stmt->fetchAll()){ 
                    return($row);
                }

                //return($stmt->fetch_all(MYSQLI_ASSOC));
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally{

                //$stmt->close();
            }
            
        }

        public function getPaisIndicativo($indicativo) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM paises WHERE indicativo = :indicativo");
                $stmt->bindParam(':indicativo',$indicativo,PDO::PARAM_INT);
                $stmt->execute();

                while($row = $stmt->fetch()){ 
                    return($row);
                }

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                //$stmt->close();
            }
        }

        
    }