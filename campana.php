<?php

    include_once('controllers/Campaigns.php');

    $camp = new Campaign;
    $campaign = $camp->getCampaign(100);

    header('Location: '.$campaign['link']);

?>