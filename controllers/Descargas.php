<?php

    include_once('verify_url.php');

    class Descarga extends Connect{

        /* Descargas */
        public function getDescargas() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM descargas");
                
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

        public function getDescargasMaterial($nombre_descarga, $categoria) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM descargas WHERE nombre_descarga LIKE :nombre_descarga AND categoria = :categoria");
                $stmt->bindParam(':nombre_descarga', $nombre_descarga, PDO::PARAM_STR);
                $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
                $stmt->execute();

                while($row = $stmt->fetchAll()){
                    return $row;
                }

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                //$stmt->close();
            }
        }

        public function getDescarga($email, $nombre_descarga, $categoria) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM descargas WHERE email = :email AND nombre_descarga = :nombre_descarga AND categoria = :categoria");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':nombre_descarga', $nombre_descarga, PDO::PARAM_STR);
                $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetchAll();

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                //$stmt->close();
            }
        }

        public function addDescarga($nombre,$apellido,$email,$pais,$numero_telefono,$nombre_descarga,$categoria){

            try{
                $stmt = $this->connection()->prepare("INSERT INTO `descargas` (`nombre`, `apellido`, `email`, `pais`, `numero_telefono`, `nombre_descarga`, `categoria`) VALUES (:nombre,:apellido,:email,:pais,:numero_telefono,:nombre_descarga,:categoria)");
                $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':pais', $pais, PDO::PARAM_STR);
                $stmt->bindParam(':numero_telefono', $numero_telefono, PDO::PARAM_STR);
                $stmt->bindParam(':nombre_descarga', $nombre_descarga, PDO::PARAM_STR);
                $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
                $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                //$stmt->close();
            }
            
        }

        /* Categorias */
        public function getCategorias() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM categoria_descargas");
                
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

        public function getCategoriasCode($cat_code) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM categoria_descargas WHERE codigo = :codigo");
                $stmt->bindParam(':codigo', $cat_code, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetch();

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                //$stmt->close();
            }
        }

        /* Contenido Material */
        public function getContenidoDescarga() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM contenido_descarga");
                
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

        public function getItemDescarga($desc_code) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM contenido_descarga WHERE codigo = :codigo");
                $stmt->bindParam(':codigo',$desc_code,PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetch();

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                //$stmt->close();
            }
        }

    }