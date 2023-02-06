<?php

	include_once('verify_url.php');

	class Log extends Connect{

		public $tb = 'logs';
		public $accion = '';
		public $usuario = '';

		public function add() {
			try{
					$stmt = $this->connection()->prepare("INSERT INTO $this->tb (
									accion,
									usuario,
									fecha) VALUES (
										:accion,
										:usuario,
										date)");
		
					$stmt->bindParam(':accion', $this->accion, PDO::PARAM_STR);
					$stmt->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
					
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
			
	
}