<?php

namespace SMPLFY\smt;

use SmplfyCore\SMPLFY_BaseEntity;

class GetAnEstimateEntity extends SMPLFY_BaseEntity {

    public function __construct( $formEntry = [] ) {
        parent::__construct( $formEntry );
        $this->formId = FormIds::GET_AN_ESTIMATE_FORM_ID;
    }

    protected function get_property_map(): array {
        return [
            'description'  => '1',
            'nameFirst'    => '3.3',
            'nameLast'     => '3.6',
            'phone'        => '4',
            'email'        => '5',
            'addressCity'  => '6.3',
            'addressZip'   => '6.5',
            'adminTitle'   => '7',
        ];
    }
}
