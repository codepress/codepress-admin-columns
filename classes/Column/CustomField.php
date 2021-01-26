<?php

namespace AC\Column;

use AC\Column;
use AC\MetaType;
use AC\Settings;

/**
 * Custom field column, displaying the contents of meta fields.
 * Suited for all list screens supporting WordPress' default way of handling meta data.
 * Supports different types of meta fields, including dates, serialized data, linked content,
 * and boolean values.
 * @since 1.0
 */
class CustomField extends Column\Meta {

	const TYPE = 'column-meta';

	public function __construct( $name, MetaType $meta_type, Settings\ColumnSettingsCollection $data = null ) {
		parent::__construct( self::TYPE, $name, $meta_type, $data );
	}

	public function get_meta_key() {
		return $this->get_setting( 'custom_field' )->get_value();
	}

	// TODO move to ColumnSettingsFactory
//	public function register_settings() {
//		$this->add_setting( new Settings\Column\CustomField( $this->name, $this->meta_type ) )
//		     ->add_setting( new Settings\Column\BeforeAfter( $this->name ) );
//
//		if ( ! ac_is_pro_active() ) {
//			$this->add_setting( new Settings\Column\Pro\Sorting( $this->name ) )
//			     ->add_setting( new Settings\Column\Pro\InlineEditing( $this->name ) )
//			     ->add_setting( new Settings\Column\Pro\BulkEditing( $this->name ) )
//			     ->add_setting( new Settings\Column\Pro\SmartFiltering( $this->name ) )
//			     ->add_setting( new Settings\Column\Pro\Export( $this->name ) );
//		}
//	}


	public function get_field_type() {
		return $this->get_setting( 'field_type' )->get_value();
	}

	public function get_field() {
		return $this->get_meta_key();
	}

}