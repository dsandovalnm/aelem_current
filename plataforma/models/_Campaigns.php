<?php

    include_once('../../controllers/Campaigns.php');

    $req = $_POST['request'];

    if($req === 'campaign_req') {

        $camp = new Campaign;

        $code = 100;
        $link = $_POST['new_link'];
        $link = filter_var($link, FILTER_VALIDATE_URL);

        $updated = $camp->updateLinkCampaign($code, $link);

        if($updated === 1) {
            $respuesta = [
                'status' => true,
                'message' => 'Enlace actualizado correctamente',
                'action' => 'reload'
            ];
        }else {
            $respuesta = [
                'status' => false,
                'title' => 'Error',
                'message' => 'Error al actualizar el enlace, intenta nuevamente'
            ];
        }

        echo json_encode($respuesta);
        die();
    }