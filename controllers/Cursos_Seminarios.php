<?php

    include_once('verify_url.php');

    /* ARTICULOS COMUNES */
    class CursoSeminario extends Connect{

        public $codigo = 0;
        public $nombre = '';
        public $tipo = 0;
        public $descripcion = '';
        public $modalidad = '';
        public $premium = 0;
        public $imagen = '';
        public $clases = 0;
        public $profesional = 4;
        public $visible = 1;


        /* Agregar Nuevo Curso-Seminario */
        public function add() {

            try{
                $stmt = $this->connection()->prepare("INSERT INTO cursos_seminarios (
                    codigo,
                    nombre, 
                    tipo, 
                    descripcion, 
                    modalidad, 
                    premium, 
                    imagen, 
                    clases,
                    profesional,
                    visible
                ) 
                VALUES (
                    :codigo,
                    :nombre, 
                    :tipo, 
                    :descripcion, 
                    :modalidad, 
                    :premium, 
                    :imagen, 
                    :clases,
                    :profesional,
                    :visible
                )");

                $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_INT);
                $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
                $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_INT);
                $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
                $stmt->bindParam(':modalidad', $this->modalidad, PDO::PARAM_STR);
                $stmt->bindParam(':premium', $this->premium, PDO::PARAM_INT);
                $stmt->bindParam(':imagen', $this->imagen, PDO::PARAM_STR);
                $stmt->bindParam(':clases', $this->clases, PDO::PARAM_INT);
                $stmt->bindParam(':profesional', $this->profesional, PDO::PARAM_INT);
                $stmt->bindParam(':visible', $this->visible, PDO::PARAM_INT);

                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                return($err->getMessage());
            
            }finally {
            
                $stmt = null;
            }

        }

        public function update() {
            try {
                $stmt = $this->connection()->prepare("UPDATE cursos_seminarios SET
                    nombre = :nombre,
                    tipo = :tipo,
                    descripcion = :descripcion,
                    modalidad = :modalidad,
                    premium = :premium,
                    imagen = :imagen,
                    clases = :clases,
                    profesional = :profesional,
                    visible = :visible
                WHERE codigo = :codigo");

                $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_INT);
                $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
                $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_INT);
                $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
                $stmt->bindParam(':modalidad', $this->modalidad, PDO::PARAM_STR);
                $stmt->bindParam(':premium', $this->premium, PDO::PARAM_INT);
                $stmt->bindParam(':imagen', $this->imagen, PDO::PARAM_STR);
                $stmt->bindParam(':clases', $this->clases, PDO::PARAM_INT);
                $stmt->bindParam(':profesional', $this->profesional, PDO::PARAM_INT);
                $stmt->bindParam(':visible', $this->visible, PDO::PARAM_INT);

                return $stmt->execute();

            } catch (\Throwable $err){
            
                return($err->getMessage());
            
            }finally {
            
                $stmt = null;
            }
        }


        /* Eliminar un Curso/Seminario */
        public function delete() {
            try{
                $stmt = $this->connection()->prepare("DELETE FROM cursos_seminarios WHERE codigo = :codigo");
                $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_INT);

                return $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }



        /* Obtener Todas las registros */
        public function getAll() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM cursos_seminarios");

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Obtener el último codigo registrado */
        public function getLast() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM cursos_seminarios ORDER BY codigo DESC LIMIT 1");

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Obtener los Tipos de Contenido */
        public function getContentTypes() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM tipos_contenido");

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }        

        /* Obtener por tipo de curso-seminario */
        public function getByType($tipo) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM cursos_seminarios WHERE tipo = :tipo");
                $stmt->bindParam(':tipo',$tipo,PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Obtener por codigo */
        public function getByCode($codigo) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM cursos_seminarios WHERE codigo = :codigo");
                $stmt->bindParam(':codigo',$codigo,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }





        /* NIVELES */
        /* Agregar un nivel */
        public function addLevel($codigo, $nombreNivel, $codigoCursoSeminario) {
            try{
                $stmt = $this->connection()->prepare("INSERT INTO niveles (
                    codigo,
                    nombre,
                    codigo_curso_seminario
                )
                VALUES (
                    :codigo,
                    :nombre, 
                    :codigo_curso_seminario
                )");

                $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
                $stmt->bindParam(':nombre', $nombreNivel, PDO::PARAM_STR);
                $stmt->bindParam(':codigo_curso_seminario', $codigoCursoSeminario, PDO::PARAM_INT);

                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                return($err->getMessage());
            
            }finally {
            
                $stmt = null;
            }
        }

        /* Eliminar Nivel de un Curso-Seminario */
        public function deleteLevel($codigo_nivel) {
            try{
                $stmt = $this->connection()->prepare("DELETE FROM niveles WHERE codigo = :codigo_nivel");
                $stmt->bindParam(':codigo_nivel',$codigo_nivel,PDO::PARAM_STR);
                
                return $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Eliminar Niveles de Curso-Seminario */
        public function deleteCurSemLevel($codigo_curso_seminario) {
            try{
                $stmt = $this->connection()->prepare("DELETE FROM niveles WHERE codigo_curso_seminario = :codigo_curso_seminario");
                $stmt->bindParam(':codigo_curso_seminario',$codigo_curso_seminario,PDO::PARAM_INT);
                
                return $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }


        /* Obtener niveles de un curso-seminario */
        public function getLevels($codigo_curso_seminario) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM niveles WHERE codigo_curso_seminario = :codigo_curso_seminario");
                $stmt->bindParam(':codigo_curso_seminario',$codigo_curso_seminario,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }





        /* LECCIONES */
        /* Agregar una Lección */
        public function addLesson($codigoNivel) {
            try{
                $stmt = $this->connection()->prepare("INSERT INTO lecciones (
                    codigo,
                    nombre,
                    codigo_nivel
                ) 
                VALUES (
                    :codigo,
                    :nombre, 
                    :codigo_nivel
                )");

                $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
                $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
                $stmt->bindParam(':codigo_nivel', $codigoNivel, PDO::PARAM_STR);

                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                return($err->getMessage());
            
            }finally {
            
                $stmt = null;
            }
        }


        /* Eliminar Lección de Nivel */
        public function deleteLesson($codigo_leccion) {
            try{
                $stmt = $this->connection()->prepare("DELETE FROM niveles WHERE codigo = :codigo_leccion");
                $stmt->bindParam(':codigo_leccion',$codigo_leccion,PDO::PARAM_STR);
                
                return $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Eliminar Lecciónes de Nivel */
        public function deleteLevelLessons($codigo_nivel) {
            try{
                $stmt = $this->connection()->prepare("DELETE FROM niveles WHERE codigo_nivel = :codigo_nivel");
                $stmt->bindParam(':codigo_nivel',$codigo_nivel,PDO::PARAM_STR);
                
                return $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }
        

        /* Obtener lecciones de un nivel */
        public function getLevelLessons($codigo_nivel) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM lecciones WHERE codigo_nivel = :codigo_nivel");
                $stmt->bindParam(':codigo_nivel',$codigo_nivel,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Obtener la útima Lección */
        public function getLastLessonVideo() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM `videos_plataforma` ORDER BY codigo DESC LIMIT 1 ");

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }       
        
        




        /* VIDEOS */
        /* Agregar Video a Lección */
        public function addLessonVideo($nombreLeccion, $src, $codigoLeccion) {
            try{
                
                $codigo = $this->getLastLessonVideo()['codigo'] + 1;

                $stmt = $this->connection()->prepare("INSERT INTO videos_plataforma (
                    codigo,
                    nombre,
                    src,
                    codigo_leccion
                ) 
                VALUES (
                    :codigo,
                    :nombre, 
                    :src,
                    :codigo_leccion
                )");

                $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
                $stmt->bindParam(':nombre', $nombreLeccion, PDO::PARAM_STR);
                $stmt->bindParam(':src', $src, PDO::PARAM_STR);
                $stmt->bindParam(':codigo_leccion', $codigoLeccion, PDO::PARAM_STR);

                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                return($err->getMessage());
            
            }finally {
            
                $stmt = null;
            }
        }

        /* Eliminar Video de Lección */
        public function deleteVideo($codigo_video) {
            try{
                $stmt = $this->connection()->prepare("DELETE FROM videos_plataforma WHERE codigo = :codigo_video");
                $stmt->bindParam(':codigo_video',$codigo_video,PDO::PARAM_STR);
                
                return $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Obtener videos de una leccion */
        public function getLessonVideos($codigo_leccion) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM videos_plataforma WHERE codigo_leccion = :codigo_leccion");
                $stmt->bindParam(':codigo_leccion',$codigo_leccion,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }
        
    }