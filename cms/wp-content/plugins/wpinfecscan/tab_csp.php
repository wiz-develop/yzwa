<?php if ( ! defined( 'ABSPATH' ) ) {exit;}?>
<?php	
if(! isset($_POST['csppost'])){

	$csp_options = get_option( 'wpinfectscanner_csp', "" );
	if(! empty($csp_options)){
		$csp_options = get_option( 'wpinfectscanner_csp', array() );
		// ======================
		// チェックボックス（単体）
		// ======================
		$wpinfectscanner_csp = $csp_options['csp'] ?? '';
		$wpinfectscanner_csp_mode = $csp_options['csp_mode'] ?? '';

		// ======================
		// default-src
		// ======================
		$set_default_src   = $csp_options['default-src']['enable'] ?? '';
		$set_default_src_i = $csp_options['default-src']['inline'] ?? '';
		$set_default_src_o = $csp_options['default-src']['other']  ?? '';

		// ======================
		// script-src
		// ======================
		$set_script_src   = $csp_options['script-src']['enable'] ?? '';
		$set_script_src_i = $csp_options['script-src']['inline'] ?? '';
		$set_script_src_d = $csp_options['script-src']['domain'] ?? array();
		$set_script_src_o = $csp_options['script-src']['other']  ?? '';

		// ======================
		// connect-src
		// ======================
		$set_connect_src   = $csp_options['connect-src']['enable'] ?? '';
		$set_connect_src_d = $csp_options['connect-src']['domain'] ?? array();
		$set_connect_src_o = $csp_options['connect-src']['other']  ?? '';

		// ======================
		// frame-src
		// ======================
		$set_frame_src   = $csp_options['frame-src']['enable'] ?? '';
		$set_frame_src_d = $csp_options['frame-src']['domain'] ?? array();
		$set_frame_src_o = $csp_options['frame-src']['other']  ?? '';

		// ======================
		// style-src
		// ======================
		$set_style_src   = $csp_options['style-src']['enable'] ?? '';
		$set_style_src_i = $csp_options['style-src']['inline'] ?? '';
		$set_style_src_d = $csp_options['style-src']['domain'] ?? array();
		$set_style_src_o = $csp_options['style-src']['other']  ?? '';

		// ======================
		// base-uri
		// ======================
		$set_base_uri = $csp_options['base-uri'] ?? '';

		// ======================
		// form-action
		// ======================
		$set_form_action   = $csp_options['form-action']['enable'] ?? '';
		$set_form_action_o = $csp_options['form-action']['other']  ?? '';

		// ======================
		// img-src
		// ======================
		$set_img_src   = $csp_options['img-src']['enable'] ?? '';
		$set_img_src_o = $csp_options['img-src']['other']  ?? '';
		$set_img_src_i = $csp_options['img-src']['inline']  ?? '';

		// ======================
		// font-src
		// ======================
		$set_font_src   = $csp_options['font-src']['enable'] ?? '';
		$set_font_src_i = $csp_options['font-src']['inline'] ?? '';
		$set_font_src_d = $csp_options['font-src']['domain'] ?? array();
		$set_font_src_o = $csp_options['font-src']['other']  ?? '';
	}else{
		$wpinfectscanner_csp = '';
		$wpinfectscanner_csp_mode = '';
		$set_default_src   = '';
		$set_default_src_i = '';
		$set_default_src_o = '';
		$set_script_src   = '';
		$set_script_src_i = '';
		$set_script_src_d = array();
		$set_script_src_o = '';
		$set_connect_src   = '';
		$set_connect_src_d = array();
		$set_connect_src_o = '';
		$set_frame_src   = '';
		$set_frame_src_d = array();
		$set_frame_src_o = '';
		$set_style_src   = '';
		$set_style_src_i = '';
		$set_style_src_d = array();
		$set_style_src_o = '';
		$set_base_uri = '';
		$set_form_action   = '';
		$set_form_action_o = '';
		$set_img_src   = '';
		$set_img_src_o = '';
		$set_img_src_i = '';
		$set_font_src   = '';
		$set_font_src_i = '';
		$set_font_src_d = array();
		$set_font_src_o = '';
	}
}
?>
<div class="tab-pane" id="ContentI">
    <div class="col-lg-12">
	<h3><span class="dashicons dashicons-admin-tools" style="font-size: 25px;color:#a068d8;margin-right:10px;"></span><?php echo __("Content Security Policy",'wpinfecscan'); ?></h3>
	
        <p><?php echo __("CSP (Content Security Policy) is a mechanism that specifies to the browser “which types of sources (such as scripts, images, stylesheets, etc.) are allowed to be loaded and from where,” helping to prevent XSS (Cross-Site Scripting: attacks that execute external scripts on a site), and even if unauthorized code is embedded due to site tampering, it can partially (though not perfectly) prevent users accessing the site from executing such malicious scripts; when enabled, it is recommended to verify the site’s display and behavior.",'wpinfecscan'); ?></p>
        <style>
            .csptable th,.csptable td{ vertical-align: top;}
        </style>
        <form method="post" action="<?php echo '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
        
            <h5><input type="checkbox" name="wpinfectscanner_csp" value="1" <?php if ($wpinfectscanner_csp == '1') echo 'checked'; ?> > <?php echo __("Enable CSP settings",'wpinfecscan'); ?></h5>
			
			<p>
			<input type="radio" id="wpinfectscanner_csp_mode" name="wpinfectscanner_csp_mode" value="1" <?php if (empty($wpinfectscanner_csp_mode) || $wpinfectscanner_csp_mode == '1') echo 'checked'; ?> /><?php echo __("Use add_action (Using a cache plugin may cause it to not work.)",'wpinfecscan'); ?>
			<br>
			<input type="radio" id="wpinfectscanner_csp_mode" name="wpinfectscanner_csp_mode" value="2" <?php if ($wpinfectscanner_csp_mode == '2') echo 'checked'; ?> /><?php echo __("Use htaccess",'wpinfecscan'); ?>
			</p>
			
			<?php
			$siteurl = get_site_url();
			$chekurl = "https://report-uri.com/home/analyse/".urlencode($siteurl);
			?>
			<button type="button" onclick="window.open('<?php echo $chekurl;?>', '_blank')"><?php echo __("✓Check the current CSP externally",'wpinfecscan'); ?></button>
            <table class="form-table csptable">
                <tr valign="top">
                    <th scope="row"><?php echo __("Basic rule setting: default-src",'wpinfecscan'); ?></th>
                    <td style="max-width:350px"><?php echo __("When default-src is set, it collectively specifies various CSP settings such as script-src below; however, if script-src or other directives are additionally set, they will override default-src, so please be careful.",'wpinfecscan'); ?>
                        <br><br><?php echo __("Example: If default-src and script-src are both specified → only the script-src setting is applied to JavaScript.",'wpinfecscan'); ?></td>
                    <td>
                        <b><?php echo __("Global settings for allowing browser loading",'wpinfecscan'); ?></b>
                        <br>
                        <input type="radio" id="set-default-src" name="set-default-src" value="" <?php if ($set_default_src === '') echo 'checked'; ?> /><?php echo __("Do not set",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-default-src" name="set-default-src" value="*" <?php if ($set_default_src === '*') echo 'checked'; ?> /><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-default-src" name="set-default-src" value="self" <?php if ($set_default_src === 'self' || ! isset($_POST['csppost'])) echo 'checked'; ?> /><?php echo __("Allow only sources on the same domain (Recommended: make this strict and configure allowed domains individually in other items)",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-default-src" name="set-default-src" value="selfplus" <?php if ($set_default_src === 'selfplus') echo 'checked'; ?> /><?php echo __("Allow sources on the same domain and the sources entered below",'wpinfecscan'); ?>
						<br>
						<div id="set-default-src-setter">
						<br> <?php echo __("✓To add allowed domains, please add one per line in the text area",'wpinfecscan'); ?>
						<br> <?php echo __("* means all subdomains are included",'wpinfecscan'); ?>
                        <textarea style="width:100%;height:70px;" name="set-default-src-o" placeholder="https://*.allowdomain.com"><?php
						echo htmlspecialchars($set_default_src_o, ENT_QUOTES, 'UTF-8');
						?></textarea>
                        <br>
						</div>
                    </td>
                </tr>
				
				<tr valign="top">
                    <th scope="row"></th>
                    <td><?php echo __("Control of inline scripts and CSS",'wpinfecscan'); ?></td>
                    <td>
                        <input type="radio" id="set-default-src-i" name="set-default-src-i" <?php if ($set_default_src_i === '' || ! isset($_POST['csppost'])) echo 'checked'; ?> value="" /><?php echo __("Do not set",'wpinfecscan'); ?>
						<br>
                        <input type="radio" id="set-default-src-i" name="set-default-src-i" value="unsafe-inline" <?php if ($set_default_src_i === 'unsafe-inline') echo 'checked'; ?> /><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
					
					</td>
                </tr>
				
				
            <tr><td colspan="4"><hr></td></tr>
			
                <tr valign="top">
                    <th scope="row"><?php echo __("JavaScript loading settings: script-src",'wpinfecscan'); ?></th>
                    <td><?php echo __("This setting controls the sources from which JavaScript can be loaded and executed, serving as a countermeasure against XSS and the execution of maliciously embedded scripts.",'wpinfecscan'); ?></td>
                    <td><b><?php echo __("JavaScript allowed to be loaded by the browser",'wpinfecscan'); ?></b>
                        <br>
                        <input type="radio" id="set-script-src" name="set-script-src" value=""  <?php if ($set_script_src === '') echo 'checked'; ?> /><?php echo __("Do not set (uses the default-src setting)",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-script-src" name="set-script-src" value="*" <?php if ($set_script_src === '*') echo 'checked'; ?> /><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-script-src" name="set-script-src" value="self" <?php if ($set_script_src === 'self') echo 'checked'; ?> /><?php echo __("Allow only sources on the same domain",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-script-src" name="set-script-src" value="selfplus" <?php if ($set_script_src === 'selfplus' || ! isset($_POST['csppost']) ) echo 'checked'; ?> /><?php echo __("Allow sources on the same domain and specified external sources (Recommended)",'wpinfecscan'); ?>
						<br>
						<div id="set-script-src-setter">
						<br>&xdtri; <?php echo __("Check the domains to allow",'wpinfecscan'); ?>
                        
						<br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://www.google.com/" <?php if (isset($set_script_src_d) && in_array('https://www.google.com/', $set_script_src_d)) echo 'checked'; ?> />https://www.google.com/ (Google)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://www.googletagmanager.com" <?php if (isset($set_script_src_d) && in_array('https://www.googletagmanager.com', $set_script_src_d)) echo 'checked'; ?> />https://www.googletagmanager.com (Google Tag Manager)
                        
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://www.googleadservices.com" <?php if (isset($set_script_src_d) && in_array('https://www.googleadservices.com', $set_script_src_d)) echo 'checked'; ?> />https://www.googleadservices.com (Google Ads)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://pagead2.googlesyndication.com" <?php if (isset($set_script_src_d) && in_array('https://pagead2.googlesyndication.com', $set_script_src_d)) echo 'checked'; ?> />https://pagead2.googlesyndication.com (Google Ads)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://securepubads.g.doubleclick.net" <?php if (isset($set_script_src_d) && in_array('https://securepubads.g.doubleclick.net', $set_script_src_d)) echo 'checked'; ?> />https://securepubads.g.doubleclick.net (Google Ads)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://www.gstatic.com" <?php if (isset($set_script_src_d) && in_array('https://www.gstatic.com', $set_script_src_d)) echo 'checked'; ?> />https://www.gstatic.com (reCAPTCHA、CDN)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://cdnjs.cloudflare.com" <?php if (isset($set_script_src_d) && in_array('https://cdnjs.cloudflare.com', $set_script_src_d)) echo 'checked'; ?> />https://cdnjs.cloudflare.com (CDN Cloudflare)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://cdn.jsdelivr.net" <?php if (isset($set_script_src_d) && in_array('https://cdn.jsdelivr.net', $set_script_src_d)) echo 'checked'; ?> />https://cdn.jsdelivr.net (CDN jsDelivr)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://unpkg.com" <?php if (isset($set_script_src_d) && in_array('https://unpkg.com', $set_script_src_d)) echo 'checked'; ?> />https://unpkg.com (CDN unpkg)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://*.cloudfront.net" <?php if (isset($set_script_src_d) && in_array('https://*.cloudfront.net', $set_script_src_d)) echo 'checked'; ?> />https://*.cloudfront.net (CDN Amazon CloudFront)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://*.akamaihd.net" <?php if (isset($set_script_src_d) && in_array('https://*.akamaihd.net', $set_script_src_d)) echo 'checked'; ?> />https://*.akamaihd.net (CDN Akamai)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://*.akamaized.net" <?php if (isset($set_script_src_d) && in_array('https://*.akamaized.net', $set_script_src_d)) echo 'checked'; ?> />https://*.akamaized.net (CDN Akamai)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://*.fastly.net" <?php if (isset($set_script_src_d) && in_array('https://*.fastly.net', $set_script_src_d)) echo 'checked'; ?> />https://*.fastly.net (CDN Fastly)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://*.wordpress.com" <?php if (isset($set_script_src_d) && in_array('https://*.wordpress.com', $set_script_src_d)) echo 'checked'; ?> />https://*.wordpress.com (Jetpack)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://jetpack.wordpress.com" <?php if (isset($set_script_src_d) && in_array('https://jetpack.wordpress.com', $set_script_src_d)) echo 'checked'; ?> />https://jetpack.wordpress.com (Jetpack)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://stats.wp.com" <?php if (isset($set_script_src_d) && in_array('https://stats.wp.com', $set_script_src_d)) echo 'checked'; ?> />https://stats.wp.com (Jetpack Stats)
                        <br><input type="checkbox" id="set-script-src-d" name="set-script-src-d[]" value="https://*.wp.com" <?php if (isset($set_script_src_d) && in_array('https://*.wp.com', $set_script_src_d)) echo 'checked'; ?> />https://*.wp.com (Jetpack Stats)
                            
                        <br><br> <?php echo __("✓To add more allowed domains, please add one per line in the text area",'wpinfecscan'); ?>
                        <textarea style="width:100%;height:70px;" name="set-script-src-o" placeholder="https://*.allowdomain.com"><?php
						echo htmlspecialchars($set_script_src_o, ENT_QUOTES, 'UTF-8');
						?></textarea>
						</div>
                        <br>
                    </td>
                </tr>
				
				<tr valign="top">
                    <th scope="row"></th>
                    <td><?php echo __("Control of inline scripts",'wpinfecscan'); ?></td>
                    <td>
                        <input type="radio" id="set-script-src-i" name="set-script-src-i" value="" <?php if ($set_script_src_i === '') echo 'checked'; ?> /><?php echo __("Do not set",'wpinfecscan'); ?>
						<br>
                        <input type="radio" id="set-script-src-i" name="set-script-src-i" value="unsafe-inline" <?php if ($set_script_src_i === 'unsafe-inline' || ! isset($_POST['csppost'])) echo 'checked'; ?> /><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
						<input type="radio" id="set-script-src-i" name="set-script-src-i" value="unsafe-eval" <?php if ($set_script_src_i === 'unsafe-eval') echo 'checked'; ?> /><?php echo __("Allow eval (Not recommended)",'wpinfecscan'); ?>
                        <br>
					
					</td>
                </tr>
            
			<tr><td colspan="4"><hr></td></tr>
			
                <tr valign="top">
                    <th scope="row"><?php echo __("Destination settings for connections: connect-src",'wpinfecscan'); ?></th>
                    <td><?php echo __("Restricts destination URLs for communications performed by JavaScript at runtime (fetch / XHR / Beacon / WebSocket / EventSource, etc.), helping to prevent information leakage via external communications and the retrieval of malicious data from external servers.",'wpinfecscan'); ?></td>
                    <td><b><?php echo __("Settings for destinations allowed by the browser for communication",'wpinfecscan'); ?></b>
                        <br>
                        <input type="radio" id="set-connect-src" name="set-connect-src" value=""<?php if ($set_connect_src === '') echo 'checked'; ?> /><?php echo __("Do not set (uses the default-src setting)",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-connect-src" name="set-connect-src" value="*" <?php if ($set_connect_src === '*') echo 'checked'; ?> /><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-connect-src" name="set-connect-src" value="self" <?php if ($set_connect_src === 'self') echo 'checked'; ?>/><?php echo __("Allow only sources on the same domain",'wpinfecscan'); ?>
                        <br>
						<div id="set-connect-src-setter">
                        <input type="radio" id="set-connect-src" name="set-connect-src" value="selfplus" <?php if ($set_connect_src === 'selfplus' || ! isset($_POST['csppost'])) echo 'checked'; ?> /><?php echo __("Allow sources on the same domain and specified external sources (Recommended)",'wpinfecscan'); ?>
						<br><br>&xdtri; <?php echo __("Check the domains to allow",'wpinfecscan'); ?>
                        <br><input type="checkbox" id="set-connect-src-d" name="set-connect-src-d[]" value="https://www.google-analytics.com" <?php if (isset($set_connect_src_d) && in_array('https://www.google-analytics.com', $set_connect_src_d)) echo 'checked'; ?> />https://www.google-analytics.com (Google Analytics)
                        <br><input type="checkbox" id="set-connect-src-d" name="set-connect-src-d[]" value="https://stats.g.doubleclick.net" <?php if (isset($set_connect_src_d) && in_array('https://stats.g.doubleclick.net', $set_connect_src_d)) echo 'checked'; ?> />https://stats.g.doubleclick.net (Google Analytics)
                        <br><input type="checkbox" id="set-connect-src-d" name="set-connect-src-d[]" value="https://www.googletagmanager.com" <?php if (isset($set_connect_src_d) && in_array('https://www.googletagmanager.com', $set_connect_src_d)) echo 'checked'; ?> />https://www.googletagmanager.com (Google Tag Manager)
                        <br><input type="checkbox" id="set-connect-src-d" name="set-connect-src-d[]" value="https://www.googleadservices.com" <?php if (isset($set_connect_src_d) && in_array('https://www.googleadservices.com', $set_connect_src_d)) echo 'checked'; ?> />https://www.googleadservices.com (Google Ads)
                        <br><input type="checkbox" id="set-connect-src-d" name="set-connect-src-d[]" value="https://pagead2.googlesyndication.com" <?php if (isset($set_connect_src_d) && in_array('https://pagead2.googlesyndication.com', $set_connect_src_d)) echo 'checked'; ?> />https://pagead2.googlesyndication.com (Google Ads)
                        <br><input type="checkbox" id="set-connect-src-d" name="set-connect-src-d[]" value="https://securepubads.g.doubleclick.net" <?php if (isset($set_connect_src_d) && in_array('https://securepubads.g.doubleclick.net', $set_connect_src_d)) echo 'checked'; ?> />https://securepubads.g.doubleclick.net (Google Ads)
                        <br><input type="checkbox" id="set-connect-src-d" name="set-connect-src-d[]" value="https://stats.wp.com" <?php if (isset($set_connect_src_d) && in_array('https://stats.wp.com', $set_connect_src_d)) echo 'checked'; ?> />https://stats.wp.com (Jetpack)
                        <br><input type="checkbox" id="set-connect-src-d" name="set-connect-src-d[]" value="https://wordpress.org" <?php if (isset($set_connect_src_d) && in_array('https://wordpress.org', $set_connect_src_d)) echo 'checked'; ?> />https://wordpress.org (<?php echo __("WordPress plugin/theme information, API communication",'wpinfecscan'); ?>)
                        <br><input type="checkbox" id="set-connect-src-d" name="set-connect-src-d[]" value="https://*.wordpress.org" <?php if (isset($set_connect_src_d) && in_array('https://*.wordpress.org', $set_connect_src_d)) echo 'checked'; ?> />https://*.wordpress.org　(<?php echo __("WordPress plugin/theme information, API communication",'wpinfecscan'); ?>)
                        <br><input type="checkbox" id="set-connect-src-d" name="set-connect-src-d[]" value="https://*.wordpress.com" <?php if (isset($set_connect_src_d) && in_array('https://*.wordpress.com', $set_connect_src_d)) echo 'checked'; ?> />https://*.wordpress.com (Jetpack)
                        <br>
                        <br><br> <?php echo __("✓To add more allowed domains, please add one per line in the text area",'wpinfecscan'); ?>
                        <textarea style="width:100%;height:70px;" name="set-connect-src-o" placeholder="https://*.allowdomain.com"><?php
						echo htmlspecialchars($set_connect_src_o, ENT_QUOTES, 'UTF-8');
						?></textarea>
						</div>
                        <br>
                    </td>
                </tr>
            
			<tr><td colspan="4"><hr></td></tr>
			
                <tr valign="top">
                    <th scope="row"><?php echo __("iframe source settings: frame-src / child-src",'wpinfecscan'); ?></th>
                    <td><?php echo __("This setting prevents loading malicious advertisements or embedded content by restricting which domains iframe elements (and their generated child content) embedded in a page can be loaded from.",'wpinfecscan'); ?></td>
                    <td><b><?php echo __("Settings for allowed iframe sources",'wpinfecscan'); ?></b>
                        <br>
                        <input type="radio" id="set-frame-src" name="set-frame-src" value="" <?php if ($set_frame_src === '') echo 'checked'; ?> /><?php echo __("Do not set (uses the default-src setting)",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-frame-src" name="set-frame-src" value="*" <?php if ($set_frame_src === '*') echo 'checked'; ?> /><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-frame-src" name="set-frame-src" value="self" <?php if ($set_frame_src === 'self') echo 'checked'; ?> /><?php echo __("Allow only sources on the same domain",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-frame-src" name="set-frame-src" value="selfplus" <?php if ($set_frame_src === 'selfplus' || ! isset($_POST['csppost'])) echo 'checked'; ?> /><?php echo __("Allow sources on the same domain and specified external sources (Recommended)",'wpinfecscan'); ?>
						<br>
						<div id="set-frame-src-setter">
						<br>&xdtri; <?php echo __("Check the domains to allow",'wpinfecscan'); ?>
                        <br><input type="checkbox" id="set-frame-src-d" name="set-frame-src-d[]" value="https://www.youtube.com" <?php if (isset($set_frame_src_d) && in_array('https://www.youtube.com', $set_frame_src_d)) echo 'checked'; ?> />https://www.youtube.com (YouTube)
                        <br><input type="checkbox" id="set-frame-src-d" name="set-frame-src-d[]" value="https://www.youtube-nocookie.com" <?php if (isset($set_frame_src_d) && in_array('https://www.youtube-nocookie.com', $set_frame_src_d)) echo 'checked'; ?> />https://www.youtube-nocookie.com (YouTube)
                        <br><input type="checkbox" id="set-frame-src-d" name="set-frame-src-d[]" value="https://*.google.com" <?php if (isset($set_frame_src_d) && in_array('https://*.google.com', $set_frame_src_d)) echo 'checked'; ?> />https://*.google.com (<?php echo __("All Google services",'wpinfecscan'); ?>)
                        <br><input type="checkbox" id="set-frame-src-d" name="set-frame-src-d[]" value="https://securepubads.g.doubleclick.net" <?php if (isset($set_frame_src_d) && in_array('https://securepubads.g.doubleclick.net', $set_frame_src_d)) echo 'checked'; ?> />https://securepubads.g.doubleclick.net (Google Ads)
						<br><br> <?php echo __("✓To add more allowed domains, please add one per line in the text area",'wpinfecscan'); ?>
                        <textarea style="width:100%;height:70px;" name="set-frame-src-o" placeholder="https://*.allowdomain.com"><?php
						echo htmlspecialchars($set_frame_src_o, ENT_QUOTES, 'UTF-8');
						?></textarea>
						</div>
                        <br>
                    </td>
                </tr>
            
			<tr><td colspan="4"><hr></td></tr>
			
                <tr valign="top">
                    <th scope="row"><?php echo __("Stylesheet (CSS) source settings: style-src",'wpinfecscan'); ?></th>
                    <td><?php echo __("This CSP directive restricts which domains and formats CSS applied to a page (external CSS, inline CSS, style attributes, etc.) can be loaded from, helping to prevent information leakage or XSS via abused styles.",'wpinfecscan'); ?></td>
                    <td><b><?php echo __("Settings for allowed stylesheet (CSS) sources",'wpinfecscan'); ?></b>
                        <br>
                        <input type="radio" id="set-style-src" name="set-style-src" value="" <?php if ($set_style_src === '') echo 'checked'; ?> /><?php echo __("Do not set (uses the default-src setting)",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-style-src" name="set-style-src" value="*" <?php if ($set_style_src === '*') echo 'checked'; ?> /><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-style-src" name="set-style-src" value="self" <?php if ($set_style_src === 'self') echo 'checked'; ?> /><?php echo __("Allow only sources on the same domain",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-style-src" name="set-style-src" value="selfplus" <?php if ($set_style_src === 'selfplus' || ! isset($_POST['csppost'])) echo 'checked'; ?> /><?php echo __("Allow sources on the same domain and specified external sources (Recommended)",'wpinfecscan'); ?>
						<br>
						<div id="set-style-src-setter">
						<br>&xdtri; <?php echo __("Check the domains to allow",'wpinfecscan'); ?>
                        <br><input type="checkbox" id="set-style-src-d" name="set-style-src-d[]" value="https://fonts.googleapis.com" <?php if (isset($set_style_src_d) && in_array('https://fonts.googleapis.com', $set_style_src_d)) echo 'checked'; ?> />https://fonts.googleapis.com (Google Fonts)
                        <br><input type="checkbox" id="set-style-src-d" name="set-style-src-d[]" value="https://fonts.gstatic.com" <?php if (isset($set_style_src_d) && in_array('https://fonts.gstatic.com', $set_style_src_d)) echo 'checked'; ?> />https://fonts.gstatic.com (Google Fonts)
						<br><input type="checkbox" id="set-style-src-d" name="set-style-src-d[]" value="https://www.gstatic.com/" <?php if (isset($set_style_src_d) && in_array('https://www.gstatic.com/', $set_style_src_d)) echo 'checked'; ?> />https://www.gstatic.com/ (Google Chart)
						<br><br> <?php echo __("✓To add more allowed domains, please add one per line in the text area",'wpinfecscan'); ?>
                        <textarea style="width:100%;height:70px;" name="set-style-src-o" placeholder="https://*.allowdomain.com"><?php
						echo htmlspecialchars($set_style_src_o, ENT_QUOTES, 'UTF-8');
						?></textarea>
						</div>
                        <br>
                    </td>
                </tr>
				
				<tr valign="top">
                    <th scope="row"></th>
                    <td><?php echo __("Control of inline styles",'wpinfecscan'); ?></td>
                    <td>
                        <input type="radio" id="set-style-src-i" name="set-style-src-i" value="" <?php if ($set_style_src_i === '') echo 'checked'; ?> /><?php echo __("Do not set",'wpinfecscan'); ?>
						<br>
                        <input type="radio" id="set-style-src-i" name="set-style-src-i" value="unsafe-inline" <?php if ($set_style_src_i === 'unsafe-inline' || ! isset($_POST['csppost']) ) echo 'checked'; ?>/><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
					
					</td>
                </tr>
            
			<tr><td colspan="4"><hr></td></tr>
			
                <tr valign="top">
                    <th scope="row"><?php echo __("Restrictions on use of the base tag: base-uri",'wpinfecscan'); ?></th>
                    <td><?php echo __("This CSP setting prevents attacks that redirect relative URLs to external sites or send information externally by restricting the base URL that can be specified with the HTML base tag.",'wpinfecscan'); ?></td>
                    <td>
					<input type="radio" id="set-base-uri" name="set-base-uri" value="" <?php if ($set_base_uri === '' || ! isset($_POST['csppost'])) echo 'checked'; ?> /><?php echo __("Do not set",'wpinfecscan'); ?>
						<br>
					<input type="radio" id="set-base-uri" name="set-base-uri" value="self" <?php if ($set_base_uri === 'self') echo 'checked'; ?> /><?php echo __("Same domain only",'wpinfecscan'); ?>
                        <br>
					<input type="radio" id="set-base-uri" name="set-base-uri" value="none" <?php if ($set_base_uri === 'none') echo 'checked'; ?> /><?php echo __("Disallow",'wpinfecscan'); ?>
                        <br>
					</td>
                </tr>
            
			<tr><td colspan="4"><hr></td></tr>
			
                <tr valign="top">
                    <th scope="row"><?php echo __("Form submission destination settings: form-action",'wpinfecscan'); ?></th>
                    <td><?php echo __("This CSP setting prevents attacks where form submission destinations are changed to unauthorized external sites through XSS or tampering, resulting in stolen input data, by restricting the URLs to which HTML forms (form tags) can submit data.",'wpinfecscan'); ?></td>
                    <td>
					<b><?php echo __("Settings for destinations to which form tags can submit data",'wpinfecscan'); ?></b>
                        <br>
                        <input type="radio" id="set-form-action" name="set-form-action" value="" <?php if ($set_form_action === '' || ! isset($_POST['csppost'])) echo 'checked'; ?> /><?php echo __("Do not set (uses the default-src setting)",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-form-action" name="set-form-action" value="*" <?php if ($set_form_action === '*') echo 'checked'; ?> /><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-form-action" name="set-form-action" value="self" <?php if ($set_form_action === 'self') echo 'checked'; ?> /><?php echo __("Same domain only",'wpinfecscan'); ?>
						<br>
                        <input type="radio" id="set-form-action" name="set-form-action" value="selfplus" <?php if ($set_form_action === 'selfplus') echo 'checked'; ?> /><?php echo __("Allow your own domain and add additional allowed domains",'wpinfecscan'); ?>
                        <br>
						<div id="set-form-action-setter">
						<br>
                        <?php echo __("✓To add allowed domains, please add one per line in the text area",'wpinfecscan'); ?>
                        <textarea style="width:100%;height:70px;" name="set-form-action-o" placeholder="https://*.allowdomain.com"><?php
						echo htmlspecialchars($set_form_action_o, ENT_QUOTES, 'UTF-8');
						?></textarea>
						</div>
                        <br>
					</td>
                </tr>
				
			<tr><td colspan="4"><hr></td></tr>
			
                <tr valign="top">
                    <th scope="row"><?php echo __("Image source settings: img-src",'wpinfecscan'); ?></th>
                    <td><?php echo __("img-src is a setting that restricts image loading sources to specific domains, preventing information leakage (tracking) via unauthorized external images and malicious resource loading through XSS attacks.",'wpinfecscan'); ?></td>
                    <td>
					<b><?php echo __("Settings for allowed image loading sources",'wpinfecscan'); ?></b>
                        <br>
                        <input type="radio" id="set-img-src" name="set-img-src" value="" <?php if ($set_img_src === '') echo 'checked'; ?> /><?php echo __("Do not set (uses the default-src setting)",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-img-src" name="set-img-src" value="*" <?php if ($set_img_src === '*' || ! isset($_POST['csppost'])) echo 'checked'; ?> /><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-img-src" name="set-img-src" value="self" <?php if ($set_img_src === 'self') echo 'checked'; ?> /><?php echo __("Same domain only",'wpinfecscan'); ?>
						<br>
                        <input type="radio" id="set-img-src" name="set-img-src" value="selfplus" <?php if ($set_img_src === 'selfplus') echo 'checked'; ?> /><?php echo __("Allow your own domain and add additional allowed domains",'wpinfecscan'); ?>
                        <br>
						<div id="set-img-src-setter">
						<br>
                        <?php echo __("✓To add allowed domains, please add one per line in the text area",'wpinfecscan'); ?>
                        <textarea style="width:100%;height:70px;" name="set-img-src-o" placeholder="https://*.allowdomain.com"><?php
						echo htmlspecialchars($set_img_src_o, ENT_QUOTES, 'UTF-8');
						?></textarea>
						</div>
						
                        <br>
					
					</td>
                </tr>
				
				<tr valign="top">
                    <th scope="row"></th>
                    <td><?php echo __("Allow images in the data: format",'wpinfecscan'); ?></td>
                    <td>
                        <input type="radio" id="set-img-src-i" name="set-img-src-i" value="" <?php if ($set_img_src_i === '') echo 'checked'; ?> /><?php echo __("Do not set",'wpinfecscan'); ?>
						<br>
                        <input type="radio" id="set-img-src-i" name="set-img-src-i" value="data:" <?php if ($set_img_src_i === 'data:' || ! isset($_POST['csppost']) ) echo 'checked'; ?>/><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
					
					</td>
                </tr>
				
				<tr><td colspan="4"><hr></td></tr>
			
                <tr valign="top">
                    <th scope="row"><?php echo __("Font source settings: font-src",'wpinfecscan'); ?></th>
                    <td><?php echo __("This CSP directive restricts which domains and formats Fonts applied to a page. Prevents tracking and information leaks caused by font loading.",'wpinfecscan'); ?></td>
                    <td><b><?php echo __("Settings for allowed Font sources",'wpinfecscan'); ?></b>
                        <br>
                        <input type="radio" id="set-font-src" name="set-font-src" value="" <?php if ($set_font_src === '') echo 'checked'; ?> /><?php echo __("Do not set (uses the default-src setting)",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-font-src" name="set-font-src" value="*" <?php if ($set_font_src === '*') echo 'checked'; ?> /><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-font-src" name="set-font-src" value="self" <?php if ($set_font_src === 'self') echo 'checked'; ?> /><?php echo __("Allow only sources on the same domain",'wpinfecscan'); ?>
                        <br>
                        <input type="radio" id="set-font-src" name="set-font-src" value="selfplus" <?php if ($set_font_src === 'selfplus' || ! isset($_POST['csppost'])) echo 'checked'; ?> /><?php echo __("Allow sources on the same domain and specified external sources (Recommended)",'wpinfecscan'); ?>
						<br>
						<div id="set-font-src-setter">
						<br>&xdtri; <?php echo __("Check the domains to allow",'wpinfecscan'); ?>
                        <br><input type="checkbox" id="set-font-src-d" name="set-font-src-d[]" value="https://fonts.googleapis.com" <?php if (isset($set_font_src_d) && in_array('https://fonts.googleapis.com', $set_font_src_d)) echo 'checked'; ?> />https://fonts.googleapis.com (Google Fonts)
                        <br><input type="checkbox" id="set-font-src-d" name="set-font-src-d[]" value="https://fonts.gstatic.com" <?php if (isset($set_font_src_d) && in_array('https://fonts.gstatic.com', $set_font_src_d)) echo 'checked'; ?> />https://fonts.gstatic.com (Google Fonts)
						<br><br> <?php echo __("✓To add more allowed domains, please add one per line in the text area",'wpinfecscan'); ?>
                        <textarea style="width:100%;height:70px;" name="set-font-src-o" placeholder="https://*.allowdomain.com"><?php
						echo htmlspecialchars($set_font_src_o, ENT_QUOTES, 'UTF-8');
						?></textarea>
						</div>
                        <br>
                    </td>
                </tr>
				
				<tr valign="top">
                    <th scope="row"></th>
                    <td><?php echo __("Allow font load in the data: format",'wpinfecscan'); ?></td>
                    <td>
                        <input type="radio" id="set-font-src-i" name="set-font-src-i" value="" <?php if ($set_font_src_i === '') echo 'checked'; ?> /><?php echo __("Do not set",'wpinfecscan'); ?>
						<br>
                        <input type="radio" id="set-font-src-i" name="set-font-src-i" value="data:" <?php if ($set_font_src_i === 'data:' || ! isset($_POST['csppost']) ) echo 'checked'; ?>/><?php echo __("Allow all",'wpinfecscan'); ?>
                        <br>
					
					</td>
                </tr>
				
            </table>
			<input type="hidden" name="settingname" value="csp"/>
			<input type="hidden" name="csppost" value="csp"/>
            <?php submit_button(); ?>

        </form>
    </div>
</div>

<script>

function showsetters(){
	var selectedValue = jQuery('input[name="set-default-src"]:checked').val();
	if(selectedValue == 'selfplus') {
		jQuery("#set-default-src-setter").show();
	}else{
		jQuery("#set-default-src-setter").hide()
	}

	selectedValue = jQuery('input[name="set-script-src"]:checked').val();
	if(selectedValue == 'selfplus') {
		jQuery("#set-script-src-setter").show();
	}else{
		jQuery("#set-script-src-setter").hide()
	}

	selectedValue = jQuery('input[name="set-connect-src"]:checked').val();
	if(selectedValue == 'selfplus') {
		jQuery("#set-connect-src-setter").show();
	}else{
		jQuery("#set-connect-src-setter").hide()
	}

	selectedValue = jQuery('input[name="set-frame-src"]:checked').val();
	if(selectedValue == 'selfplus') {
		jQuery("#set-frame-src-setter").show();
	}else{
		jQuery("#set-frame-src-setter").hide()
	}

	selectedValue = jQuery('input[name="set-style-src"]:checked').val();
	if(selectedValue == 'selfplus') {
		jQuery("#set-style-src-setter").show();
	}else{
		jQuery("#set-style-src-setter").hide()
	}

	selectedValue = jQuery('input[name="set-form-action"]:checked').val();
	if(selectedValue == 'selfplus') {
		jQuery("#set-form-action-setter").show();
	}else{
		jQuery("#set-form-action-setter").hide()
	}

	selectedValue = jQuery('input[name="set-img-src"]:checked').val();
	if(selectedValue == 'selfplus') {
		jQuery("#set-img-src-setter").show();
	}else{
		jQuery("#set-img-src-setter").hide()
	}
	
	selectedValue = jQuery('input[name="set-font-src"]:checked').val();
	if(selectedValue == 'selfplus') {
		jQuery("#set-font-src-setter").show();
	}else{
		jQuery("#set-font-src-setter").hide()
	}

}

setInterval(function () {
    showsetters();
}, 1000);
</script>