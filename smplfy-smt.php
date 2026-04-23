<?php
namespace SMPLFY\smt;

ini_set( 'display_errors', 0 );
ini_set( 'log_errors', 1 );
ini_set( 'error_log', __DIR__ . '/debug-error.txt' );
error_reporting( E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED );

/**
 * Plugin Name: SMPLFY SMT
 * Version: 1.0
 * Description: Custom plugin for Setup My Technology — Google Chat notifications, form confirmations, and MemberPress automation.
 * Author: Pastor Zimondi
 * Author URI: https://simplifybiz.com/
 * Requires PHP: 7.4
 * Requires Plugins: smplfy-core
 *
 * @package SMT
 * @author Pastor Zimondi
 * @since 1.0
 */

prevent_external_script_execution();

define( 'SMPLFY_SMT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SMPLFY_SMT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once SMPLFY_SMT_PLUGIN_DIR . 'admin/utilities/smplfy_require_utilities.php';
require_once SMPLFY_SMT_PLUGIN_DIR . 'includes/smplfy_bootstrap.php';

add_action( 'plugins_loaded', 'SMPLFY\smt\bootstrap_smt_plugin' );

function prevent_external_script_execution(): void {
    if ( ! function_exists( 'get_option' ) ) {
        header( 'HTTP/1.0 403 Forbidden' );
        die;
    }
}
