<?php

    include_once('verify_url.php');

    class Profesional extends Connect {

        public $tb = 'profesionales';

        public function getAll() {

            try{
                $stmt = $this->connection()->query("SELECT * FROM $this->tb ORDER BY orden ASC");

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }

        }

        public function getById($prof_id) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM $this->tb WHERE id = :id");
                $stmt->bindParam(':id', $prof_id, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function getTotalClicks() {
            try{
                
                $stmt = $this->connection()->prepare("SELECT click_totales FROM $this->tb");
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }

        public function addClick($tot, $id_prof) {

            try{
                
                $stmt = $this->connection()->prepare("UPDATE $this->tb SET click_totales = :tot WHERE id = :id_prof;");
                $stmt->bindParam(':tot', $tot, PDO::PARAM_INT);
                $stmt->bindParam(':id_prof', $id_prof, PDO::PARAM_INT);
                $stmt->execute();

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                $stmt = null;
            }
        }
        
    }