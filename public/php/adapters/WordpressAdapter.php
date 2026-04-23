<?php

namespace SMPLFY\smt;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WordpressAdapter {

    private MemberPressAutoEnroll $memberPressAutoEnroll;

    public function __construct( MemberPressAutoEnroll $memberPressAutoEnroll ) {
        $this->memberPressAutoEnroll = $memberPressAutoEnroll;

        $this->register_hooks();
    }

    private function register_hooks(): void {

        add_action(
            'user_register',
            [ $this->memberPressAutoEnroll, 'handle_user_created' ],
            20,
            1
        );
    }
}
