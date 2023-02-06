<?php

    include_once('verify_url.php');

    class User extends Connect {

        public $nombre = '';
        public $apellido = '';
        public $pais = '';
        public $email = '';
        public $usuario = '';
        public $imagen = 'img/profile-img/profile-img.png';
        public $provincia = '';
        public $telefono = '';
        public $profesion = '';
        public $conocio = '';
        public $recovery_token = '';
        public $password = '';
        public $rol = 103;
        public $id_activacion = '';
        public $activado = 0;
        public $tb = 'usuarios';

        public function getAll() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM $this->tb");

                return ($stmt->fetchAll(PDO::FETCH_ASSOC));
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally{

                $stmt = null;
            }
            
        }

        public function getById($id_usuario) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE id = :id");
                $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
                $stmt->execute();

                return ($stmt->fetch(PDO::FETCH_ASSOC));

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function getByEmail($email) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                return ($stmt->fetch(PDO::FETCH_ASSOC));

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function getByUser($usuario) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE usuario = :usuario");
                $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        public function add(){

            try{
                $stmt = $this->connection()->prepare("INSERT INTO $this->tb (nombre, apellido, pais, email, usuario, imagen, telefono, profesion, conocio, recovery_token, password, rol, id_activacion, activado) VALUES (:nombre, :apellido, :pais, :email, :usuario, :imagen, :telefono, :profesion, :conocio, :recovery_token, :password, :rol, :id_activacion, :activado)");
                $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
                $stmt->bindParam(':apellido', $this->apellido, PDO::PARAM_STR);
                $stmt->bindParam(':pais', $this->pais, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
                $stmt->bindParam(':imagen', $this->imagen, PDO::PARAM_STR);
                $stmt->bindParam(':telefono', $this->telefono, PDO::PARAM_STR);
                $stmt->bindParam(':profesion', $this->profesion, PDO::PARAM_STR);
                $stmt->bindParam(':conocio', $this->conocio, PDO::PARAM_STR);
                $stmt->bindParam(':recovery_token', $this->recovery_token, PDO::PARAM_STR);
                $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
                $stmt->bindParam(':rol', $this->rol, PDO::PARAM_INT);
                $stmt->bindParam(':id_activacion', $this->id_activacion, PDO::PARAM_STR);
                $stmt->bindParam(':activado', $this->activado, PDO::PARAM_INT);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
            
        }

        public function updatePassword($password_hashed) {

            try{
                $stmt = $this->connection()->prepare("UPDATE $this->tb SET password = :password WHERE email = :email;");
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password_hashed, PDO::PARAM_STR);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
        }

        public function update() {

            try{
                $stmt = $this->connection()->prepare("UPDATE $this->tb SET nombre = :nombre, apellido = :apellido, pais = :pais, email = :email, usuario = :usuario, telefono = :telefono, profesion = :profesion WHERE email = :email;");
                $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
                $stmt->bindParam(':apellido', $this->apellido, PDO::PARAM_STR);
                $stmt->bindParam(':pais', $this->pais, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':usuario', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':telefono', $this->telefono, PDO::PARAM_STR);
                $stmt->bindParam(':profesion', $this->profesion, PDO::PARAM_STR);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
        }

        public function updateAll($id) {

            try{
                $stmt = $this->connection()->prepare("UPDATE $this->tb SET nombre = :nombre, apellido = :apellido, pais = :pais, email = :email, usuario = :usuario, telefono = :telefono, profesion = :profesion, rol = :rol WHERE id = :id;");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
                $stmt->bindParam(':apellido', $this->apellido, PDO::PARAM_STR);
                $stmt->bindParam(':pais', $this->pais, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':usuario', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':telefono', $this->telefono, PDO::PARAM_STR);
                $stmt->bindParam(':profesion', $this->profesion, PDO::PARAM_STR);
                $stmt->bindParam(':rol', $this->rol, PDO::PARAM_INT);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
        }

        public function updateProfilePicture($route) {

            try{
                $stmt = $this->connection()->prepare("UPDATE $this->tb SET imagen = :imagen WHERE usuario = :usuario;");
                $stmt->bindParam(':imagen', $route, PDO::PARAM_STR);
                $stmt->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
        }


        public function delete($id) {
            try{
                
                $stmt = $this->connection()->prepare("DELETE FROM usuarios WHERE id = :id ");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                return $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }


        public function getRol() {

            try{
                
                $stmt = $this->connection()->prepare("SELECT rol FROM $this->tb WHERE usuario = :usuario");
                $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }

        }

        public function activateUser() {

            try{
                $stmt = $this->connection()->prepare("UPDATE $this->tb SET activado = 1 WHERE email = :email;");
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
        }

        public function setRecoveryToken() {

            try{
                $stmt = $this->connection()->prepare("UPDATE $this->tb SET recovery_token = :recovery_token WHERE email = :email;");
                $stmt->bindParam(':recovery_token', $this->recovery_token, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
        }

        public function getRecoveryToken() {

            try{
                
                $stmt = $this->connection()->prepare("SELECT recovery_token FROM $this->tb WHERE email = :email");
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* *************************************************** */
        /* Usuarios Elaboracion Perdidas */
        public function getUserPerdidas($email,$password) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM usuarios_duelo WHERE email = :email AND password = :password");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetchAll();

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function getExistentUserPerdidas($email) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM usuarios_duelo WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetchAll();

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function updateUserPerdidasLogin($email,$date) {

            try{
                
                $stmt = $this->connection()->prepare("UPDATE usuarios_duelo SET ultimo_login = :date WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function addNewUserPerdidas(){

            try{
                $stmt = $this->connection()->prepare("INSERT INTO usuarios_duelo (nombre, apellido, provincia, pais, edad, email, telefono, password) VALUES (:nombre, :apellido, :provincia, :pais, :edad, :email, :telefono, :password)");
                $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
                $stmt->bindParam(':apellido', $this->apellido, PDO::PARAM_STR);
                $stmt->bindParam(':provincia', $this->provincia, PDO::PARAM_STR);
                $stmt->bindParam(':pais', $this->pais, PDO::PARAM_STR);
                $stmt->bindParam(':edad', $this->edad, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':telefono', $this->telefono, PDO::PARAM_STR);
                $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->rowCount();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
            
        }
        /* Fin Usuarios Elaboracion Perdidas */

        /* ********************************************************* */
        /* Usuarios Seminarios Live */
        public function getUsersLive() {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM usuarios_live");
                $stmt->execute();

                while($row = $stmt->fetchAll()){
                    return $row;
                }

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function getUserLive($email) {
            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM usuarios_live WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                while($row = $stmt->fetchAll()){
                    return $row;
                }

                //return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function getRegisteredUserLive($email, $password) {
            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM usuarios_live WHERE email = :email AND login_pass = :password");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetchAll();

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function getExistentUserLive($email,$seminario) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM usuarios_live WHERE email = :email AND seminario = :seminario");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':seminario', $seminario, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetchAll();

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function addNewUserLive($seminario,$grupo){

            try{
                $stmt = $this->connection()->prepare("INSERT INTO usuarios_live (nombre, apellido, pais, email, telefono, profesion, seminario, grupo) VALUES (:nombre, :apellido, :pais, :email, :telefono, :profesion, :seminario, :grupo)");
                $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
                $stmt->bindParam(':apellido', $this->apellido, PDO::PARAM_STR);
                $stmt->bindParam(':pais', $this->pais, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':telefono', $this->telefono, PDO::PARAM_STR);
                $stmt->bindParam(':profesion', $this->profesion, PDO::PARAM_STR);
                $stmt->bindParam(':seminario', $seminario, PDO::PARAM_INT);
                $stmt->bindParam(':grupo', $grupo, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->rowCount();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }    
        }
        /* Fin Usuarios Seminarios Live */
        
    }

?>