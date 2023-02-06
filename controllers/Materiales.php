<?php

    include_once('verify_url.php');

    class Material extends Connect{

        public $codigoMaterial = '';
        public $nombreMaterial = '';
        public $tipoMaterial = '';
        public $grupo = '';
        public $codigoSeminario = '';
        public $esArchivo = 0;
        public $enlaceMaterial = '';

        /* Obtener Materiales Live */
        public function getMateriales() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM material_live");

                while($row = $stmt->fetchAll()) {
                    return $row;
                }
                
                //return($stmt->fetch_all(MYSQLI_ASSOC));
                
            }catch (\Throwable $err){

                return ($err->getMessage());
                
            }finally{

                //$stmt->close();
            }
            
        }

        /* Obtener Un Material */
        public function getMaterial($codigo_material) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM material_live WHERE orden = :codigo_material");
                $stmt->bindParam(':codigo_material', $codigo_material, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetch();

            }catch (\Throwable $err){

                return ($err->getMessage());

            }finally {

                //$stmt->close();
            }
        }

        /* Obtener el último orden de los materiales */
        public function getOrderLastMaterialLive() {

            try{
                
                $stmt = $this->connection()->prepare("SELECT MAX(id) FROM material_live AS id");
                $stmt->execute();

                $id_sem = $stmt->fetch(PDO::FETCH_ASSOC);
                $id = $id_sem['MAX(id)'];

                $stmt = $this->connection()->prepare("SELECT orden FROM material_live WHERE id = $id");
                $stmt->execute();

                return $row = $stmt->fetch();

            }catch (\Throwable $err){

                return($err->getMessage());

            }finally {

                //$stmt->close();
            }
        }

        /* Agregar Material a un Seminario */
        public function addMaterialSeminarioLive() {

            try{
                $stmt = $this->connection()->prepare("INSERT INTO material_live (orden, nombre, tipo, grupo, seminario, file, src) VALUES (:orden, :nombre, :tipo, :grupo, :seminario, :file, :src)");

                $stmt->bindParam(':orden', $this->codigoMaterial, PDO::PARAM_INT);
                $stmt->bindParam(':nombre', $this->nombreMaterial, PDO::PARAM_STR);
                $stmt->bindParam(':tipo', $this->tipoMaterial, PDO::PARAM_STR);
                $stmt->bindParam(':grupo', $this->grupo, PDO::PARAM_INT);
                $stmt->bindParam(':seminario', $this->codigoSeminario, PDO::PARAM_INT);
                $stmt->bindParam(':file', $this->esArchivo, PDO::PARAM_INT);
                $stmt->bindParam(':src', $this->enlaceMaterial, PDO::PARAM_STR);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                return($err->getMessage());
            
            }finally {
            
                //$stmt->close();
            }

        }

        /* Obtener Materiales por Grupo */
        public function getAllBySubscription() {
                try{
                    $stmt = $this->connection()->prepare("SELECT * FROM material_live WHERE grupo = :grupo AND seminario = :seminario");
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

        /* Obtener los materiales y ordenarlos ascendentemente */
        public function getMaterialesOrden() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM material_live ORDER BY orden ASC");
                
                while($row = $stmt->fetchAll()) {
                    return $row;
                }

                //return($stmt->fetch_all(MYSQLI_ASSOC));
                
            }catch (\Throwable $err){

                return ($err->getMessage());
                
            }finally{
                //$stmt->close();
            }
            
        }

        /* Obtener Material de un Seminario */
        public function getMaterialSeminario($codigo_seminario) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM material_live WHERE seminario = :codigo_seminario");
                $stmt->bindParam(':codigo_seminario', $codigo_seminario, PDO::PARAM_INT);
                $stmt->execute();

                while($row = $stmt->fetchAll()) {
                    return $row;
                }

            }catch (\Throwable $err){

                return ($err->getMessage());
                
            }finally {

                //$stmt->close();
            }
        }

        /* Eliminar Material de un Seminario */
        public function removeMaterialSeminario($code_material) {

            try{
                
                $stmt = $this->connection()->prepare("DELETE FROM material_live WHERE orden = :code_material");
                $stmt->bindParam(':code_material', $code_material, PDO::PARAM_INT);
                
                return $stmt->execute();

            }catch (\Throwable $err){

                return($err->getMessage());

            }finally {

                //$stmt->close();
            }
        }

    }