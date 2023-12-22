<?php

trait SRWCBulkTrait
{
    function checkForWooCommerce(): bool
    {
        // Test to see if WooCommerce is active (including network activated).

        $plugin_path = 'woocommerce/woocommerce.php';

        $active_plugins = (array) get_option( 'active_plugins', array() );
        if ( is_multisite() ) {
            $active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
        }

        $isActive =  in_array( $plugin_path, $active_plugins ) ||
                array_key_exists( $plugin_path, $active_plugins );

        if (!$isActive) {

            //self deactivate
            deactivate_srwcbulkcoupon();

            // throw error
            add_action( 'admin_notices', 'checkForWooCommerce_show_notice' );
        }

        return $isActive;
    }



    /**
     * Cloning is forbidden.
     *
     * @since 1.0
     */
    public function __clone() {
        _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheating huh?', 'sr-wc-bulkcoupon' ), '1.0' );
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheating huh?', 'sr-wc-bulkcoupon' ), '1.0' );
    }

}
