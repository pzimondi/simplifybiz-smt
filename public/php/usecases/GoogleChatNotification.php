<?php

namespace SMPLFY\smt;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Posts a Google Chat notification whenever the
 * Get An Estimate or Job Master Form is submitted.
 */
class GoogleChatNotification {

    private string $webhook_url = 'https://chat.googleapis.com/v1/spaces/AAQAzc3PKA4/messages?key=AIzaSyDdI0hCZtE6vySjMm-WEfRq3CPzqKqqsHI&token=D5-QJHCY5GpRoIvKyUeculDyXPKQUq_GqxE_PuGhJdg';

    public function handle_estimate_submitted( array $entry ): void {

        try {

            $entity = new GetAnEstimateEntity( $entry );
            $this->send_estimate_notification( $entity );

        } catch ( \Throwable $e ) {
            error_log( 'SMT estimate submission error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine() );
        }
    }

    public function handle_job_submitted( array $entry ): void {

        try {

            $entity = new JobMasterEntity( $entry );
            $this->send_job_notification( $entity );

        } catch ( \Throwable $e ) {
            error_log( 'SMT job submission error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine() );
        }
    }

    private function send_estimate_notification( GetAnEstimateEntity $entity ): void {

        $fullName = trim( $entity->nameFirst . ' ' . $entity->nameLast );

        $text  = "📋 *New Estimate Request*\n";
        $text .= "────────────────────\n";
        $text .= "*Name:* {$fullName}\n";
        $text .= "*Email:* {$entity->email}\n";
        $text .= "*Phone:* {$entity->phone}\n";
        $text .= "*Location:* {$entity->addressCity} {$entity->addressZip}\n";
        $text .= "*What they need:* {$entity->description}\n";

        wp_remote_post( $this->webhook_url, [
            'body'     => wp_json_encode( [ 'text' => $text ] ),
            'headers'  => [ 'Content-Type' => 'application/json; charset=utf-8' ],
            'timeout'  => 0.01,
            'blocking' => false,
        ] );
    }

    private function send_job_notification( JobMasterEntity $entity ): void {

        $fullName = trim( $entity->nameFirst . ' ' . $entity->nameLast );

        $text  = "🆕 *New Job Submitted*\n";
        $text .= "────────────────────\n";
        $text .= "*Client:* {$fullName}\n";
        $text .= "*Email:* {$entity->email}\n";
        $text .= "*Phone:* {$entity->phone}\n";
        $text .= "*Service:* {$entity->serviceType}\n";
        $text .= "*Date:* {$entity->date}\n";
        $text .= "*Total:* {$entity->total}\n";
        $text .= "*Description:* {$entity->description}\n";

        wp_remote_post( $this->webhook_url, [
            'body'     => wp_json_encode( [ 'text' => $text ] ),
            'headers'  => [ 'Content-Type' => 'application/json; charset=utf-8' ],
            'timeout'  => 0.01,
            'blocking' => false,
        ] );
    }
}
