<?php

namespace SMPLFY\smt;

use SmplfyCore\SMPLFY_BaseRepository;
use SmplfyCore\SMPLFY_GravityFormsApiWrapper;
use WP_Error;

/**
 * @method static GetAnEstimateEntity|null get_one( $fieldId, $value )
 * @method static GetAnEstimateEntity|null get_one_for_current_user()
 * @method static GetAnEstimateEntity|null get_one_for_user( $userId )
 * @method static GetAnEstimateEntity[] get_all( $fieldId = null, $value = null, string $direction = 'ASC' )
 * @method static int|WP_Error add( GetAnEstimateEntity $entity )
 */
class GetAnEstimateRepository extends SMPLFY_BaseRepository {
    public function __construct( SMPLFY_GravityFormsApiWrapper $gravityFormsApi ) {
        $this->entityType = GetAnEstimateEntity::class;
        $this->formId     = FormIds::GET_AN_ESTIMATE_FORM_ID;

        parent::__construct( $gravityFormsApi );
    }
}
