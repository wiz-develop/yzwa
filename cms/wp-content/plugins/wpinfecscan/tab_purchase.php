<?php if ( ! defined( 'ABSPATH' ) ) {exit;}?>
<div class="tab-pane" id="ContentC">
    <div class="col-lg-12">
        <?php
            $urlparts = parse_url(site_url());
            $domain = trim($urlparts["host"]);
        ?>
        <iframe src="<?php echo $durl;?>WPINFECTPAY/wpinfectscancheckout.php?mydomain=<?php echo $domain; ?>&lang=<?php echo get_locale();?>" style="width:100%;height:900px">
        </iframe>
    </div>
</div>