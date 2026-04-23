<?php
/**
 * Adapter for handling Gravity Flow workflow events on the SMT site.
 * Sends Google Chat notifications when workflow steps complete.
 */

namespace SMPLFY\smt;

class GravityFlowAdapter {

    private GoogleChatNotification $googleChatNotification;

    public function __construct( GoogleChatNotification $googleChatNotification ) {
        $this->googleChatNotification = $googleChatNotification;

        $this->register_hooks();
    }

    private function register_hooks(): void {

        add_action(
            'gravityflow_step_complete',
            [ $this, 'handle_step_complete' ],
            10,
            4
        );
    }

    public function handle_step_complete( $step_id, $entry_id, $form_id, $status ): void {

        if ( (int) $form_id !== FormIds::JOB_MASTER_FORM_ID ) {
            return;
        }

        $entry = \GFAPI::get_entry( $entry_id );

        if ( is_wp_error( $entry ) ) {
            error_log( '[SMT] Failed to get entry ' . $entry_id . ' for workflow step ' . $step_id );
            return;
        }

        $step = gravity_flow()->get_step( $step_id, $entry );

        if ( ! $step ) {
            return;
        }

        $stepName = strtolower( $step->get_name() );

        if ( strpos( $stepName, 'assign' ) !== false && strpos( $stepName, 'tech' ) !== false ) {
            $this->googleChatNotification->handle_job_assigned( $entry );
        }

        if ( strpos( $stepName, 'complete' ) !== false || strpos( $stepName, 'delivery' ) !== false ) {
            $this->googleChatNotification->handle_job_completed( $entry );
        }

        error_log( '[SMT] Workflow step completed: ' . $step->get_name() . ' (Step ID: ' . $step_id . ')' );
    }
}
