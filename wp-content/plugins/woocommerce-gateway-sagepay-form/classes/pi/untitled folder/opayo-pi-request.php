<?php

    /**
     * WC_Gateway_Opayo_Pi_Request class.
     *
     * @extends WC_Gateway_Opayo_Pi
     */
    class WC_Gateway_Opayo_Pi_Request extends WC_Gateway_Opayo_Pi {

        /**
         * __construct function.
         *
         * @access public
         * @return void
         */
        public function __construct() {
            parent::__construct();

        }

        /**
         * [get_merchantSessionKey description]
         * @return [type] [description]
         */
        function get_merchantSessionKey() {

            $Basic_authentication_key = base64_encode( $this->Integration_Key . ':' . $this->Integration_Password );
            $data = array( 
                        "vendorName" => $this->vendor 
                    );

            $merchantSessionKeyArray  = $this->remote_post( $data, $this->merchant_session_keys_url, NULL, 'Basic' );

            $iso_date = (new DateTime())->format('c');

            return $merchantSessionKeyArray;

        }

        /**
         * [get_cardIdentifier description]
         * @param  [type] $merchantSessionKey [description]
         * @return [type]                     [description]
         */
        function get_cardIdentifier( $card_details = NULL ) {

            if( !$card_details ) {
                return;
            }

            $merchantSessionKey = $card_details['merchantSessionKey'];
            $cardholderName     = $card_details['cardholderName'];
            $cardNumber         = $this->get_clean_card_number( $card_details['cardNumber'] );
            $expiryDate         = $this->get_clean_expiry_date( $card_details['expiryDate'] );
            $securityCode       = $card_details['securityCode'];

            $data = array( 
                        "cardDetails" => array( 
                                            "cardholderName"  => $cardholderName,
                                            "cardNumber"      => $cardNumber,
                                            "expiryDate"      => $expiryDate,
                                            "securityCode"    => $securityCode
                                        )
                    );

            $cardIdentifier  = $this->remote_post( $data, $this->card_identifiers_url, $merchantSessionKey, 'Bearer' );

            return $cardIdentifier;

        }

        /**
         * [check_merchantSessionKey_expiry description]
         * @param  [type] $expiry [description]
         * @return [type]         [description]
         */
        function check_merchantSessionKey_expiry( $expiry ) {

            $current_date_time = (new DateTime())->format('c');

            // $expiry = new DateTime( $expiry );

            // throw new Exception( $interval );

        }

        /**
         * [get_txtype description]
         * @param  [type] $order [description]
         * @return [type]        [description]
         */
        function get_txtype( $order ) {

            $order_id = $order->get_id();

            // Paying for a "Pay Later" Pre Order
            if( isset( $_GET['pay_for_order'] ) && $_GET['pay_for_order'] == true && class_exists( 'WC_Pre_Orders' ) && WC_Pre_Orders_Order::order_contains_pre_order( $order_id ) ) {
                return 'PAYMENT';
            }
            
            if( class_exists( 'WC_Pre_Orders' ) && WC_Pre_Orders_Order::order_contains_pre_order( $order_id ) && WC_Pre_Orders_Order::order_will_be_charged_upon_release( $order_id ) ) {
                return 'DEFERRED';
            } else {
                return $this->txtype;
            }

        }

        /**
         * The account ID, if applicable, of your customers account on your website.
         * @param  [type] $data  [description]
         * @param  [type] $order [description]
         * @return [type]        [description]
         */
        public static function get_acctID( $data, $order ) {
            
            if( 0 !== $order->get_user_id() ) {
                $data["acctID"] = $order->get_user_id(),
            }

            return $data;              
        }

        /**
         * Additional information about the Cardholder's account that has been provided by you. E.g. How long has the cardholder had the account on your website.
         * @param  [type] $data  [description]
         * @param  [type] $order [description]
         * @return [type]        [description]
         */
        public static function get_acctInfo( $data, $order ) {

            // Length of time that the cardholder has had their online account with you.
            $data = self::get_chAccAgeInd( $data, $order );

            // Date that the cardholder opened their online account with you.
            $data = self::get_chAccDate( $data, $order );

            // Number of purchases with this cardholder account during the previous six months.
            $data = self::get_nbPurchaseAccount( $data, $order );

            // Indicates if the Cardholder Name on the account is identical to the shipping Name used for this transaction.
            $data = self::get_shipNameIndicator( $data, $order );

            // Number of transactions (successful and abandoned) for this cardholder account with you, across all payment accounts in the previous 24 hours.
            $data = self::get_txnActivityDay( $data, $order );

            // Number of transactions (successful and abandoned) for this cardholder account with you, across all payment accounts in the previous year.
            $data = self::get_txnActivityYear( $data, $order );

            return $data;              
        }

        /**
         * Merchant's assessment of the level of fraud risk for the specific authentication for both the cardholder and the authentication being conducted. 
         * E.g. Are you shipping goods to the cardholder's billing address, is this a first-time order or reorder.
         *
         * deliveryTimeframe :
         * Indicates the merchandise delivery timeframe.
         *
         *     ElectronicDelivery   = Electronic Delivery
         *     SameDayShipping      = Same day shipping
         *     OvernightShipping    = Overnight shipping
         *     TwoDayOrMoreShipping = Two-day or more shipping
         *
         * shipIndicator :
         * Indicates shipping method chosen for the transaction. 
         * You must choose the Shipping Indicator code that most accurately describes the cardholder's specific transaction, not their general business. 
         * If one or more items are included in the sale, use the Shipping Indicator code for the physical goods, 
         * or if all digital goods, use the Shipping Indicator code that describes the most expensive item.
         * 
         *     CardholderBillingAddress             = Ship to cardholder's billing address
         *     OtherVerifiedAddress                 = Ship to another verified address on file with merchant
         *     DifferentToCardholderBillingAddress  = Ship to address that is different than the cardholder's billing address
         *     LocalPickUp                          = 'Ship to Store / Pick-up at local store (Store address shall be populated in shipping address fields)
         *     DigitalGoods                         = Digital goods (includes online services, electronic gift cards and redemption codes)
         *     NonShippedTickets                    = Travel and Event tickets, not shipped
         *     Other                                = Other (for example, Gaming, digital services not shipped, e-media subscriptions, etc.)
         * 
         * @param  [type] $data  [description]
         * @param  [type] $order [description]
         * @return [type]        [description]
         */
        public static function get_merchantRiskIndicator( $data, $order ) {

            $deliveryTimeframe  = NULL;
            $shipIndicator      = NULL;

            if ( $order->has_shipping_address() ) {

                $deliveryTimeframe  = "TwoDayOrMoreShipping";

                $billing_address = array(
                        $order->get_billing_address_1(),
                        $order->get_billing_address_2(),
                        $order->get_billing_city(),
                        $order->get_billing_state(),
                        $order->get_billing_postcode(),
                        $order->get_billing_country(),
                    );

                $shipping_address = array(
                        $order->get_shipping_address_1(),
                        $order->get_shipping_address_2(),
                        $order->get_shipping_city(),
                        $order->get_shipping_state(),
                        $order->get_shipping_postcode(),
                        $order->get_shipping_country(),
                    );

                if( MD5( json_encode($billing_address) ) === MD5( json_encode($shipping_address) ) ) {
                    $shipIndicator = "CardholderBillingAddress";
                } else {
                    $shipIndicator = "DifferentToCardholderBillingAddress";
                }

            } else {

                if( $order->has_downloadable_item() ) {
                    $deliveryTimeframe  = "ElectronicDelivery";
                    $shipIndicator      = "DigitalGoods";
                }

            }

            $deliveryTimeframe  = apply_filters( 'woocommerce_opayo_get_merchantRiskIndicator_deliveryTimeframe', $deliveryTimeframe, $data, $order );
            $shipIndicator      = apply_filters( 'woocommerce_opayo_get_merchantRiskIndicator_shipIndicator', $shipIndicator, $data, $order );

            if( !is_null( $deliveryTimeframe ) ) {
                $data["merchantRiskIndicator"]["deliveryTimeframe"] = $deliveryTimeframe;
            }

            if( !is_null( $shipIndicator ) ) {
                $data["merchantRiskIndicator"]["shipIndicator"]     = $shipIndicator;
            }

            return $data;              
        }

        /**
         * Information about how you authenticated the cardholder before or during the transaction. 
         * E.g. Did your customer log into their online account on your website, using two-factor authentication, or did they log in as a guest.
         * @param  [type] $data  [description]
         * @param  [type] $order [description]
         * @return [type]        [description]
         */
        public static function get_threeDSRequestorAuthenticationInfo( $data, $order ) {

            if( 0 === $order->get_user_id() ) {
                $threeDSReqAuthMethod = "NoThreeDSRequestorAuthentication";
            } else {
                $threeDSReqAuthMethod = "LoginWithThreeDSRequestorCredentials";
            }

            $threeDSReqAuthMethod = apply_filters( 'woocommerce_opayo_get_threeDSRequestorAuthenticationInfo', $threeDSReqAuthMethod, $data, $order );

            $data["threeDSRequestorAuthenticationInfo"] = array(
                                                                "threeDSReqAuthMethod" => $threeDSReqAuthMethod,
                                                            );

            return $data;              
        }

        /**
         * Length of time that the cardholder has had their online account with you.
         * 
         * GuestCheckout            = No account (guest check-out)
         * CreatedDuringTransaction = Created during this transaction
         * LessThanThirtyDays       = Less than 30 days
         * ThirtyToSixtyDays        = 30-60 days
         * MoreThanSixtyDays        = More than 60 days
         *
         * @param  [type] $data  [description]
         * @param  [type] $order [description]
         * @return [type]        [description]
         */
        public static function get_chAccAgeInd( $data, $order ) {

            if( 0 !== $order->get_user_id() ) {

                // Get User Object
                $user_object = get_userdata( $order->get_user_id() );

                // Get user registration date and format it.
                $registered_date  = $user_object->user_registered;
                $datetime         = new DateTime( $registered_date );
                $registered_date  = $datetime->format('Ymd');
                $days_registered  = intval( ( strtotime( 'now' ) - strtotime( $registered_date ) ) / 86400 );

                $orders_today_array = get_posts(
                                            array(
                                                'numberposts' => -1,
                                                'meta_key'    => '_customer_user',
                                                'meta_value'  => $order->get_user_id(),
                                                'post_type'   => wc_get_order_types(),
                                                'post_status' => array( 'wc-completed', 'wc-processing' ),
                                                'date_query'  => array(
                                                    'after' => '1 day ago'
                                                )
                                            )
                                        );
                $orders_today = count( $orders_today_array );

                if ( $days_registered < 1 && 0 === $orders_today ) {
                    $chAccAgeInd = "CreatedDuringTransaction";
                } elseif ( $days_registered < 30 ) {
                    $chAccAgeInd = "LessThanThirtyDays";
                } elseif ( $days_registered >= 30 && $days_registered <= 60 ) {
                    $chAccAgeInd = "ThirtyToSixtyDays";
                } else {
                    $chAccAgeInd = "MoreThanSixtyDays";
                }
                
            } else {
                $$chAccAgeInd = "GuestCheckout";
            }

            $data["chAccAgeInd"] = apply_filters( 'woocommerce_opayo_get_chAccAgeInd', $chAccAgeInd, $data, $order );

            return $data;              
        }

        /**
         * Date that the cardholder opened their online account with you.
         * If no date is stored in user meta then we use date of first order and then add that to user meta
         * Format yearmonthday eg 20210522
         * 
         * @param  [type] $data  [description]
         * @param  [type] $order [description]
         * @return [type]        [description]
         */
        public static function get_chAccDate( $data, $order ) {

            if( 0 !== $order->get_user_id() ) {
                // Get User Object
                $user_object = get_userdata( $order->get_user_id() );
                
                // Get user registration date and format it.
                $registered_date  = $user_object->user_registered;
                $datetime         = new DateTime( $registered_date );
                $registered_date  = $datetime->format('Ymd');

                $data["chAccDate"] = $registered_date;
            }

            return $data;              
        }

        /**
         * Number of purchases with this cardholder account during the previous six months
         * 
         * @param  [type] $data  [description]
         * @param  [type] $order [description]
         * @return [type]        [description]
         */
        public static function get_nbPurchaseAccount( $data, $order ) {

            if( 0 !== $order->get_user_id() ) {
                $orders_count_array = get_posts(
                                            array(
                                                'numberposts' => -1,
                                                'meta_key'    => '_customer_user',
                                                'meta_value'  => $order->get_user_id(),
                                                'post_type'   => wc_get_order_types(),
                                                'post_status' => array( 'wc-completed', 'wc-processing' ),
                                                'date_query'  => array(
                                                    'after' => '6 month ago'
                                                )
                                            )
                                        );

                $data["nbPurchaseAccount"] = count( $orders_today_array );
            }

            return $data;              
        }

        /**
         * Indicates if the Cardholder Name on the account is identical to the shipping Name used for this transaction.
         *
         * FullMatch    = Account Name identical to shipping Name
         * NoMatch      = Account Name different than shipping Name
         * 
         * @param  [type] $data  [description]
         * @param  [type] $order [description]
         * @return [type]        [description]
         */
        public static function get_shipNameIndicator( $data, $order ) {

            if ( $order->has_shipping_address() ) {

                if( md5( $order->get_billing_first_name().$order->get_billing_last_name() ) === md5( $order->get_shipping_first_name().$order->get_shipping_last_name() ) ) {
                    $shipNameIndicator = "FullMatch";
                } else {
                    $shipNameIndicator = "NoMatch";
                }

                $data["shipNameIndicator"] = apply_filters( 'woocommerce_opayo_get_shipNameIndicator', $shipNameIndicator, $data, $order );

            }

            return $data

        }

        /**
         * Number of transactions (successful and abandoned) for this cardholder account with you, across all payment accounts in the previous 24 hours.
         * 
         * @param  [type] $data  [description]
         * @param  [type] $order [description]
         * @return [type]        [description]
         */
        public static function get_txnActivityDay( $data, $order ) {

            if( 0 !== $order->get_user_id() ) {
                $orders = get_posts(
                                    array(
                                        'numberposts' => -1,
                                        'meta_key'    => '_customer_user',
                                        'meta_value'  => $order->get_user_id(),
                                        'post_type'   => wc_get_order_types(),
                                        'post_status' => array_keys( wc_get_order_statuses() ),
                                        'date_query'  => array(
                                            'after' => '1 day ago'
                                        )
                                    )
                                );

                $data["txnActivityDay"] = apply_filters( 'woocommerce_opayo_get_txnActivityDay', count($orders), $data, $order );
            }
            return $data;

        }

        /**
         * Number of transactions (successful and abandoned) for this cardholder account with you, across all payment accounts in the previous year.
         * 
         * @param  [type] $data  [description]
         * @param  [type] $order [description]
         * @return [type]        [description]
         */
        public static function get_txnActivityYear( $data, $order ) {

            if( 0 !== $order->get_user_id() ) {
                $orders = get_posts(
                                    array(
                                        'numberposts' => -1,
                                        'meta_key'    => '_customer_user',
                                        'meta_value'  => $order->get_user_id(),
                                        'post_type'   => wc_get_order_types(),
                                        'post_status' => array_keys( wc_get_order_statuses() ),
                                        'date_query'  => array(
                                            'after' => '1 year ago'
                                        )
                                    )
                                );

                $data["txnActivityYear"] = apply_filters( 'woocommerce_opayo_get_txnActivityYear', count($orders), $data, $order );
            }

            return $data;

        }

    }
