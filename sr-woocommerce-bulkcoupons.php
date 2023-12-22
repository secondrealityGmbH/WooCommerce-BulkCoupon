<?php

/**
 *
 * @link              https://www.secondreality.com/plugins/bulk-coupons
 * @since             1.0.0
 * @package           SR-WC-BulkCoupon
 *
 * @wordpress-plugin
 * Plugin Name:  WooCommerce Bulk Coupon Generator
 * Plugin URI:   https://www.secondreality.com/plugins/
 * Description:  Ability to create Bulk Coupons and export
 * Version:      1.0
 * Author:       secondreality GmbH - Frank Stuhec
 * Author URI:   https://www.secondreality.com/
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  sr-wc-bulkcoupon
 * Domain Path:  /languages
 */

defined('ABSPATH') || exit;


/**
* Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SR_WC_BULKCOUPON_VERSION', '1.0' );


// Plugin Folder Path
if( ! defined( 'SR_WC_BULKCOUPON_DIR' ) ) {
    define('SR_WC_BULKCOUPON_DIR', plugin_dir_path(__FILE__));
}

require_once (SR_WC_BULKCOUPON_DIR . 'includes/SRWCBulkTrait.php');
require_once (SR_WC_BULKCOUPON_DIR . 'includes/class-sr-wc-bulkcoupon.php');
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Activation and deactivation hooks for WordPress
 */
function srwcbulkcoupon_activate()
{
    // Check if WooCommerce is activated
    $plugin = new SR_WC_BulkCoupons();
    $plugin->checkForWooCommerce();
}

register_activation_hook(__FILE__, 'srwcbulkcoupon_activate');

function srwcbulkcoupon_deactivate()
{
    // Your deactivation logic goes here.

    // Don't forget to:
    // Remove Scheduled Actions
    // Remove Notes in the Admin Inbox
    // Remove Admin Tasks
}

register_deactivation_hook(__FILE__, 'srwcbulkcoupon_deactivate');


function deactivate_srwcbulkcoupon() {
    // deactivate plugin
    deactivate_plugins( plugin_basename( __FILE__ ) );
    if ( isset( $_GET['activate'] ) ) {
        unset( $_GET['activate'] );
    }
}


function srwcbulkcoupon_detect_plugin_deactivation( $plugin, $network_activation ) {
    if ($plugin=="woocommerce/woocommerce.php")
    {
        deactivate_plugins(plugin_basename(__FILE__));
    }
}
add_action( 'deactivated_plugin', 'srwcbulkcoupon_detect_plugin_deactivation', 10, 2 );




function checkForWooCommerce_show_notice(): void {
    echo '<div class="error"><p><strong>'.__('WooCommerce is not enabled.','sr-wc-bulkcoupon').'</strong> '.__('Plugin cannot be activated due to incompatible environment.','sr-wc-bulkcoupon').'</p></div>';
}


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_SR_WC_BulkCoupons(): void
{
    $plugin = new SR_WC_BulkCoupons();
    $plugin->run();

}

run_SR_WC_BulkCoupons();

