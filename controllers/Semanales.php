<?php 

	include_once('verify_url.php');

	class Semanal extends Connect {

		public function add() {
			
		}

		public function getAll() {
			try{
					$stmt = $this->connection()->query("SELECT * FROM clases_semanales");
					return $stmt->fetchAll(PDO::FETCH_ASSOC);
					
			}catch (\Throwable $err){

					return($err->getMessage());

			}finally{

					$stmt = null;
			}
		}

		public function getById($id) {
			try{
				$stmt = $this->connection()->prepare("SELECT * FROM clases_semanales WHERE id = :id");
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt->execute();

				return $stmt->fetch(PDO::FETCH_ASSOC);
			}catch (\Throwable $err){
					var_dump($err);
					exit;
			}finally {
					$stmt = null;
			}
		}

		public function delete() {

		}

		public function update() {

		}
	}
