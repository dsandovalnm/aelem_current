<?php

    include_once('verify_url.php');

    /* Cursos - Escuelas */
    class Payment extends Connect{

        public $transaction_key = '';
        public $course_code = NULL;
        public $course_name = '';
        public $email = '';
        public $quantity = NULL;
        public $total = '';
        public $entity = '';
        public $verified = 0;
        public $status = 'Pending';
        public $price = '';
        public $modality = 'online';
        public $idPayment = NULL;
        public $subscriptionID = '';
        public $asesor = '';
        public $token = '';
        public $grupo_actual = 0;

        public function addPayment(){

            try{
                $stmt = $this->connection()->prepare("INSERT INTO payments (transaction_key, date, email, quantity, total, entity, verified, status, asesor, token) VALUES (:transaction_key,NOW(),:email,:quantity,:total,:entity,:verified,:status,:asesor,:token)");
                $stmt->bindParam(':transaction_key', $this->transaction_key, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':quantity', $this->quantity, PDO::PARAM_INT);
                $stmt->bindParam(':total', $this->total, PDO::PARAM_INT);
                $stmt->bindParam(':entity', $this->entity, PDO::PARAM_STR);
                $stmt->bindParam(':verified', $this->verified, PDO::PARAM_INT);
                $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
                $stmt->bindParam(':asesor', $this->asesor, PDO::PARAM_STR);
                $stmt->bindParam(':token', $this->token, PDO::PARAM_STR);
                $stmt->execute();

                $this->idPayment = $this->getLastIdPayment()['MAX(id)'];

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }

        }

        /* Obtener ultimo pago por Id */
        private function getLastIdPayment() {
            try{
                $stmt = $this->connection()->query("SELECT MAX(id) FROM payments");
                
                return $stmt->fetch(PDO::FETCH_ASSOC);
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                // $stmt->close();
            }
        }

        /* Obtener pagos */
        public function getPayments() {
            try{
                $stmt = $this->connection()->query("SELECT * FROM payments");
                
                return($stmt->fetchAll(PDO::FETCH_ASSOC));
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                $stmt = null;
            }
            
        }

        /* Get Payment By Transaction */
        public function getByTransaction($transaction_key) {

            try{
                $stmt = $this->connection()->prepare("SELECT * FROM payments WHERE transaction_key = :transaction_key");
                $stmt->bindParam(':transaction_key',$transaction_key,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                $stmt = null;
            }
        }

        /* Get Payment Details By Transaction */
        public function getDetailsByTransaction($transaction_key) {

            try{
                $stmt = $this->connection()->prepare("SELECT * FROM payment_details WHERE transaction_key = :transaction_key");
                $stmt->bindParam(':transaction_key',$transaction_key,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                $stmt = null;
            }
        }


        /* Obtener pago por email */
        public function getPaymentsByEmail($email) {

            try{
                $stmt = $this->connection()->prepare("SELECT * FROM payments WHERE email = :email");
                $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                $stmt = null;
            }
        }

        /* Obtener pagos que contengan email */
        public function getPaymentsContainsEmail($email) {

            try{
                $stmt = $this->connection()->prepare("SELECT * FROM payments WHERE email LIKE :email");
                $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                $stmt = null;
            }
        }

        /* Obtener ID de un Pago */
        public function getIdPayment($transaction_key) {
            try{
                $stmt = $this->connection()->prepare("SELECT id FROM payments WHERE transaction_key = :transaction_key");
                $stmt->bindParam(':transaction_key',$transaction_key,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                $stmt = null;
            }
            
        }

        /* Agregar detalles de pago */
        public function setPaymentDetails() {
            try{
                $stmt = $this->connection()->prepare("INSERT INTO payment_details (transaction_key, course_code, course_name, price, modality) VALUES (:transaction_key,:course_code,:course_name,:price,:modality)");
                $stmt->bindParam(':transaction_key', $this->transaction_key, PDO::PARAM_STR);
                $stmt->bindParam(':course_code', $this->course_code, PDO::PARAM_INT);
                $stmt->bindParam(':course_name', $this->course_name, PDO::PARAM_STR);
                $stmt->bindParam(':price', $this->price, PDO::PARAM_INT);
                $stmt->bindParam(':modality', $this->modality, PDO::PARAM_STR);
                $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Add Session Token to Payment */
        public function setSessionToken(){

            try{

                $stmt = $this->connection()->prepare("UPDATE payments SET token = :token WHERE transaction_key = :transaction_key;");
                $stmt->bindParam(':token',$this->token, PDO::PARAM_STR);
                $stmt->bindParam(':transaction_key',$this->transaction_key,PDO::PARAM_STR);
                $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }

        }

        /* Get Payment Session Token */
        public function getSessionToken() {
            try{
                $stmt = $this->connection()->prepare("SELECT token FROM payments WHERE transaction_key = :transaction_key");
                $stmt->bindParam(':transaction_key',$this->transaction_key,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                $stmt = null;
            }
            
        }


        /* Obtener los detalles de pago */
        public function getPaymentDetails($transaction_key) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM payment_details WHERE transaction_key = :transaction_key");
                $stmt->bindParam(':transaction_key',$transaction_key,PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                $stmt = null;
            }
            
        }

        /* Obtener Detalles de Pago por Seminario */
        public function getPaymentDetailsBySeminario($course_code) {
            try{
                $stmt = $this->connection()->prepare("SELECT * FROM payment_details WHERE course_code = :course_code");
                $stmt->bindParam(':course_code',$course_code,PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                $stmt = null;
            }
            
        }

        /* Actualizar Pago como Verificado */
        private function setPaymentVerified($id_payment){

            try{

                $stmt = $this->connection()->prepare("UPDATE payments SET verified = '1' WHERE id = :id_payment;");
                $stmt->bindParam(':id_payment',$id_payment,PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->rowCount();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }

        }

        /* Setear Pago como Completado */
        public function setPaymentComplete($transaction_key, $total, $id_payment){

            try{

                $stmt = $this->connection()->prepare("UPDATE payments SET status = 'Completed' WHERE transaction_key = :transaction_key AND total = :total AND id = :id_payment");
                $stmt->bindParam(':transaction_key',$transaction_key,PDO::PARAM_STR);
                $stmt->bindParam(':total',$total,PDO::PARAM_INT);
                $stmt->bindParam(':id_payment',$id_payment,PDO::PARAM_INT);
                $stmt->execute();

                if($stmt->rowCount() > 0 && $this->setPaymentVerified($id_payment) > 0) {

                    /* AGREGAR SUSCRIPCION A DB */
                    /* Agregar el controlador de Registros dependiendo de la URL */
                        $url_link = explode('/', $_SERVER['REQUEST_URI']);
                        $page = '';
                        
                        foreach($url_link as $url) {
                            switch($url) {
                                case 'plataforma' :
                                case 'models' :
                                    $page = $url;
                                break;
                            }
                        }

                        switch($page) {
                            case 'plataforma' :
                                require_once('../controllers/Suscripciones.php');
                            break;

                            case 'models' :
                            case 'pagos' :
                                require_once('../../controllers/Suscripciones.php');
                            break;

                            default :
                                require_once('controllers/Suscripciones.php');
                            break;
                        }

                    $susCode = $this->subscriptionID === '' ? uniqid('AEL_') : $this->subscriptionID;

                    $sus = new Suscripcion;
                    $sus->codigo = $susCode;
                    $sus->transaction_key = $transaction_key;
                    $sus->email = $this->email;
                    $sus->codigo_curso = $this->course_code;
                    $sus->grupo = $this->grupo_actual;

                        if($this->course_code <= '3') {
                            $sus->premium = 1;
                        }

                    $sus->status = 'active';

                    $susExist = $sus->getExistent();

                    if(!$susExist) {
                        if($sus->add() < 1) {
                            return false;
                        }
                    }else {
                        return false;
                    }

                    return true;

                }else {
                    
                    return false;
                }

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally {

                $stmt = null;
            }
        }

        /* Remove a Payment */
        public function delete() {
            try{
                $stmt = $this->connection()->prepare("DELETE FROM payments WHERE transaction_key = :transaction_key");
                $stmt->bindParam(':transaction_key',$this->transaction_key,PDO::PARAM_STR);
                $stmt->execute();

                $stmt = $this->connection()->prepare("DELETE FROM payment_details WHERE transaction_key = :transaction_key");
                $stmt->bindParam(':transaction_key',$this->transaction_key,PDO::PARAM_STR);
                $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;

            }finally{

                $stmt = null;
            }
            
        }
        
    }
