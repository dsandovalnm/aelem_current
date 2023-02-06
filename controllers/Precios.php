<?php 

	include_once('verify_url.php');

	class Precio extends Connect {
		public $id = 0;
		public $codigo_seminario = 0;
		public $tipo = '';
		public $valor = 0;
		public $descripcion = '';

		public function add() {
            try{
                $stmt = $this->connection()->prepare("INSERT INTO precios (
						 codigo_seminario,
						 tipo,
						 valor,
						 descripcion) VALUES (
							 :codigo_seminario,
							 :tipo,
							 :valor,
							 :descripcion
						 )");

                $stmt->bindParam(':codigo_seminario', $this->codigo_seminario, PDO::PARAM_INT);
					 $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);					 
					 $stmt->bindParam(':valor', $this->valor, PDO::PARAM_INT);
					 $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
		}

		public function getAll() {
				try{
                $stmt = $this->connection()->query("SELECT * FROM precios");
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
		}

		public function update() {
            try{
                $stmt = $this->connection()->prepare("UPDATE precios SET 
					 	codigo_seminario = :codigo_seminario,
						tipo = :tipo,
						valor = :valor,
						descripcion = :descripcion						
							WHERE id = :id;");

                $stmt->bindParam(':codigo_seminario', $this->codigo_seminario, PDO::PARAM_INT);
                $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
                $stmt->bindParam(':valor', $this->valor, PDO::PARAM_INT);
                $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
		}

        public function delete() {
            try{
                $stmt = $this->connection()->prepare("DELETE FROM precios WHERE id = :id");

                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                
                return $stmt->execute();
            
            }catch (\Throwable $err){
            
                var_dump($err);
                exit;
            
            }finally {
            
                $stmt = null;
            }
        }

		public function getBySeminarioCode($codigo_seminario) {
				try{
                $stmt = $this->connection()->prepare("SELECT * FROM precios WHERE codigo_seminario = :codigo_seminario");
					 $stmt->bindParam(':codigo_seminario', $codigo_seminario, PDO::PARAM_INT);

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

