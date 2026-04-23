<?php

namespace SMPLFY\smt;

class DependencyFactory {

    private static bool $initialized = false;

    static function create_plugin_dependencies(): void {

        if ( self::$initialized ) {
            return;
        }
        self::$initialized = true;

        // Usecases
        $memberPressAutoEnroll = new MemberPressAutoEnroll();

        // Adapters
        new GravityFormsAdapter( $memberPressAutoEnroll );
        new WordpressAdapter( $memberPressAutoEnroll );
    }
}
