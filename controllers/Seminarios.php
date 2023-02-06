<?php

    include_once('verify_url.php');

    class Seminario extends Connect{

        public $tb = 'seminarios';

        public $nombreSeminario = '';
        public $codigoSeminario = 0;
        public $codigoExterno = 0;
        public $modalidadSeminario = '';
        public $descripcionSeminario = '';
        public $cuposSeminarios = 9999;
        public $grupoActual = 0;
        public $duracionSeminario = '';
        public $materialSeminario = 0;
        public $contenidoSeminarioSup = '';
        public $contenidoSeminarioInf = '';
        public $imagenSeminario = '';
        public $videoIntroductorio = '';
        public $profesionalSeminario = 4;
        public $visible = 0;

        public function getSeminarios() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM $this->tb");

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }catch (\Throwable $err){

                return($err->getMessage());

            }finally{

                $stmt = null;
            }
            
        }

        public function getByOrdenAsc() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM seminarios ORDER BY orden ASC");
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }catch (\Throwable $err){

                return($err->getMessage());

            }finally{

                $stmt = null;
            }
            
        }

        public function getSeminariosPagination($inicio,$seminarios) {
            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb LIMIT :inicio,:seminarios");
                $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
                $stmt->bindParam(':seminarios', $seminarios, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                return($err->getMessage());

            }finally {

                $stmt = null;
            }
            
        }


        public function getSeminario($code_seminario) {
            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE codigo = :codigo");
                $stmt->bindParam(':codigo', $code_seminario, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                return($err->getMessage());

            }finally {

                $stmt = null;
            }
        }

        /* ************************************************ */
        /* Seminarios Live */
        /* Obtener Seminarios Live */
        public function getSeminariosLive() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM seminarios_live");

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }catch (\Throwable $err){

                return($err->getMessage());

            }finally{

                $stmt = null;
            }
            
        }
        
        /* Obtener un seminario */
        public function getSeminarioLive($codigo) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM seminarios_live WHERE codigo = :codigo");
                $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                return($err->getMessage());

            }finally {

                $stmt = null;
            }
        }

        /* Agregar un tema a un seminario */
        public function addTemaSeminarioLive($tema, $codigo_seminario) {

            try{
                $stmt = $this->connection()->prepare("INSERT INTO temas_seminarios_live (tema, seminario_codigo) VALUES (:tema, :seminario_codigo)");

                $stmt->bindParam(':tema', $tema, PDO::PARAM_STR);
                $stmt->bindParam(':seminario_codigo', $codigo_seminario, PDO::PARAM_INT);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                return($err->getMessage());
            
            }finally {
            
                $stmt = null;
            }

        }

        /* Obtener Temas de un Seminario */
        public function getTemasSeminario($codigo_seminario) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM temas_seminarios_live WHERE seminario_codigo = :codigo_seminario");
                $stmt->bindParam(':codigo_seminario', $codigo_seminario, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                return($err->getMessage());

            }finally {

                $stmt = null;
            }
        }

         /* Obtener Seminario por Codigo Externo */
        public function getByCodigoExterno($codigo_externo) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM seminarios_live WHERE codigo_externo = :codigo_externo");
                $stmt->bindParam(':codigo_externo', $codigo_externo, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                return($err->getMessage());

            }finally {

                $stmt = null;
            }
        }

        /* Eliminar un tema del Seminario */
        public function removeTemaSeminarioLive($id_tema) {

            try{
                
                $stmt = $this->connection()->prepare("DELETE FROM temas_seminarios_live WHERE id = :id");
                $stmt->bindParam(':id', $id_tema, PDO::PARAM_INT);
                
                return $stmt->execute();

            }catch (\Throwable $err){

                return($err->getMessage());

            }finally {

                $stmt = null;
            }
        }

        /* Obtener Código del Último Seminario */
        public function getCodeLastSeminarioLive() {

            try{
                
                $stmt = $this->connection()->prepare("SELECT MAX(id) FROM seminarios_live AS id");
                $stmt->execute();

                $id_sem = $stmt->fetch(PDO::FETCH_ASSOC);
                $id = $id_sem['MAX(id)'];

                $stmt = $this->connection()->prepare("SELECT codigo FROM seminarios_live WHERE id = $id");
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                return($err->getMessage());

            }finally {

                $stmt = null;
            }
        }

        /* Obtener Seminarios Visibles */
        public function getVisibles() {

            try{                
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE visible = 1");
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                return($err->getMessage());

            }finally {

                $stmt = null;
            }

        }

        /* Nuevo Seminario Live */
        public function addSeminarioLive() {

            try{
                $stmt = $this->connection()->prepare("INSERT INTO seminarios_live (
                    codigo,
                    codigo_externo,
                    nombre,
                    descripcion,
                    cupos,
                    grupo_actual,
                    duracion,
                    material_adicional,
                    modalidad,
                    texto_descriptivo_1,
                    texto_descriptivo_2,
                    imagen,
                    video_intro,
                    profesional,
                    visible) VALUES (
                        :codigoSeminario,
                        :codigoExterno,
                        :nombreSeminario,
                        :descripcionSeminario,
                        :cuposSeminario,
                        :grupoActual,
                        :duracionSeminario,
                        :materialSeminario,
                        :modalidadSeminario,
                        :contenidoSeminarioSup,
                        :contenidoSeminarioInf,
                        :imagenSeminario,
                        :videoIntroductorio,
                        :profesionalSeminario,
                        :visible
                    )");

                $stmt->bindParam(':codigoSeminario', $this->codigoSeminario, PDO::PARAM_INT);
                $stmt->bindParam(':codigoExterno', $this->codigoExterno, PDO::PARAM_INT);
                $stmt->bindParam(':nombreSeminario', $this->nombreSeminario, PDO::PARAM_STR);
                $stmt->bindParam(':descripcionSeminario', $this->descripcionSeminario, PDO::PARAM_STR);
                $stmt->bindParam(':cuposSeminario', $this->cuposSeminarios, PDO::PARAM_STR);
                $stmt->bindParam(':grupoActual', $this->grupoActual, PDO::PARAM_INT);
                $stmt->bindParam(':duracionSeminario', $this->duracionSeminario, PDO::PARAM_STR);
                $stmt->bindParam(':materialSeminario', $this->materialSeminario, PDO::PARAM_STR);
                $stmt->bindParam(':modalidadSeminario', $this->modalidadSeminario, PDO::PARAM_STR);
                $stmt->bindParam(':contenidoSeminarioSup', $this->contenidoSeminarioSup, PDO::PARAM_STR);
                $stmt->bindParam(':contenidoSeminarioInf', $this->contenidoSeminarioSup, PDO::PARAM_STR);
                $stmt->bindParam(':imagenSeminario', $this->imagenSeminario, PDO::PARAM_STR);
                $stmt->bindParam(':videoIntroductorio', $this->videoIntroductorio, PDO::PARAM_STR);
                $stmt->bindParam(':profesionalSeminario', $this->profesionalSeminario, PDO::PARAM_INT);
                $stmt->bindParam(':visible', $this->visible, PDO::PARAM_INT);

                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                return($err->getMessage());
            
            }finally {
            
                $stmt = null;
            }

        }

        /* Editar Seminario Live */
        public function updateSeminarioLive($code) {

            try{
                $stmt = $this->connection()->prepare("UPDATE seminarios_live SET 
                    codigo = :codigoSeminario,
                    codigo_externo = :codigoExterno,
                    nombre = :nombreSeminario,
                    descripcion = :descripcionSeminario,
                    cupos = :cuposSeminario,
                    grupo_actual = :grupoActual,
                    duracion = :duracionSeminario,
                    material_adicional = :materialSeminario,
                    modalidad = :modalidadSeminario,
                    texto_descriptivo_1 = :contenidoSeminarioSup,
                    texto_descriptivo_2 = :contenidoSeminarioInf,
                    imagen = :imagenSeminario,
                    video_intro = :videoIntroductorio,
                    profesional = :profesionalSeminario,
                    visible = :visible WHERE codigo = :code");

                $stmt->bindParam(':codigoSeminario', $this->codigoSeminario, PDO::PARAM_INT);
                $stmt->bindParam(':codigoExterno', $this->codigoExterno, PDO::PARAM_INT);
                $stmt->bindParam(':nombreSeminario', $this->nombreSeminario, PDO::PARAM_STR);
                $stmt->bindParam(':descripcionSeminario', $this->descripcionSeminario, PDO::PARAM_STR);
                $stmt->bindParam(':cuposSeminario', $this->cuposSeminarios, PDO::PARAM_STR);
                $stmt->bindParam(':grupoActual', $this->grupoActual, PDO::PARAM_INT);
                $stmt->bindParam(':duracionSeminario', $this->duracionSeminario, PDO::PARAM_STR);
                $stmt->bindParam(':materialSeminario', $this->materialSeminario, PDO::PARAM_STR);
                $stmt->bindParam(':modalidadSeminario', $this->modalidadSeminario, PDO::PARAM_STR);
                $stmt->bindParam(':contenidoSeminarioSup', $this->contenidoSeminarioSup, PDO::PARAM_STR);
                $stmt->bindParam(':contenidoSeminarioInf', $this->contenidoSeminarioInf, PDO::PARAM_STR);
                $stmt->bindParam(':imagenSeminario', $this->imagenSeminario, PDO::PARAM_STR);
                $stmt->bindParam(':videoIntroductorio', $this->videoIntroductorio, PDO::PARAM_STR);
                $stmt->bindParam(':profesionalSeminario', $this->profesionalSeminario, PDO::PARAM_INT);
                $stmt->bindParam(':visible', $this->visible, PDO::PARAM_INT);
                $stmt->bindParam(':code', $code, PDO::PARAM_INT);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                return($err->getMessage());
            
            }finally {
            
                $stmt = null;
            }

        }

        /* Agregar Grupo a un Seminario Live */
        public function addGrupo($nombre, $codigoSeminario, $meetLink='') {

            try{
                $stmt = $this->connection()->prepare("INSERT INTO grupos_seminarios_live (nombre, codigo_seminario, meet_link) VALUES (:nombre, :codigo_seminario, :meet_link)");

                $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $stmt->bindParam(':codigo_seminario', $codigoSeminario, PDO::PARAM_INT);
                $stmt->bindParam(':meet_link', $meetLink, PDO::PARAM_STR);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                return($err->getMessage());
            
            }finally {
            
                $stmt = null;
            }

        }

        /* Actualizar Grupo de un Seminario */
        public function updateGrupo($idGrupo, $meetLink='') {
            try{
                $stmt = $this->connection()->prepare("UPDATE grupos_seminarios_live SET meet_link = :meetLink WHERE id = :id");

                $stmt->bindParam(':id', $idGrupo, PDO::PARAM_INT);
                $stmt->bindParam(':meetLink', $meetLink, PDO::PARAM_STR);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                return($err->getMessage());
            
            }finally {
            
                $stmt = null;
            }
        }

        /* Eliminar Grupo de un Seminario Live */
        public function deleteGrupo($idGrupo) {
            try{
                $stmt = $this->connection()->prepare("DELETE FROM grupos_seminarios_live WHERE id = :id");
                $stmt->bindParam(':id', $idGrupo, PDO::PARAM_INT);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                return($err->getMessage());
            
            }finally {
            
                $stmt = null;
            }
        }


        /* Obtener Grupos de un Seminario Live */
        public function getGruposBySeminario($codigoSeminario) {

            try{                
                $stmt = $this->connection()->prepare("SELECT * FROM grupos_seminarios_live WHERE codigo_seminario = :codigo_seminario");
                $stmt->bindParam(':codigo_seminario', $codigoSeminario, PDO::PARAM_INT);

                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                return($err->getMessage());

            }finally {

                $stmt = null;
            }
        }

        /* Obtener Grupo por Id */
        public function getGrupoById($id) {

            try{                
                $stmt = $this->connection()->prepare("SELECT * FROM grupos_seminarios_live WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                return($err->getMessage());

            }finally {

                $stmt = null;
            }
        }        

        /* Fin Seminarios Live */

    }