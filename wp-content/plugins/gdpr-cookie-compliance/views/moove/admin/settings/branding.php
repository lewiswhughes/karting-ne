<?php
    $gdpr_default_content = new Moove_GDPR_Content();
    $option_name    = $gdpr_default_content->moove_gdpr_get_option_name();
    $gdpr_options   = get_option( $option_name );
    $wpml_lang      = $gdpr_default_content->moove_gdpr_get_wpml_lang();
    $gdpr_options   = is_array( $gdpr_options ) ? $gdpr_options : array();
    if ( isset( $_POST ) && isset( $_POST['moove_gdpr_nonce'] ) ) :
        $nonce = sanitize_key( $_POST['moove_gdpr_nonce'] );
        if ( ! wp_verify_nonce( $nonce, 'moove_gdpr_nonce_field' ) ) :
            die( 'Security check' );
        else :
            if ( is_array( $_POST ) ) :
                $gdpr_options = get_option( $option_name );
                foreach ( $_POST as $form_key => $form_value ) :
                    if ( $form_key === 'moove_gdpr_info_bar_content' ) :
                        $value  = wpautop( wp_unslash( $form_value ) );
                        $gdpr_options[$form_key.$wpml_lang] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    elseif ( $form_key === 'moove_gdpr_modal_strictly_secondary_notice' . $wpml_lang ) :
                        $value  = wpautop( wp_unslash( $form_value ) );
                        $gdpr_options[$form_key] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    elseif ( $form_key !== 'moove_gdpr_floating_button_enable' && $form_key !== 'moove_gdpr_modal_powered_by_disable' ) :
                        $value  = sanitize_text_field( wp_unslash( $form_value ) );
                        $gdpr_options[$form_key] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    endif;
                endforeach;
            endif;
            do_action('gdpr_cookie_filter_settings');
            ?>
                <script>
                    jQuery('#moove-gdpr-setting-error-settings_updated').show();
                </script>
            <?php
        endif;
    endif;
