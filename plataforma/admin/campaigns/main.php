<?php

    include_once('../controllers/Campaigns.php');

    $camp = new Campaign;

    $campaign = $camp->getCampaign(100);
    
?>  
<section class="admin-section-camapanas">
    <h5 class="title text-center">Campañas</h5>

    <form id="update-campaign-form" class="py-5" method="post">
        <div class="form-group">
            <input type="hidden" id="request" name="request" value="campaign_req">
            <label for="link_campaign"><p>Enlace Actual</p></label>
            <input type="text" class="form-control" id="current_link" name="current_link" disabled value="<?php echo $campaign['link'] ?>">
            <label for="link_campaign"><p>Actualizar Enlace</p></label>
            <input type="text" class="form-control" id="new_link" name="new_link" required autocomplete="off">
        </div>
        <button type="submit" class="btn btn-info" id="upd_btn" name="upd_btn">Actualizar</button>
    </form>
</section>