<?php

    include_once('verify_url.php');

    class UserBook extends Connect {

        public function getUserBooks() {
            try{
                $stmt = $this->connection->query("SELECT * FROM user_books");
                
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

        public function addUserBook($nombre,$apellido,$email){

            try{
                $stmt = $this->connection->prepare("INSERT INTO `user_books` (`nombre`, `apellido`, `email`) VALUES (:nombre, :apellido, :email)");
                $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                //$stmt->close();
            }
            
        }
        
    }

?>