?>
<form action="?page=moove-gdpr&amp;tab=branding" method="post" id="moove_gdpr_tab_branding_settings">
    <h2><?php _e('Branding','gdpr-cookie-compliance'); ?></h2>
    <hr />
    <?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
    <table class="form-table">
        <tbody>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_brand_colour"><?php _e('Brand Primary Colour','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <div class="iris-colorpicker-group-cnt">
                        <?php $color = isset( $gdpr_options['moove_gdpr_brand_colour'] ) && $gdpr_options['moove_gdpr_brand_colour'] ? $gdpr_options['moove_gdpr_brand_colour'] : '0C4DA2'; ?>
                        <input class="iris-colorpicker regular-text" name="moove_gdpr_brand_colour" value="<?php echo $color; ?>" style="background-color: <?php echo $color; ?>" type="text">
                        <span class="iris-selectbtn"><?php _e('Select','gdpr-cookie-compliance'); ?></span>
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_brand_secondary_colour"><?php _e('Brand Secondary Colour','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <div class="iris-colorpicker-group-cnt">
                        <?php $color =  isset( $gdpr_options['moove_gdpr_brand_secondary_colour'] ) && $gdpr_options['moove_gdpr_brand_secondary_colour'] ? $gdpr_options['moove_gdpr_brand_secondary_colour'] : '000000'; ?>
                        <input class="iris-colorpicker regular-text" name="moove_gdpr_brand_secondary_colour" value="<?php echo $color; ?>" style="background-color: <?php echo $color; ?>" >
                        <span class="iris-selectbtn"><?php _e('Select','gdpr-cookie-compliance'); ?></span>
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_company_logo"><?php _e('Cookie Settings Logo','gdpr-cookie-compliance'); ?></label>
                    <p class="description"><?php _e('Recommended size:','gdpr-cookie-compliance'); ?><br>130 x 50 <?php _e('pixels','gdpr-cookie-compliance'); ?></p>
                    <!--  .description -->
                </th>
                <td>
                    <?php
                        if ( function_exists( 'wp_enqueue_media' ) ) :
                            wp_enqueue_media();
                        else:
                            wp_enqueue_style('thickbox');
                            wp_enqueue_script('media-upload');
                            wp_enqueue_script('thickbox');
                        endif;
                    ?>
                    <?php
                    $plugin_dir = moove_gdpr_get_plugin_directory_url();
                    $image_url = isset( $gdpr_options['moove_gdpr_company_logo'] ) && $gdpr_options['moove_gdpr_company_logo'] ? $gdpr_options['moove_gdpr_company_logo'] : $plugin_dir.'dist/images/gdpr-logo.png';
                    ?>
                    <span class="moove_gdpr_company_logo_holder" style="background-image: url(<?php echo $image_url; ?>);"></span><br /><br />
                    <input class="regular-text code" type="text" name="moove_gdpr_company_logo" value="<?php echo $image_url; ?>" required> <br /><br />
                    <a href="#" class="button moove_gdpr_company_logo_upload">Upload Logo</a>
                    <script>
                        jQuery(document).ready(function($) {
                            $('.moove_gdpr_company_logo_upload').click(function(e) {
                                e.preventDefault();

                                var custom_uploader = wp.media({
                                    title: 'GDPR Modal - Company Logo',
                                    button: {
                                        text: 'Upload Logo'
                                    },
                                    multiple: false  // Set this to true to allow multiple files to be selected
                                })
                                .on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('.moove_gdpr_company_logo_holder').css('background-image', 'url('+attachment.url+')');
                                    $('input[name=moove_gdpr_company_logo]').val(attachment.url);

                                })
                                .open();
                            });
                        });
                    </script>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_logo_position"><?php _e('Logo Position','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_logo_position" type="radio" value="left" id="moove_gdpr_logo_position_left" <?php echo isset( $gdpr_options['moove_gdpr_logo_position'] ) ? ( $gdpr_options['moove_gdpr_logo_position'] === 'left'  ? 'checked' : '' ) : 'checked'; ?> class="on-off"> <label for="moove_gdpr_logo_position_left"><?php _e('Left','gdpr-cookie-compliance'); ?></label> 
                    <span class="separator"></span>

                    <input name="moove_gdpr_logo_position" type="radio" value="center" id="moove_gdpr_logo_position_center" <?php echo isset( $gdpr_options['moove_gdpr_logo_position'] ) ? ( $gdpr_options['moove_gdpr_logo_position'] === 'center'  ? 'checked' : '' ) : ''; ?> class="on-off"> <label for="moove_gdpr_logo_position_center"><?php _e('Center','gdpr-cookie-compliance'); ?></label> 
                    <span class="separator"></span>
                    
                    <input name="moove_gdpr_logo_position" type="radio" value="right" id="moove_gdpr_logo_position_right" <?php echo isset( $gdpr_options['moove_gdpr_logo_position'] ) ? ( $gdpr_options['moove_gdpr_logo_position'] === 'right'  ? 'checked' : '' ) : ''; ?> class="on-off"> <label for="moove_gdpr_logo_position_right"><?php _e('Right','gdpr-cookie-compliance'); ?></label>

                    <?php do_action('gdpr_cc_moove_gdpr_logo_position_settings'); ?>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_plugin_font_family"><?php _e('Choose font','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_plugin_font_type" type="radio" value="1" data-val="'Nunito', sans-serif" id="moove_gdpr_plugin_font_type_1" <?php echo isset( $gdpr_options['moove_gdpr_plugin_font_type'] ) ? ( $gdpr_options['moove_gdpr_plugin_font_type'] === '1'  ? 'checked' : '' ) : 'checked'; ?> class="on-off"> <label for="moove_gdpr_plugin_font_type_1"><?php _e('Default','gdpr-cookie-compliance'); ?></label> 
                    <span class="separator"></span>
                    <br /><br />

                    <input name="moove_gdpr_plugin_font_type" type="radio" value="2" data-val="inherit" id="moove_gdpr_plugin_font_type_2" <?php echo isset( $gdpr_options['moove_gdpr_plugin_font_type'] ) ? ( $gdpr_options['moove_gdpr_plugin_font_type'] === '2'  ? 'checked' : '' ) : ''; ?> class="on-off"> <label for="moove_gdpr_plugin_font_type_2"><?php _e('Inherit font-family from your WordPress theme','gdpr-cookie-compliance'); ?></label>
                    <span class="separator"></span>
                    <br /><br />

                    <input name="moove_gdpr_plugin_font_type" type="radio" value="3" data-val="" id="moove_gdpr_plugin_font_type_3" <?php echo isset( $gdpr_options['moove_gdpr_plugin_font_type'] ) ? ( $gdpr_options['moove_gdpr_plugin_font_type'] === '3'  ? 'checked' : '' ) : ''; ?> class="on-off"> <label for="moove_gdpr_plugin_font_type_3"><?php _e('Specify custom font','gdpr-cookie-compliance'); ?></label>
                    <span class="separator"></span>
                    <br /><br />
                    <?php 
                        $field_class = '';
                        if ( isset( $gdpr_options['moove_gdpr_plugin_font_type'] ) ) :
                            if (  $gdpr_options['moove_gdpr_plugin_font_type'] === '1' || $gdpr_options['moove_gdpr_plugin_font_type'] === '2' ) {
                                $field_class = 'moove-not-visible';
                            } 
                        endif;

                    ?>
                    <input name="moove_gdpr_plugin_font_family" type="text" id="moove_gdpr_plugin_font_family" value="<?php echo isset( $gdpr_options['moove_gdpr_plugin_font_family'] ) && $gdpr_options['moove_gdpr_plugin_font_family'] ? $gdpr_options['moove_gdpr_plugin_font_family'] : "'Nunito', sans-serif"; ?>" class="regular-text <?php echo $field_class; ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="moove_gdpr_cdn_url"><?php _e('CDN Base URL','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                   <input name="moove_gdpr_cdn_url" type="text" id="moove_gdpr_cdn_url" value="<?php echo isset( $gdpr_options['moove_gdpr_cdn_url'] ) && $gdpr_options['moove_gdpr_cdn_url'] ? $gdpr_options['moove_gdpr_cdn_url'] : ''; ?>" class="regular-text">
                   <p class="description"><strong>* <?php _e('Optional, leave it empty to use default domain</strong><br /> Enter your CDN root URL to enable CDN for GDPR Lity library files. The URL can be http, https or protocol-relative', 'gdpr-cookie-compliance'); ?> (e.g. //cdn.example.com/).</p>
                   <!--  .description -->
                </td>
            </tr>
            <?php do_action('gdpr_cc_general_modal_settings'); ?>


        </tbody>
    </table>

    <br />
    <hr />
    <br />
    <button type="submit" class="button button-primary"><?php _e('Save changes','gdpr-cookie-compliance'); ?></button>
    <?php do_action('gdpr_cc_general_buttons_settings'); ?>
</form>