<?php

namespace AC\Admin\Section\Partial;

use AC\Form\Element\Toggle;
use AC\Renderable;
use AC\Settings\Option\EditButton;

//TODO make an abstract / interface for the general setting
class ShowEditButton implements Renderable {

	const OPTION_NAME = 'show_edit_button';

	/**
	 * @var EditButton
	 */
	private $option;

	public function __construct() {
		$this->option = new EditButton();
	}

	private function get_label() {
		return sprintf( __( "Show %s button on table screen.", 'codepress-admin-columns' ), sprintf( '"%s"', __( 'Edit columns', 'codepress-admin-columns' ) ) );
	}

	/**
	 * @return string
	 */
	public function render() {
		$toggle = new Toggle( $this->option->get_name(), $this->get_label(), $this->option->is_enabled() );
		$toggle->set_value( '1' );
		$toggle->set_attribute('data-ajax-setting', $this->option->get_name() );

		return $toggle->render();
	}

}