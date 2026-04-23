<?php

namespace SMPLFY\smt;

class GravityFormsAdapter {

    private MemberPressAutoEnroll $memberPressAutoEnroll;

    public function __construct( MemberPressAutoEnroll $memberPressAutoEnroll ) {
        $this->memberPressAutoEnroll = $memberPressAutoEnroll;

        $this->register_hooks();
        $this->register_filters();
    }

    private function register_hooks(): void {

        // Auto-enroll user into MemberPress when registered via Gravity Forms
        add_action(
            'gform_user_registered',
            function( $user_id, $feed, $entry, $user_pass ) {
                $this->memberPressAutoEnroll->handle_gf_user_registered( $user_id, $feed, $entry, $user_pass );
            },
            10,
            4
        );
    }

    private function register_filters(): void {

        // Get An Estimate — branded confirmation
        add_filter(
            'gform_confirmation_' . FormIds::GET_AN_ESTIMATE_FORM_ID,
            function( $confirmation, $form, $entry, $ajax ) {

                $firstName = rgar( $entry, '3.3' );

                return '<div style="'
                    . 'font-family: \'Source Sans Pro\', sans-serif;'
                    . 'max-width: 600px;'
                    . 'margin: 40px auto;'
                    . 'padding: 0;'
                    . 'border-radius: 14px;'
                    . 'overflow: hidden;'
                    . 'box-shadow: 0 4px 24px rgba(68, 164, 0, 0.15);">'

                    . '<div style="background: #44a400; padding: 24px 32px; text-align: center;">'
                    . '<h2 style="color: #ffffff; margin: 0; font-size: 22px;">✅ We Got Your Request!</h2>'
                    . '</div>'

                    . '<div style="background: #ecffeb; padding: 28px 32px; text-align: center;">'
                    . '<p style="color: #1f1f1f; font-size: 18px; margin-top: 0;">Thank you <strong>' . esc_html( $firstName ) . '</strong>,</p>'
                    . '<p style="color: #333; font-size: 16px; line-height: 1.6;">Your estimate request has been received.<br>'
                    . 'We will call you within <strong>1 business day</strong> to discuss your needs.</p>'

                    . '<a href="tel:+13854974090" style="'
                    . 'display: inline-block;'
                    . 'margin-top: 16px;'
                    . 'padding: 12px 28px;'
                    . 'background: #0000e0;'
                    . 'color: #ffffff;'
                    . 'border-radius: 100px;'
                    . 'text-decoration: none;'
                    . 'font-weight: 700;'
                    . 'font-size: 16px;'
                    . '">📞 Call 385-497-4090</a>'

                    . '<p style="color: #888; font-size: 13px; margin-top: 20px; margin-bottom: 0;">— Setup My Technology</p>'
                    . '</div>'
                    . '</div>';
            },
            999,
            4
        );

        // Job Master Form — branded confirmation
        add_filter(
            'gform_confirmation_' . FormIds::JOB_MASTER_FORM_ID,
            function( $confirmation, $form, $entry, $ajax ) {

                $firstName = rgar( $entry, '13.3' );

                return '<div style="'
                    . 'font-family: \'Source Sans Pro\', sans-serif;'
                    . 'max-width: 600px;'
                    . 'margin: 40px auto;'
                    . 'padding: 0;'
                    . 'border-radius: 14px;'
                    . 'overflow: hidden;'
                    . 'box-shadow: 0 4px 24px rgba(68, 164, 0, 0.15);">'

                    . '<div style="background: #44a400; padding: 24px 32px; text-align: center;">'
                    . '<h2 style="color: #ffffff; margin: 0; font-size: 22px;">✅ Job Submitted Successfully!</h2>'
                    . '</div>'

                    . '<div style="background: #ecffeb; padding: 28px 32px; text-align: center;">'
                    . '<p style="color: #1f1f1f; font-size: 18px; margin-top: 0;">Thank you <strong>' . esc_html( $firstName ) . '</strong>,</p>'
                    . '<p style="color: #333; font-size: 16px; line-height: 1.6;">Your job has been submitted and our team has been notified.<br>'
                    . 'A technician will be assigned shortly and will contact you to confirm the appointment.</p>'

                    . '<a href="tel:+13854974090" style="'
                    . 'display: inline-block;'
                    . 'margin-top: 16px;'
                    . 'padding: 12px 28px;'
                    . 'background: #0000e0;'
                    . 'color: #ffffff;'
                    . 'border-radius: 100px;'
                    . 'text-decoration: none;'
                    . 'font-weight: 700;'
                    . 'font-size: 16px;'
                    . '">📞 Call 385-497-4090</a>'

                    . '<p style="color: #888; font-size: 13px; margin-top: 20px; margin-bottom: 0;">— Setup My Technology</p>'
                    . '</div>'
                    . '</div>';
            },
            999,
            4
        );
    }
}
