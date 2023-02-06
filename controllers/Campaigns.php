<?php

    include_once('verify_url.php');

    class Campaign extends Connect {

        public function getCampaigns() {

            try{
                $stmt = $this->connection()->query("SELECT * FROM campaigns");

                while($row = $stmt->fetchAll()){
                    return $row;
                }
                
                //return($stmt->fetch_all(MYSQLI_ASSOC));
                
            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                //$stmt->close();
            }

        }

        public function getCampaign($codigo_campaign) {

            try{
                
                $stmt = $this->connection()->prepare("SELECT * FROM campaigns WHERE codigo = :codigo_campaign");
                $stmt->bindParam(':codigo_campaign', $codigo_campaign, PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->fetch();

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                //$stmt->close();
            }
        }

        public function updateLinkCampaign($codigo_campaign, $link) {

            try{
                
                $stmt = $this->connection()->prepare("UPDATE campaigns SET link = :link WHERE codigo = :codigo_campaign");
                $stmt->bindParam(':codigo_campaign', $codigo_campaign, PDO::PARAM_INT);
                $stmt->bindParam(':link', $link, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->rowCount();

            }catch (\Throwable $err){

                var_dump($err);
                exit;
            }finally {

                //$stmt->close();
            }
        }
    }