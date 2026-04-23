<?php

namespace SMPLFY\smt;

use SmplfyCore\SMPLFY_BaseRepository;
use SmplfyCore\SMPLFY_GravityFormsApiWrapper;
use WP_Error;

/**
 * @method static JobMasterEntity|null get_one( $fieldId, $value )
 * @method static JobMasterEntity|null get_one_for_current_user()
 * @method static JobMasterEntity|null get_one_for_user( $userId )
 * @method static JobMasterEntity[] get_all( $fieldId = null, $value = null, string $direction = 'ASC' )
 * @method static int|WP_Error add( JobMasterEntity $entity )
 */
class JobMasterRepository extends SMPLFY_BaseRepository {
    public function __construct( SMPLFY_GravityFormsApiWrapper $gravityFormsApi ) {
        $this->entityType = JobMasterEntity::class;
        $this->formId     = FormIds::JOB_MASTER_FORM_ID;

        parent::__construct( $gravityFormsApi );
    }
}
