<?php

namespace SMPLFY\smt;

use SmplfyCore\SMPLFY_BaseEntity;

class JobMasterEntity extends SMPLFY_BaseEntity {

    public function __construct( $formEntry = [] ) {
        parent::__construct( $formEntry );
        $this->formId = FormIds::JOB_MASTER_FORM_ID;
    }

    protected function get_property_map(): array {
        return [
            'assignedTech'      => '39',
            'assignedSupport'   => '41',
            'comments'          => '43',
            'nameFirst'         => '13.3',
            'nameLast'          => '13.6',
            'email'             => '15',
            'phone'             => '16',
            'address'           => '17',
            'serviceType'       => '30',
            'description'       => '21',
            'date'              => '22',
            'total'             => '31',
            'agreementToWork'   => '28',
            'workSignOff'       => '29',
            'paymentMethod'     => '35',
            'customerStatus'    => '42',
        ];
    }
}
