<?php
    /**
     * Opayo_Pi_Dropin_Payment_Fields
     */
    class Opayo_Pi_Dropin_Payment_Fields extends WC_Gateway_Opayo_Pi {

        public function __construct() {

            parent::__construct();

        }

        function fields() {
            
            // Allow for token checkbox    
            $display_tokenization = $this->supports( 'tokenization' ) && is_checkout() && $this->tokens == 'yes';

            // Set the pay button text
            if ( is_add_payment_method_page() ) {
                $pay_button_text = __( 'Add Card', 'woocommerce-gateway-sagepay-form' );
            } else {
                $pay_button_text = '';
            }

            // Checkout card fields
            echo '<div id="opayopi-payment-data">';

            if ( $this->description ) {
                echo apply_filters( 'wc_opayopi_description', wp_kses_post( $this->description ) );
            }

            // Add tokenization script
            if ( $display_tokenization && class_exists( 'WC_Payment_Token_CC' ) ) {
                // Add script to remove card fields if CVV required with tokens
                if( $this->cvv_script ) {
                    $this->cvv_script();
                } else {
                    $this->tokenization_script();
                }
                
                $this->saved_payment_methods();
            }
            
            // Use our own payment fields
            $this->sagepay_credit_card_form();

            if ( $display_tokenization && class_exists( 'WC_Payment_Token_CC' ) ) {
                $this->save_payment_method_checkbox();
            }

            echo '</div>';

        }

        /**
         * Credit Card Fields.
         *
         * Core credit card form which gateways can used if needed.
         */
        function sagepay_credit_card_form() {
            wp_enqueue_script( 'wc-credit-card-form' );

            $merchantSessionKeyArray  = WC()->session->get('merchantSessionKeyArray');

            $merchantSessionKey       = $merchantSessionKeyArray["merchantSessionKey"];
            $merchantSessionKeyExpiry = $merchantSessionKeyArray["expiry"];

?>
            <fieldset id = "opayopi-cc-form" class = "wc-payment-form">
                <div id="woocommerce-sp-container"></div>
                
<?php           
                do_action( 'woocommerce_credit_card_form_before', $this->id );

                $merchantSessionKey       = $merchantSessionKeyArray["merchantSessionKey"];
                $merchantSessionKeyExpiry = $merchantSessionKeyArray["expiry"];
?>
                <script type="text/javascript">

                    (function ( $ ) {

                        var merchantSessionKey       = '<?php echo $merchantSessionKey; ?>';
                        var merchantSessionKeyExpiry = '<?php echo $merchantSessionKeyExpiry; ?>';

                        console.log('merchantSessionKey', merchantSessionKey);
                        console.log('merchantSessionKeyExpiry', merchantSessionKeyExpiry);

                        if ( $( '#payment_method_opayopi' ).is( ':checked' ) ) {

                            const checkout = sagepayCheckout({
                                merchantSessionKey: merchantSessionKey,
                                containerSelector:  '#woocommerce-sp-container',
                                onTokenise: function(tokenisationResult) {

                                    if (tokenisationResult.success) {

                                        // Let's add some hidden fields for Opayo
                                        $( '#opayopi-cc-form' ).append( '<input type="hidden" name="opayopi-cardIdentifier" id="opayopi-cardIdentifier" value = "' + tokenisationResult.cardIdentifier + '" />' );
                                        $( '#opayopi-cc-form' ).append( '<input type="hidden" name="opayopi-merchantSessionKey" id="opayopi-merchantSessionKey" value = "' + merchantSessionKey + '" />' );

                                        $( 'form.checkout, form#add_payment_method, form#order_review' ).submit();
                                    
                                    } else {
                                    
                                        console.error('Tokenisation failed', tokenisationResult.error.errorMessage);
                                    
                                    }

                                }
                            });

                            $('#place_order').click(function(e) {
                                e.preventDefault();
                                checkout.tokenise();
                            });

                        }

                    }( jQuery ) );

                    var browserUserAgent = function () {
                        return (navigator.userAgent || null);
                    };

                    var browserLanguage = function () {
                        return (navigator.language || navigator.userLanguage || navigator.browserLanguage || navigator.systemLanguage || 'en-gb');
                    };

                    var browserColorDepth = function () {
                        var acceptedValues = [1,4,8,15,16,24,32,48];
                        if (screen.colorDepth || window.screen.colorDepth) {

                            colorDepth = (screen.colorDepth || window.screen.colorDepth);
                            var returnValue = acceptedValues.indexOf( colorDepth );

                            if( returnValue >= 0 ) {
                                return colorDepth;
                            }

                            // Fallback 
                            return 32;
                            
                        }
                        return 32;
                    };

                    var browserScreenHeight = function () {
                        if (window.screen.height) {
                            return new String(window.screen.height);
                        }
                        return null;
                    };

                    var browserScreenWidth = function () {
                        if (window.screen.width) {
                            return new String(window.screen.width);
                        }
                        return null;
                    };

                    var browserTZ = function () {
                        return new String(new Date().getTimezoneOffset());
                    };

                    var browserJavaEnabled = function () {
                        return (navigator.javaEnabled() || null);
                    };

                    var browserJavascriptEnabled = function () {
                        return (true);
                    };

                    var sageform = document.getElementById( "opayopi-cc-form" );

                    function createHiddenInput( form, name, value ) {

                        var input = document.createElement("input");
                        input.setAttribute( "type", "hidden" );
                        input.setAttribute( "name", name ); 
                        input.setAttribute( "value", value );
                        form.appendChild( input);

                    }

                    if ( sageform != null ) {

                        createHiddenInput( sageform, 'browserJavaEnabled', browserJavaEnabled() );
                        createHiddenInput( sageform, 'browserJavascriptEnabled', browserJavascriptEnabled() );
                        createHiddenInput( sageform, 'browserLanguage', browserLanguage() );
                        createHiddenInput( sageform, 'browserColorDepth', browserColorDepth() );
                        createHiddenInput( sageform, 'browserScreenHeight', browserScreenHeight() );
                        createHiddenInput( sageform, 'browserScreenWidth', browserScreenWidth() );
                        createHiddenInput( sageform, 'browserTZ', browserTZ() );
                        createHiddenInput( sageform, 'browserUserAgent', browserUserAgent() );

                    }
                
                </script>

<?php
                do_action( 'woocommerce_credit_card_form_after', $this->id ); 
?>
                <div class="clear"></div>
            </fieldset>

<?php

        }      

        /**
         * [get_icon description] Add selected card icons to payment method label, defaults to Visa/MC/Amex/Discover
         * @return [type] [description]
         */
        public function get_icon() {
            return WC_Sagepay_Common_Functions::get_icon( $this->cardtypes, $this->sagelink, $this->sagelogo, $this->id );
        }


    } // End class
