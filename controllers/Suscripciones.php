<?php

    include_once('verify_url.php');

    /* ARTICULOS COMUNES */
    class Suscripcion extends Connect {

        public $codigo = '';
        public $transaction_key = '';
        public $email = '';
        public $codigo_curso = '';
        public $grupo = 0;
        public $status = '';
        public $subscriptionId = '';
        public $premium = 0;

        /* Agregar suscripcion */
        public function add() {
            try{
                $stmt = $this->connection()->prepare("INSERT INTO suscripciones (codigo, transaction_key, email, codigo_curso, grupo, status, premium) VALUES (:codigo, :transaction_key, :email, :codigo_curso, :grupo, :status, :premium)");
                $stmt->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
                $stmt->bindParam(':transaction_key', $this->transaction_key, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':codigo_curso', $this->codigo_curso, PDO::PARAM_INT);
                $stmt->bindParam(':grupo', $this->grupo, PDO::PARAM_INT);
                $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
                $stmt->bindParam(':premium', $this->premium, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->rowCount();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Obtener Todas las suscripciones */
        public function getAll() {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM suscripciones");
                $stmt->execute();

                return($stmt->fetchAll(PDO::FETCH_ASSOC));

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Get Register By Email */
        public function getByEmail($email) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM suscripciones WHERE email = :email");
                $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                $stmt->execute();

                return($stmt->fetchAll(PDO::FETCH_ASSOC));

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }
        /* Get Register By Transaction */
        public function getByTransaction($transaction_key) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM suscripciones WHERE transaction_key = :transaction_key");
                $stmt->bindParam(':transaction_key',$transaction_key,PDO::PARAM_STR);
                $stmt->execute();

                return($stmt->fetch(PDO::FETCH_ASSOC));

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Get Register By Code */
        public function getByCode($code) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM suscripciones WHERE codigo = :codigo");
                $stmt->bindParam(':codigo',$code,PDO::PARAM_STR);
                $stmt->execute();

                return($stmt->fetch(PDO::FETCH_ASSOC));

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Get Subscription Status */
        public function getStatus() {
            try{
                $stmt = $this->connection()->prepare("SELECT status FROM suscripciones WHERE codigo = :subscriptionCode");
                $stmt->bindParam(':subscriptionCode',$this->codigo,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC)['status'];

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Update Subscription Status */
        public function updateStatus() {

            $stmt = $this->connection()->prepare("UPDATE suscripciones SET status = :status WHERE codigo = :subscriptionId");
            $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
            $stmt->bindParam(':subscriptionId', $this->subscriptionId, PDO::PARAM_STR);

            return $stmt->execute();
        }

        /* Get and Existent Register By Email */
        public function getExistent() {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM suscripciones WHERE email = :email AND codigo_curso = :codigo_curso");
                $stmt->bindParam(':email',$this->email,PDO::PARAM_STR);
                $stmt->bindParam(':codigo_curso',$this->codigo_curso,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Check Paypal Token */
        public function getAccessToken($entity) {

            $stmt = $this->connection()->prepare("SELECT * FROM api_tokens WHERE entity = :entity");
            $stmt->bindParam(':entity',$entity,PDO::PARAM_STR);

            $stmt->execute();

            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res['token'];

        }

        /* Update Paypal Token */
        public function updateAccesToken($entity, $token) {

            $stmt = $this->connection()->prepare("UPDATE api_tokens SET token = :token WHERE entity = :entity");
            $stmt->bindParam(':entity', $entity, PDO::PARAM_STR);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);

            return $stmt->execute();
        }
        
    }