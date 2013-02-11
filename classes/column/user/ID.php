<?php

/**
 * CPAC_Column_User_ID
 *
 * @since 2.0.0
 */
class CPAC_Column_User_ID extends CPAC_Column {

	function __construct( $storage_model ) {		
		
		// define properties		
		$this->properties['type']	 = 'column-user-id';
		$this->properties['label']	 = __( 'User ID', 'cpac' );
			
		parent::__construct( $storage_model );
	}
	
	/**
	 * @see CPAC_Column::get_value()
	 * @since 2.0.0
	 */
	function get_value( $user_id ) {
		
		return $user_id;
	}
}