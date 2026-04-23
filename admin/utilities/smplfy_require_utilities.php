<?php
/**
 * Recursively require all php files in a directory.
 */

namespace SMPLFY\smt;

function require_directory( $dir ) {
    if ( ! realpath( $dir ) ) {
        $dir = SMPLFY_SMT_PLUGIN_DIR . $dir;
    }

    $items = glob( $dir . '/*' );

    foreach ( $items as $path ) {
        $isFile = preg_match( '/\.php$/', $path );

        if ( $isFile ) {
            require_once $path;
        } elseif ( is_dir( $path ) ) {
            require_directory( $path );
        }
    }
}

function require_file( $filePath ) {
    require_once SMPLFY_SMT_PLUGIN_DIR . $filePath;
}
