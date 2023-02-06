<?php 

    include_once('verify_url.php');

    class Role extends Connect {

        public $tb = 'roles';
        public $codigo = '';
        public $rol = '';
        public $tipo = '';
        public $descripcion = '';
        public $sections = [];

        public function add() {
            /* Agregar Rol */
            try{
                $stmt = $this->connection()->prepare("SELECT codigo FROM $this->tb ORDER BY codigo DESC LIMIT 1");
                $stmt->execute();

                    $lastCode = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->codigo = $lastCode['codigo']+1;

                $stmt = $this->connection()->prepare("INSERT INTO $this->tb (codigo, rol, tipo, descripcion) VALUES (:codigo, :rol, :tipo, :descripcion)");
                $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_INT);
                $stmt->bindParam(':rol', $this->rol, PDO::PARAM_STR);
                $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
                $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);

                return [
                    'added' => $stmt->execute(),
                    'rolCode' => $this->codigo
                ];
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
        }

            /* Get All */
        public function getAll() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM $this->tb");

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally{

                $stmt = null;
            }
        }

            /* Update Rol */
        public function update() {
            try {
                $stmt = $this->connection()->prepare("UPDATE roles SET rol = :rol, tipo = :tipo, descripcion = :descripcion WHERE codigo = :codigo");
                $stmt->bindParam(':rol', $this->rol, PDO::PARAM_STR);
                $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
                $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
                $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_INT);

                return $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                $stmt = null;
            }
        }

            /* Add a Permission */
        public function setPermiso($codigo_rol, $codigo_seccion) {

            try{
                $stmt = $this->connection()->prepare("INSERT INTO permisos (codigo_rol, codigo_seccion) VALUES (:codigo_rol, :codigo_seccion)");
                $stmt->bindParam(':codigo_rol', $codigo_rol, PDO::PARAM_INT);
                $stmt->bindParam(':codigo_seccion', $codigo_seccion, PDO::PARAM_INT);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
        }

            /* Remove a Permission */
        public function deletePermiso($codigo_rol, $codigo_seccion) {

            try {
                $stmt = $this->connection()->prepare("DELETE FROM permisos WHERE codigo_rol = :codigo_rol AND codigo_seccion = :codigo_seccion");
                $stmt->bindParam(':codigo_rol', $codigo_rol, PDO::PARAM_INT);
                $stmt->bindParam(':codigo_seccion', $codigo_seccion, PDO::PARAM_INT);

                $stmt->execute();

                return $stmt->rowCount();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                $stmt = null;
            }
        }

            /* Get All By Code Desc */
        public function getAllByCodeDesc() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM $this->tb ORDER BY codigo ASC");

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally{

                $stmt = null;
            }
        }

            /* Get By Code */
        public function getByCode($code) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE codigo = :code");
                $stmt->bindParam(':code', $code, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally{

                $stmt = null;
            }
        }

            /* Get Permmisions By Role */
        public function getPermmisionsByRole($role_code) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM permisos WHERE codigo_rol = :role_code");
                $stmt->bindParam(':role_code', $role_code, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally{

                $stmt = null;
            }
        }

            /* Check Permissions */
        public function verifyAccess($role_code, $section_code) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM permisos WHERE codigo_rol = :role_code AND codigo_seccion = :section_code");
                $stmt->bindParam(':role_code', $role_code, PDO::PARAM_INT);
                $stmt->bindParam(':section_code', $section_code, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally{

                $stmt = null;
            }
        }

            /* Get All Sections */
        public function getSections() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM secciones");

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally{

                $stmt = null;
            }
        }

            /* Get Section-Page */
        public function getPageData($page_name) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM secciones WHERE nombre_ref = :nombre_ref");
                $stmt->bindParam(':nombre_ref', $page_name, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally{

                $stmt = null;
            }
        }

    }