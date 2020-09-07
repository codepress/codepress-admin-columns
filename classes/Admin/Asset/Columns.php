<?php

namespace AC\Admin\Asset;

use AC;
use AC\Asset\Location;
use AC\Asset\Script;
use AC\DefaultColumnsRepository;
use AC\ListScreen;
use AC\ListScreenFactory;

class Columns extends Script {

	/**
	 * @var DefaultColumnsRepository
	 */
	private $default_columns;

	/**
	 * @var ListScreen
	 */
	private $list_screen;

	/**
	 * @var ListScreenFactory
	 */
	private $list_screen_factory;

	public function __construct(
		$handle,
		Location $location,
		DefaultColumnsRepository $default_columns,
		ListScreen $list_screen,
		ListScreenFactory $list_screen_factory
	) {
		parent::__construct( $handle, $location, [
			'jquery',
			'dashboard',
			'jquery-ui-slider',
			'jquery-ui-sortable',
			'wp-pointer',
		] );

		$this->default_columns = $default_columns;
		$this->list_screen = $list_screen;
		$this->list_screen_factory = $list_screen_factory;
	}

	private function get_list_screens() {
		return ( new AC\ListScreenTypeRepository() )->find_all( [ 'is_network' => is_network_admin() ] );
	}

	public function register() {
		parent::register();

		if ( null === $this->list_screen ) {
			return;
		}

		$params = [
			'_ajax_nonce'                => wp_create_nonce( AC\Ajax\Handler::NONCE_ACTION ),
			'list_screen'                => $this->list_screen->get_key(),
			'layout'                     => $this->list_screen->get_id()->get_id(),
			'original_columns'           => [],
			'uninitialized_list_screens' => [],
			'i18n'                       => [
				'clone'  => __( '%s column is already present and can not be duplicated.', 'codepress-admin-columns' ),
				'error'  => __( 'Invalid response.', 'codepress-admin-columns' ),
				'errors' => [
					'save_settings'  => __( 'There was an error during saving the column settings.', 'codepress-admin-columns' ),
					'loading_column' => __( 'The column could not be loaded because of an unknown error', 'codepress-admin-columns' ),
				],
			],
		];

		foreach ( $this->get_list_screens() as $list_screen ) {
			if ( $this->default_columns->exists( $list_screen->get_key() ) ) {
				continue;
			}

			$list_screen_link = $this->list_screen_factory->create( $list_screen->get_key() )->get_url();

			if ( ! $list_screen_link ) {
				continue;
			}

			$params['uninitialized_list_screens'][ $list_screen->get_key() ] = [
				'screen_link' => add_query_arg( [ 'save-default-headings' => '1', 'list_screen' => $list_screen->get_key() ], $list_screen_link ),
				'label'       => $list_screen->get_label(),
			];
		}

		wp_localize_script( 'ac-admin-page-columns', 'AC', $params );
	}

}