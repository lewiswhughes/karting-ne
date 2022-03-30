<h2>Help, Hooks, Filters & Shortcodes</h2>
<hr />
<ul class="gdpr-disable-posts-nav moove-clearfix">
	<li></li>
    <li><a href="#gdpr_cbm_faq" class="gdpr-help-tab-toggle active">FAQ</a></li>
    <li><a href="#gdpr_cbm_dh" class="gdpr-help-tab-toggle">Default Hooks</a></li>
    <li><a href="#gdpr_cbm_ph" class="gdpr-help-tab-toggle">Premium Hooks</a></li>
    <li><a href="#gdpr_cbm_ps" class="gdpr-help-tab-toggle">Premium Shortcodes</a></li>
</ul>

<div class="gdpr-help-content-cnt">
	<div id="gdpr_cbm_faq" class="gdpr-help-content-block help-block-open">
		<div class="gdpr-faq-toggle gdpr-faq-open">
			<div class="gdpr-faq-accordion-header">
				<h3>How do I setup your plugin?</h3>
			</div>
			<div class="gdpr-faq-accordion-content">
				<p>You can setup the plugin in the WordPress CMS -> Settings -> GDPR Cookie. In the general settings, you can setup the branding, and other elements.</p>
				<p>To add Google Analytics, you can enable the “3rd Party Cookies” tab but selecting the “Turn” radio value to “ON”. At the bottom of the “3rd Party Cookies” tab you’ll find 3 sections to add scripts – choose the section that is appropriate for your script.</p>
				<p>For Google Analytics, we recommend using the ‘Footer’ section.</p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>How can I link to the pop-up settings screen?</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p>You can use the following link to display the modal window:</p>
				<p>[Relative Path – RECOMMENDED]</p>
				<code>/#gdpr_cookie_modal</code>

				<p>[Absolute Path]</p>
				<code><?php echo home_url(); ?>/#gdpr_cookie_modal</code><br /><br />
				<code><?php echo home_url(); ?>/your-internal-page/#gdpr_cookie_modal</code>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Pasted code is not visible when view-source page is viewed.</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p>Our plugin loads the script with Javascript, and that’s why you can’t find it in the view-source page. You can use the developer console in Chrome browser (Inspect Element feature) and find the scripts.</p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Can I use custom code or hooks with your plugin?</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p>Yes. We have implemented hooks that allow you to implement custom scripts, for some examples see the list of pre-defined hooks here: <a href="#gdpr_cbm_dh" class="gdpr-help-tab-toggle">Default Hooks</a></p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Does the plugin support subdomains?</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p>Unfortunately not, subdomains are treated as separate domains by browsers and we’re unable to change the cookies stored by another domain. If your multisite setup use subdomain version, each subsite will be recognised as a separate domain by the browser and will create cookies for each subdomain.</p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Does this plugin block all cookies?</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p>No. This plugin only restricts cookies for scripts that you have setup in the Settings. If you want to block all cookies, you have to add all scripts that use cookies into the Settings of this plugin.</p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Once I add scripts to this plugin, should I delete them from the website’s code?</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p>Yes. Once you setup the plugin, you should delete the scripts you uploaded to the plugin from your website’s code to ensure that your scripts are not loaded twice.</p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->
		
		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Does this plugin stop all cookies from being stored?</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p>This plugin is just a template and needs to be setup by your developer in order to work properly. Once setup fully, it will prevent scripts that store cookies from being loaded on users computers until consent is given.</p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Does this plugin guarantee that I will comply with GDPR law?</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p>Unfortunately no. This plugin is just a template and needs to be setup by your developer in order to work properly.</p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->		
	</div>
	<!-- #gdpr_cbm_faq  -->

	<div id="gdpr_cbm_dh" class="gdpr-help-content-block">
		<p>Below the hooks & custom scripts included in the GDPR Cookie Compliance plugin.</p>
		<p><strong>Note: Some of them require some development work on your end to be extended or modified properly! These are just examples.</strong></p>

		<div class="gdpr-faq-toggle gdpr-faq-open">
			<div class="gdpr-faq-accordion-header">
				<h3>HOOK to GDPR custom 3RD-PARTY script by php – HEAD</h3>
			</div>
			<div class="gdpr-faq-accordion-content">
				<?php ob_start(); ?>
				add_action('moove_gdpr_third_party_header_assets','moove_gdpr_third_party_header_assets');
				function moove_gdpr_third_party_header_assets( $scripts ) {
					$scripts .= '<script>console.log("third-party-head");</script>';
					return $scripts;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>HOOK to GDPR custom 3RD-PARTY script by php – BODY</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('moove_gdpr_third_party_body_assets','moove_gdpr_third_party_body_assets');
				function moove_gdpr_third_party_body_assets( $scripts ) {
					$scripts .= '<script>console.log("third-party-body");</script>';
					return $scripts;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>HOOK to GDPR custom 3RD-PARTY script by php – FOOTER</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('moove_gdpr_third_party_footer_assets','moove_gdpr_third_party_footer_assets');
				function moove_gdpr_third_party_footer_assets( $scripts ) {
					$scripts .= '<script>console.log("third-party-footer");</script>';
					return $scripts;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>HOOK to GDPR custom ADVANCED-PARTY script by php – HEAD</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('moove_gdpr_advanced_cookies_header_assets','moove_gdpr_advanced_cookies_header_assets');
				function moove_gdpr_advanced_cookies_header_assets( $scripts ) {
					$scripts .= '<script>console.log("advanced-head");</script>';
					return $scripts;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>HOOK to GDPR custom ADVANCED-PARTY script by php – BODY</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('moove_gdpr_advanced_cookies_body_assets','moove_gdpr_advanced_cookies_body_assets');
				function moove_gdpr_advanced_cookies_body_assets( $scripts ) {
					$scripts .= '<script>console.log("advanced-body");</script>';
					return $scripts;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>HOOK to GDPR custom ADVANCED-PARTY script by php – FOOTER</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('moove_gdpr_advanced_cookies_footer_assets','moove_gdpr_advanced_cookies_footer_assets');
				function moove_gdpr_advanced_cookies_footer_assets( $scripts ) {
					$scripts .= '<script>console.log("advanced-footer");</script>';
					return $scripts;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Enable Force Reload</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action( 'gdpr_force_reload', '__return_true' );
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->
		
		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>PHP Cookie checker</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				if ( function_exists( 'gdpr_cookie_is_accepted' ) ) {
				   if ( gdpr_cookie_is_accepted( 'thirdparty' ) ) {
				     echo "GDPR third party ENABLED content";
				   } else {
				     echo "GDPR third party RESTRICTED content";
				   }
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Extend Styles</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('moove_gdpr_inline_styles','gdpr_cookie_css_extension',10,3);
				function gdpr_cookie_css_extension( $styles, $primary, $secondary ) {
					$styles .= '#main-header { z-index: 999; }';
					$styles .= '#top-header { z-index: 1000 }';
					$styles .= '.lity {z-index: 99999999;}';
					return $styles;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->		

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Disable Monster Insights based on cookie selected</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action( 'init', 'toggle_monster_insights_based_on_moove' );
				function toggle_monster_insights_based_on_moove() {
				    if ( function_exists( gdpr_cookie_is_accepted ) && function_exists('monsterinsights_get_ua')) {
				      if ( gdpr_cookie_is_accepted('thirdparty') ) {
				            setCookie( 'ga-disable-'.monsterinsights_get_ua(), 'false' );
					} else {
					     setCookie( 'ga-disable-'.monsterinsights_get_ua(), 'true' );
					}
				    }
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->		

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Define CDN URL for Lity library</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action( 'gdpr_cdn_url', 'gdpr_cdn_url', 10, 1 );
				function gdpr_cdn_url( $plugin_url ) {
					$cdn_url = 'https://yourcdnurl.com';
					return str_replace( trailingslashit( site_url() ) , trailingslashit( $cdn_url ), $plugin_url );
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Read cookie values with JavaScript</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action( 'wp_footer', 'gdpr_js_extension', 1000 );
				function gdpr_js_extension() {
				  <script>
				      jQuery(document).ready(function(){
				        var cookies_object = jQuery(this).moove_gdpr_read_cookies();
				        if ( typeof cookies_object === 'object' ) {
				            console.log(cookies_object);
				           				            
				        }
				      });
				  </script>
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Compatibility with Pixel Your Site plugin</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_filter( 'pys_disable_by_gdpr', 'gdpr_cookie_compliance_pys' );
				function gdpr_cookie_compliance_pys() {
					
					if ( function_exists( 'gdpr_cookie_is_accepted' ) ) :
						
						$disable_pys = gdpr_cookie_is_accepted( 'thirdparty' ) ? false : true;
						return $disable_pys;
					endif;
					
					return true;
				}
				
				add_action( 'gdpr_force_reload', '__return_true' );
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Hook for WooCommerce Facebook Pixel plugin</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_filter('facebook_for_woocommerce_integration_pixel_enabled', 'gdpr_cookie_facebook_wc', 20);
				function gdpr_cookie_facebook_wc() {
					$enable_fb_wc = true;
					if ( function_exists( 'gdpr_cookie_is_accepted' ) ) :
						$enable_fb_wc = gdpr_cookie_is_accepted( 'thirdparty' );
					endif;
					return $enable_fb_wc;
				}
				add_action( 'gdpr_force_reload', '__return_true' );
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Disable Script Caching</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_filter('gdpr_cookie_script_cache','gdpr_prevent_script_cache');
				function gdpr_prevent_script_cache() {
					return array();
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3>Custom Tracking Code on language sites (WPML, qTranslate, WP Multilang, Polylang)</h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				// The SCRIPT caching should be disabled if you have separate scripts / site!
				add_filter('gdpr_cookie_script_cache','gdpr_prevent_script_cache');
				function gdpr_prevent_script_cache() {
				  return array();
				}
				// Force reload required because of PHP functions
				add_action( 'gdpr_force_reload', '__return_true' );

				// Custom Scripts based on front-end language
				add_action('wp_head', 'my_gdpr_script_inject' );
				function my_gdpr_script_inject() {
					// PHP Cookie checker, replace the 'thirdparty' to 'advanced' if you need to load the scripts for "Advanced cookies"
					if ( function_exists( 'gdpr_cookie_is_accepted' ) && gdpr_cookie_is_accepted( 'thirdparty' ) ) :
						$gdpr_default_content 	= new Moove_GDPR_Content();
				        $wpml_lang      		= $gdpr_default_content->moove_gdpr_get_wpml_lang();
						// Variable named $wpml_lang returns the localization string
						if ( $wpml_lang === 'fr' ) : 
							// Custom Script to FR site only
							echo "<script>console.log('French - Custom Script Added');</script>";
						elseif( $wpml_lang === 'en' ) :
							// Custom Script to EN site only
							echo "<script>console.log('English - Custom Script Added');</script>";
						endif;
				  	endif;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo uniqid( strtotime('now') ); ?>"><?php echo $code; ?></textarea>
				<div class="gdpr-code">
					
				</div>
				<!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	

	</div>
	<!-- #gdpr_cbm_faq  -->

	<div id="gdpr_cbm_ph" class="gdpr-help-content-block">
		<?php do_action('gdpr_tab_cbm_ph'); ?>
	</div>
	<!-- #gdpr_cbm_ph  -->

	<div id="gdpr_cbm_ps" class="gdpr-help-content-block">
		<?php do_action('gdpr_tab_cbm_ps'); ?>
	</div>
	<!-- #gdpr_cbm_ph  -->

</div>
<!--  .gdpr-help-content-cnt -->



<script type="text/javascript" src="<?php echo moove_gdpr_get_plugin_directory_url(); ?>/dist/scripts/codemirror.js"></script>
<script type="text/javascript">
    
    	CodeMirror.defineExtension("autoFormatRange", function (from, to) {
		    var cm = this;
		    var outer = cm.getMode(), text = cm.getRange(from, to).split("\n");
		    var state = CodeMirror.copyState(outer, cm.getTokenAt(from).state);
		    var tabSize = cm.getOption("tabSize");

		    var out = "", lines = 0, atSol = from.ch == 0;
		    function newline() {
		        out += "\n";
		        atSol = true;
		        ++lines;
		    }

		    for (var i = 0; i < text.length; ++i) {
		        var stream = new CodeMirror.StringStream(text[i], tabSize);
		        while (!stream.eol()) {
		            var inner = CodeMirror.innerMode(outer, state);
		            var style = outer.token(stream, state), cur = stream.current();
		            stream.start = stream.pos;
		            if (!atSol || /\S/.test(cur)) {
		                out += cur;
		                atSol = false;
		            }
		            if (!atSol && inner.mode.newlineAfterToken &&
		                inner.mode.newlineAfterToken(style, cur, stream.string.slice(stream.pos) || text[i+1] || "", inner.state))
		                newline();
		        }
		        if (!stream.pos && outer.blankLine) outer.blankLine(state);
		        if (!atSol) newline();
		    }

		    cm.operation(function () {
		        cm.replaceRange(out, from, to);
		        for (var cur = from.line + 1, end = from.line + lines; cur <= end; ++cur)
		            cm.indentLine(cur, "smart");
		    });
		});

		// Applies automatic mode-aware indentation to the specified range
		CodeMirror.defineExtension("autoIndentRange", function (from, to) {
		    var cmInstance = this;
		    this.operation(function () {
		        for (var i = from.line; i <= to.line; i++) {
		            cmInstance.indentLine(i, "smart");
		        }
		    });
		});
		function GDPR_CodeMirror() {
			jQuery('.gdpr-faq-accordion-content textarea').each(function(){
	            var element = jQuery(this).closest('.gdpr-faq-accordion-content').find('.gdpr-code')[0];
	            var id = jQuery(this).attr('id');
	            console.log(element);
	            jQuery(this).css({
	                'opacity'   : '0',
	                'height'    : '0',
	            });
	            var  editor = CodeMirror( element, {
	                mode: "javascript",
	                lineWrapping: true,
	                lineNumbers: false,
	                readOnly: true,
	                value: document.getElementById(id).value
	            });
	            var totalLines = editor.lineCount();  
				editor.autoFormatRange({line:0, ch:0}, {line:totalLines});

	        });
		}
		jQuery(document).ready(function(){
			GDPR_CodeMirror();
			jQuery('.gdpr-faq-toggle:not(.gdpr-faq-open)').find('.gdpr-faq-accordion-content').hide();
			jQuery('.gdpr-help-content-block:not(.help-block-open)').hide();
		});
		
    	
</script>
<style>
	.CodeMirror {
		height: auto;
		border: none !important;
	}
</style>