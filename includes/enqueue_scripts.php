<?php
/**
 * Enqueue frontend scripts and styles.
 */

namespace SMPLFY\smt;

function enqueue_smt_frontend_scripts() {

    wp_enqueue_style(
        'smplfy-smt-frontend-styles',
        SMPLFY_SMT_PLUGIN_URL . 'public/css/frontend.css',
        [],
        '1.0.0'
    );
}

add_action( 'wp_enqueue_scripts', 'SMPLFY\smt\enqueue_smt_frontend_scripts' );
