<?php

namespace SMPLFY\smt;

class GravityFormsAdapter {

    private GoogleChatNotification $googleChatNotification;

    public function __construct( GoogleChatNotification $googleChatNotification ) {
        $this->googleChatNotification = $googleChatNotification;

        $this->register_hooks();
    }

    private function register_hooks(): void {

        add_action(
            'gform_after_submission_' . FormIds::GET_AN_ESTIMATE_FORM_ID,
            function( $entry, $form ) {
                $this->googleChatNotification->handle_estimate_submitted( $entry );
            },
            10,
            2
        );

        add_action(
            'gform_after_submission_' . FormIds::JOB_MASTER_FORM_ID,
            function( $entry, $form ) {
                $this->googleChatNotification->handle_job_submitted( $entry );
            },
            10,
            2
        );
    }
}
