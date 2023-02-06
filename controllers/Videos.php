<?php

    require_once('verify_url.php');

    /* Videos Cuarentena */
    class Video extends Connect{

        public $tb = 'videos_plataforma';
        public $codigo = '';
        public $nombre = '';
        public $grupoSeminario = '';
        public $codigoSeminario = '';
        public $codigoLeccion = '';
        public $enlace = '';
        public $limit = 0;

        /* OBTENER VIDEOS */
            public function getAll() {
                try{
                    $stmt = $this->connection()->query("SELECT * FROM $this->tb");
                    $stmt->execute();

                    return($stmt->fetchAll(PDO::FETCH_ASSOC));
                    
                }catch (\Throwable $err){

                    return ($err->getMessage());

                }finally{

                    $stmt = null;
                }
                
            }

        /* OBTENER VIDEOS EN ORDEN DESCENDENTE */
            public function getAllDesc() {
                try{
                    $stmt = $this->connection()->query("SELECT * FROM $this->tb ORDER BY id DESC");
                    $stmt->execute();
                    
                    return($stmt->fetchAll(PDO::FETCH_ASSOC));
                    
                }catch (\Throwable $err){

                    return ($err->getMessage());

                }finally{

                    $stmt = null;
                }
                
            }

        /* OBTENER ULTIMO(S) n VIDEO(S) */
            public function getLast() {
                try{
                    $stmt = $this->connection()->query("SELECT * FROM $this->tb ORDER BY id DESC LIMIT $this->limit");
                    $stmt->execute();
                    
                    return($stmt->fetchAll(PDO::FETCH_ASSOC));
                    
                }catch (\Throwable $err){

                    return ($err->getMessage());

                }finally{

                    $stmt = null;
                }
                
            }

        /* OBTENER VIDEO POR ID */
            public function getById($id_video) {

                try{
                    
                    $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE id = :id");
                    $stmt->bindParam(':id', $id_video, PDO::PARAM_INT);
                    $stmt->execute();

                    return($stmt->fetch(PDO::FETCH_ASSOC));

                }catch (\Throwable $err){

                    return ($err->getMessage());

                }finally {

                    $stmt = null;
                }
            }

        /* OBTENER VIDEO POR CODIGO */
            public function getByCode($codigo) {

                try{
                    
                    $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE codigo = :codigo");
                    $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
                    $stmt->execute();

                    return($stmt->fetch(PDO::FETCH_ASSOC));

                }catch (\Throwable $err){

                    return ($err->getMessage());

                }finally {

                    $stmt = null;
                }
            }

        /* OBTENER CODIGO DEL ULTIMO VIDEO */
            public function getLastByCode() {

                try{
                    
                    $stmt = $this->connection()->prepare("SELECT MAX(id) FROM $this->tb AS id");
                    $stmt->execute();

                    $id_sem = $stmt->fetch(PDO::FETCH_ASSOC);
                    $id = $id_sem['MAX(id)'];

                    $stmt = $this->connection()->prepare("SELECT orden FROM $this->tb WHERE id = $id");
                    $stmt->execute();

                    return $stmt->fetch(PDO::FETCH_ASSOC);

                }catch (\Throwable $err){

                    return($err->getMessage());

                }finally {

                    $stmt = null;
                }
            }

        /* OBTENER VIDEOS POR SEMINARIO */
            public function getAllBySeminario() {
                try{
                    
                    $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE seminario = :codigo_seminario");
                    $stmt->bindParam(':codigo_seminario', $this->codigoSeminario, PDO::PARAM_INT);
                    $stmt->execute();

                    return($stmt->fetchAll(PDO::FETCH_ASSOC));

                }catch (\Throwable $err){

                    return ($err->getMessage());

                }finally {

                    $stmt = null;
                }
            }


        /* OBTENER VIDEOS POR GRUPOS */
            public function getAllBySubscription() {

                try{
                    
                    $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE grupo = :grupo AND seminario = :seminario");
                    $stmt->bindParam(':grupo', $this->grupoSeminario, PDO::PARAM_INT);
                    $stmt->bindParam(':seminario', $this->codigoSeminario, PDO::PARAM_INT);
                    $stmt->execute();

                    return($stmt->fetchAll(PDO::FETCH_ASSOC));

                }catch (\Throwable $err){

                    return ($err->getMessage());

                }finally {

                    $stmt = null;
                }
            }

        /* AGREGAR VIDEO A UN SEMINARIO */
            public function add() {

                try{
                    $stmt = $this->connection()->prepare("INSERT INTO $this->tb (codigo, nombre, src, codigo_leccion) VALUES (:codigo, :nombre, :src, :codigo_leccion)");
                    
                    $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_INT);
                    $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
                    $stmt->bindParam(':src', $this->enlace, PDO::PARAM_STR);
                    $stmt->bindParam(':codigo_leccion', $this->codigo_leccion, PDO::PARAM_STR);
                    
                    return $stmt->execute();
                
                }catch (\Throwable $err){
                
                    return($err->getMessage());
                
                }finally {
                
                    //$stmt->close();
                }

            }


        /* AGREGAR VIDEO A UN SEMINARIO */
            public function addVideoSeminario() {

                try{
                    $stmt = $this->connection()->prepare("INSERT INTO $this->tb (orden, titulo, grupo, seminario, src) VALUES (:codigo, :titulo, :grupo, :seminario, :src)");

                    $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_INT);
                    $stmt->bindParam(':titulo', $this->nombre, PDO::PARAM_STR);
                    $stmt->bindParam(':grupo', $this->grupoSeminario, PDO::PARAM_INT);
                    $stmt->bindParam(':seminario', $this->codigoSeminario, PDO::PARAM_INT);
                    $stmt->bindParam(':src', $this->enlace, PDO::PARAM_STR);
                    
                    return $stmt->execute();
                
                }catch (\Throwable $err){
                
                    return($err->getMessage());
                
                }finally {
                
                    $stmt = null;
                }

            }

        /* ELIMINAR UN VIDEO DE UN SEMINARIO */
            public function delete() {

                try{
                    
                    $stmt = $this->connection()->prepare("DELETE FROM $this->tb WHERE orden = :codigo");
                    $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_INT);
                    
                    return $stmt->execute();

                }catch (\Throwable $err){

                    return($err->getMessage());

                }finally {

                    $stmt = null;
                }
            }
    }