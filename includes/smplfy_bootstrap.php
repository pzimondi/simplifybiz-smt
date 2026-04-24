<?php
/**
 * Loads specified files and all files in specified directories, then initialises dependencies.
 */

namespace SMPLFY\smt;

function bootstrap_smt_plugin() {
    require_smt_dependencies();

    DependencyFactory::create_plugin_dependencies();
}

function require_smt_dependencies() {

    require_file( 'includes/enqueue_scripts.php' );
    require_file( 'admin/DependencyFactory.php' );

    require_directory( 'public/php/types' );
    require_directory( 'public/php/entities' );
    require_directory( 'public/php/repositories' );
    require_directory( 'public/php/usecases' );
    require_directory( 'public/php/adapters' );
}
