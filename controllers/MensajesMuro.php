<?php

    include_once('verify_url.php');

    class Mensaje_Muro extends Connect{

        public $mensaje = '';

        /* Descargas */
        public function getMensajes() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM mensaje_muro");
                
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

        public function getLastMensaje() {
            try{
                $stmt = $this->connection()->query('SELECT * FROM mensaje_muro ORDER BY idSuscriptor DESC LIMIT 1');
                $stmt->execute();
                
                return $stmt->fetch();

                //return($stmt->fetch_all(MYSQLI_ASSOC));
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally{

                //$stmt->close();
            }
            
        }

        public function addMessage(){

            try{
                $stmt = $this->connection()->prepare("INSERT INTO mensaje_muro (mensaje) VALUES (:mensaje)");
                $stmt->bindParam(':mensaje', $this->mensaje, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->rowCount();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                //$stmt->close();
            }    
        }

    }