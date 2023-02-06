<?php

    include_once('verify_url.php');

    /* ARTICULOS COMUNES */
    class Articulo extends Connect{

        public $tb = 'articulos';
        public $codigo = '';
        public $titulo = '';
        public $autor = '';
        public $anio = '';
        public $institucion = '';
        public $sub_titulo = '';
        public $descripcion = '';
        public $contenido = '';
        public $imagen = '';
        public $imagen_preview = '';
        public $profesional = '4';

        public function add() {
            try{
                switch($this->tb) {
                    case 'articulos' :
                        $stmt = $this->connection()->prepare("INSERT INTO $this->tb (
                            codigo,
                            titulo,
                            sub_titulo,
                            descripcion,
                            contenido,
                            imagen,
                            profesional) VALUES (
                                :codigo,
                                :titulo,
                                :sub_titulo,
                                :descripcion,
                                :contenido,
                                :imagen,
                                :profesional)");
        
                        $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_INT);
                        $stmt->bindParam(':titulo', $this->titulo, PDO::PARAM_STR);
                        $stmt->bindParam(':sub_titulo', $this->sub_titulo, PDO::PARAM_STR);
                        $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
                        $stmt->bindParam(':contenido', $this->contenido, PDO::PARAM_STR);
                        $stmt->bindParam(':imagen', $this->imagen, PDO::PARAM_STR);
                        $stmt->bindParam(':profesional', $this->profesional, PDO::PARAM_INT);
                    break;
                    case 'articulos_leer' :
                        $stmt = $this->connection()->prepare("INSERT INTO $this->tb (
                            codigo,
                            titulo,
                            autor,
                            año,
                            institucion,
                            descripcion,
                            contenido,
                            imagen,
                            imagen_preview) VALUES (
                                :codigo,
                                :titulo,
                                :autor,
                                :anio,
                                :institucion,
                                :descripcion,
                                :contenido,
                                :imagen,
                                :imagen_preview)");
        
                        $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_INT);
                        $stmt->bindParam(':titulo', $this->titulo, PDO::PARAM_STR);
                        $stmt->bindParam(':autor', $this->autor, PDO::PARAM_STR);
                        $stmt->bindParam(':anio', $this->anio, PDO::PARAM_STR);
                        $stmt->bindParam(':institucion', $this->institucion, PDO::PARAM_STR);
                        $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
                        $stmt->bindParam(':contenido', $this->contenido, PDO::PARAM_STR);
                        $stmt->bindParam(':imagen', $this->imagen, PDO::PARAM_STR);
                        $stmt->bindParam(':imagen_preview', $this->imagen_preview, PDO::PARAM_STR);
                        
                    break;
                }
                
                return $stmt->execute();

            }catch (\Throwable $err) {
                var_dump($err);
                exit;
            }finally {

                $stmt = null;

            }
        }

        public function update() {

            try{
                switch($this->tb) {
                    case 'articulos' :
                        $stmt = $this->connection()->prepare("UPDATE $this->tb SET 
                            titulo = :titulo,
                            sub_titulo = :sub_titulo,
                            descripcion = :descripcion,
                            contenido = :contenido,
                            imagen = :imagen,
                            profesional = :profesional
                                WHERE codigo = :codigo");

                        $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_INT);
                        $stmt->bindParam(':titulo', $this->titulo, PDO::PARAM_STR);
                        $stmt->bindParam(':sub_titulo', $this->sub_titulo, PDO::PARAM_STR);
                        $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
                        $stmt->bindParam(':contenido', $this->contenido, PDO::PARAM_STR);
                        $stmt->bindParam(':imagen', $this->imagen, PDO::PARAM_STR);
                        $stmt->bindParam(':profesional', $this->profesional, PDO::PARAM_INT);
                    break;

                    case 'articulos_leer' :
                        $stmt = $this->connection()->prepare("UPDATE $this->tb SET 
                            codigo = :codigo,
                            titulo = :titulo,
                            autor = :autor,
                            año = :anio,
                            institucion = :institucion,
                            descripcion = :descripcion,
                            imagen = :imagen,
                            imagen_preview = :imagen_preview
                                WHERE codigo = :codigo");
        
                        $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_INT);
                        $stmt->bindParam(':titulo', $this->titulo, PDO::PARAM_STR);
                        $stmt->bindParam(':autor', $this->autor, PDO::PARAM_STR);
                        $stmt->bindParam(':anio', $this->anio, PDO::PARAM_STR);
                        $stmt->bindParam(':institucion', $this->institucion, PDO::PARAM_STR);
                        $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
                        $stmt->bindParam(':imagen', $this->imagen, PDO::PARAM_STR);
                        $stmt->bindParam(':imagen_preview', $this->imagen_preview, PDO::PARAM_STR);
                    break;
                }

                return $stmt->execute();

            }catch (\Throwable $err) {
                var_dump($err);
                exit;
            }finally {

                $stmt = null;

            }
        }

        public function getAll() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM $this->tb");

                return($stmt->fetchAll(PDO::FETCH_ASSOC));
                
            }catch (\Throwable $err){
                var_dump($err);
                exit;
            }finally{

                $stmt = null;
            }
            
        }


        public function getAllDesc() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM $this->tb ORDER BY codigo DESC");

                return($stmt->fetchAll(PDO::FETCH_ASSOC));
                
            }catch (\Throwable $err){
                var_dump($err);
                exit;
            }finally{

                $stmt = null;
            }
            
        }

        public function getPagination($inicio,$articulos) {
            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb LIMIT :inicio,:articulos");
                $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
                $stmt->bindParam(':articulos', $articulos, PDO::PARAM_INT);
                $stmt->execute();

                return($stmt->fetchAll(PDO::FETCH_ASSOC));

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
            
        }

        public function getPaginationDesc($inicio,$articulos) {
            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb ORDER BY codigo DESC LIMIT :inicio,:articulos");
                $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
                $stmt->bindParam(':articulos', $articulos, PDO::PARAM_INT);
                $stmt->execute();

                return($stmt->fetchAll(PDO::FETCH_ASSOC));

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
            
        }


        public function getByCode($code_article) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE codigo = :codigo");
                $stmt->bindParam(':codigo', $code_article, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function getRandom($limit = 5) {
            
            try{                
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb ORDER BY RAND() LIMIT :limit ");
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }

        }

        public function getBySearch($search = '',$prof_id = 0) {

            try{

                if($search !== '' && $prof_id !== 0) {
                    $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE titulo LIKE :search AND profesional = :prof_id");
                    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
                    $stmt->bindParam(':prof_id', $prof_id, PDO::PARAM_INT);
                }else if($search !== '' && $prof_id === 0) {
                    $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE titulo LIKE :search");
                    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
                }else if($search === '' && $prof_id !== 0){
                    $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE profesional = :prof_id");
                    $stmt->bindParam(':prof_id', $prof_id, PDO::PARAM_INT);
                }

                $stmt->execute();

                while($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
                    return $row;
                }

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function getByProf($prof_id,$article_code) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE profesional = :profesional AND codigo <> :codigo");
                $stmt->bindParam(':profesional', $prof_id, PDO::PARAM_INT);
                $stmt->bindParam(':codigo', $article_code, PDO::PARAM_INT);
                $stmt->execute();

                $art = array();

                while($row = $stmt->fetch()){
                    array_push($art,$row);
                }
                return($art);

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function getLast() {
            try{
                
                $stmt = $this->connection()->query("SELECT * FROM $this->tb ORDER BY codigo DESC LIMIT 1");

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function getLastThree() {
            try{
                
                $stmt = $this->connection()->query("SELECT * FROM $this->tb ORDER BY codigo DESC LIMIT 3");

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

    }