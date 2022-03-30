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

                if ( isset( $_POST['moove_gdpr_modal_powered_by_disable'] ) ) :
                    $value  = intval( $_POST['moove_gdpr_modal_powered_by_disable'] );
                else :
                    $value  = 0;
                endif;

                if ( isset( $_POST['moove_gdpr_modal_powered_by_label' . $wpml_lang] ) ) :
                    if ( strlen( trim( $_POST['moove_gdpr_modal_powered_by_label' . $wpml_lang] ) ) === 0 ) :
                        $value  = 1;
                    else :
                        $value  = 0;
                    endif;
                endif;


                $gdpr_options['moove_gdpr_modal_powered_by_disable'] = $value;
                update_option( $option_name, $gdpr_options );
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
<form action="?page=moove-gdpr&amp;tab=general_settings" method="post" id="moove_gdpr_tab_general_settings">
    <h2><?php _e('Cookie Settings Screen - General Setup','gdpr-cookie-compliance'); ?></h2>
    <hr />
    <?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="moove_gdpr_plugin_layout"><?php _e('Choose your layout','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_plugin_layout" type="radio" value="v1" id="moove_gdpr_plugin_layout_v1" <?php echo isset( $gdpr_options['moove_gdpr_plugin_layout'] ) ? ( $gdpr_options['moove_gdpr_plugin_layout'] === 'v1'  ? 'checked' : '' ) : 'checked'; ?> class="on-off"> <label for="moove_gdpr_plugin_layout_v1"><?php _e('Tabs layout','gdpr-cookie-compliance'); ?></label> 
                    <span class="separator"></span>

                    <input name="moove_gdpr_plugin_layout" type="radio" value="v2" id="moove_gdpr_plugin_layout_v2" <?php echo isset( $gdpr_options['moove_gdpr_plugin_layout'] ) ? ( $gdpr_options['moove_gdpr_plugin_layout'] === 'v2'  ? 'checked' : '' ) : ''; ?> class="on-off"> <label for="moove_gdpr_plugin_layout_v2"><?php _e('One page layout','gdpr-cookie-compliance'); ?></label>

                    <?php do_action('gdpr_cc_moove_gdpr_plugin_layout_settings'); ?>

                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_modal_save_button_label"><?php _e('Save Settings - Button Label','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_modal_save_button_label<?php echo $wpml_lang; ?>" type="text" id="moove_gdpr_modal_save_button_label" value="<?php echo isset( $gdpr_options['moove_gdpr_modal_save_button_label'.$wpml_lang] ) && $gdpr_options['moove_gdpr_modal_save_button_label'.$wpml_lang] ? $gdpr_options['moove_gdpr_modal_save_button_label'.$wpml_lang] : __('Save Changes','gdpr-cookie-compliance'); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_modal_allow_button_label"><?php _e('Enable All - Button Label','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_modal_allow_button_label<?php echo $wpml_lang; ?>" type="text" id="moove_gdpr_modal_allow_button_label" value="<?php echo isset( $gdpr_options['moove_gdpr_modal_allow_button_label'.$wpml_lang] ) && $gdpr_options['moove_gdpr_modal_allow_button_label'.$wpml_lang] ? $gdpr_options['moove_gdpr_modal_allow_button_label'.$wpml_lang] : __('Enable All','gdpr-cookie-compliance'); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_modal_enabled_checkbox_label"><?php _e('Checkbox Labels','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_modal_enabled_checkbox_label<?php echo $wpml_lang; ?>" type="text" id="moove_gdpr_modal_enabled_checkbox_label" value="<?php echo isset( $gdpr_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ) && $gdpr_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ? $gdpr_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] : __('Enabled','gdpr-cookie-compliance'); ?>" class="regular-text"><br />
                    <input name="moove_gdpr_modal_disabled_checkbox_label<?php echo $wpml_lang; ?>" type="text" id="moove_gdpr_modal_disabled_checkbox_label" value="<?php echo isset( $gdpr_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ) && $gdpr_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ? $gdpr_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] : __('Disabled','gdpr-cookie-compliance'); ?>" class="regular-text">
                </td>

            </tr>

            <tr>
                <th scope="row">
                    <label><?php _e('Powered by GDPR','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <span class="powered-by-label">
                        <label for="">Default label:</label>
                        <input name="moove_gdpr_modal_powered_by_label<?php echo $wpml_lang; ?>" type="text" id="moove_gdpr_modal_powered_by_label" value="<?php echo isset( $gdpr_options['moove_gdpr_modal_powered_by_label'.$wpml_lang] ) ? $gdpr_options['moove_gdpr_modal_powered_by_label'.$wpml_lang] : 'Powered by'; ?>" class="regular-text">
                    </span>
                    
                    <input name="moove_gdpr_modal_powered_by_disable" type="hidden" <?php echo isset( $gdpr_options['moove_gdpr_modal_powered_by_disable'] ) ? ( intval( $gdpr_options['moove_gdpr_modal_powered_by_disable'] ) === 1  ? 'checked' : '' ) : ''; ?> id="moove_gdpr_modal_powered_by_disable" value="<?php echo isset( $gdpr_options['moove_gdpr_modal_powered_by_disable'] ) ? ( intval( $gdpr_options['moove_gdpr_modal_powered_by_disable'] ) === 1  ? '1' : '0' ) : '0'; ?>">
                 
                    </fieldset>
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