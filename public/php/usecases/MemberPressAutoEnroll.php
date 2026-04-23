<?php

namespace SMPLFY\smt;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class MemberPressAutoEnroll {

    /**
     * Handle user creation from WordPress admin.
     */
    public function handle_user_created( int $user_id ): void {

        if ( $this->user_has_membership( $user_id ) ) {
            error_log( '[SMT] User ' . $user_id . ' already has a membership — skipping.' );
            return;
        }

        $user = get_userdata( $user_id );
        if ( $user && in_array( 'administrator', (array) $user->roles, true ) ) {
            error_log( '[SMT] User ' . $user_id . ' is admin — skipping.' );
            return;
        }

        $this->enroll_user( $user_id, FormIds::CLIENT_MEMBERSHIP_ID );
        error_log( '[SMT] Auto-enrolled user ' . $user_id . ' into Client membership.' );
    }

    /**
     * Handle user creation from Gravity Forms User Registration.
     */
    public function handle_gf_user_registered( int $user_id, array $feed, array $entry, string $user_pass ): void {

        $form_id       = (int) $entry['form_id'];
        $membership_id = $this->get_membership_for_form( $form_id );

        if ( ! $membership_id ) {
            error_log( '[SMT] No membership mapping for form ' . $form_id . ' — skipping.' );
            return;
        }

        if ( $this->user_has_specific_membership( $user_id, $membership_id ) ) {
            error_log( '[SMT] User ' . $user_id . ' already has membership ' . $membership_id . ' — skipping.' );
            return;
        }

        $this->enroll_user( $user_id, $membership_id );
        \GFAPI::update_entry_field( $entry['id'], 'created_by', $user_id );
        error_log( '[SMT] Auto-enrolled user ' . $user_id . ' via form ' . $form_id );
    }

    /**
     * Create subscription + transaction for user.
     */
    private function enroll_user( int $user_id, int $membership_id ): void {

        $membership = new \MeprProduct( $membership_id );
        if ( ! $membership->ID ) {
            error_log( '[SMT] Membership ' . $membership_id . ' not found.' );
            return;
        }

        // Create subscription
        $sub              = new \MeprSubscription();
        $sub->user_id     = $user_id;
        $sub->product_id  = $membership_id;
        $sub->price       = $membership->price;
        $sub->period      = $membership->period;
        $sub->period_type = $membership->period_type;
        $sub->limit_cycles         = false;
        $sub->limit_cycles_num     = 0;
        $sub->limit_cycles_action  = 'expire';
        $sub->status      = \MeprSubscription::$active_str;
        $sub->created_at  = gmdate( 'Y-m-d H:i:s' );
        $sub->gateway     = 'manual';
        $sub->store();

        // Create transaction
        $txn                  = new \MeprTransaction();
        $txn->user_id         = $user_id;
        $txn->product_id      = $membership_id;
        $txn->subscription_id = $sub->id;
        $txn->trans_num       = 'smt-' . $user_id . '-' . time();
        $txn->status          = \MeprTransaction::$complete_str;
        $txn->txn_type        = 'payment';
        $txn->gateway         = 'manual';
        $txn->amount          = $membership->price;
        $txn->total           = $membership->price;
        $txn->created_at      = gmdate( 'Y-m-d H:i:s' );

        if ( (float) $membership->price <= 0 ) {
            $txn->expires_at = '0000-00-00 00:00:00';
        } else {
            $txn->expires_at = \MeprUtils::ts_to_mysql_date(
                strtotime( '+' . $membership->period . ' ' . $membership->period_type )
            );
        }

        $txn->store();

        \MeprEvent::record( 'transaction-completed', $txn );
        \MeprEvent::record( 'subscription-created', $sub );

        $this->send_welcome_notification( $txn );
    }

    private function send_welcome_notification( \MeprTransaction $txn ): void {

        try {
            $params = \MeprTransactionsHelper::get_email_params( $txn );
            $user   = $txn->user();

            $user_email = \MeprEmailFactory::fetch(
                'MeprUserSignupEmail',
                'MeprBaseSignupEmail',
                [ [ 'to' => $user->user_email ] ]
            );

            if ( $user_email ) {
                $user_email->to = $user->user_email;
                $user_email->send( $params );
            }

            $admin_email = \MeprEmailFactory::fetch(
                'MeprAdminSignupEmail',
                'MeprBaseSignupEmail'
            );

            if ( $admin_email ) {
                $admin_email->send( $params );
            }

        } catch ( \Exception $e ) {
            error_log( '[SMT] MemberPress email error: ' . $e->getMessage() );
        }
    }

    private function get_membership_for_form( int $form_id ): ?int {
        $map = [
            FormIds::JOB_MASTER_FORM_ID      => FormIds::CLIENT_MEMBERSHIP_ID,
            FormIds::GET_AN_ESTIMATE_FORM_ID => FormIds::CLIENT_MEMBERSHIP_ID,
        ];
        return $map[ $form_id ] ?? null;
    }

    private function user_has_membership( int $user_id ): bool {
        $user = new \MeprUser( $user_id );
        return ! empty( $user->active_product_subscriptions( 'ids' ) );
    }

    private function user_has_specific_membership( int $user_id, int $membership_id ): bool {
        $user = new \MeprUser( $user_id );
        return in_array( $membership_id, $user->active_product_subscriptions( 'ids' ), true );
    }
}
