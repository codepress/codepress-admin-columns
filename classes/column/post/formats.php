<?php

/**
 * CPAC_Column_Post_Page_Template
 *
 * @since 2.0.0
 */
class CPAC_Column_Post_Formats extends CPAC_Column {

	function __construct( $storage_model ) {		
		
		// define properties		
		$this->properties['type']	 	= 'column-post-formats';
		$this->properties['label']	 	= __( 'Post Format', 'cpac' );
			
		parent::__construct( $storage_model );
	}
	
	/**
	 * @see CPAC_Column::apply_conditional()
	 * @since 2.0.0
	 */
	function apply_conditional() {
		
		if ( post_type_supports( $this->storage_model->key, 'post-formats' ) )
			return true;
		
		return false;
	}
	
	/**
	 * @see CPAC_Column::get_value()
	 * @since 2.0.0
	 */
	function get_value( $post_id ) {
	
		return get_post_format( $post_id );
	}
}