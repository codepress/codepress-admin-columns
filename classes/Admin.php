<?php

namespace AC;

use AC\Admin\Helpable;
use AC\Admin\Menu;
use AC\Admin\Page;
use AC\Admin\PageCollection;
use AC\Asset\Enqueueables;
use AC\Asset\Localizable;
use AC\Asset\Location;
use AC\Asset\Script;
use AC\Asset\Style;

class Admin implements Registrable {

	const NAME = 'codepress-admin-columns';

	const QUERY_ARG_PAGE = 'page';
	const QUERY_ARG_TAB = 'tab';

	/**
	 * @var string
	 */
	private $parent_slug;

	/**
	 * @var string
	 */
	private $menu_hook;

	/**
	 * @var Request
	 */
	private $request;

	/**
	 * @var PageCollection
	 */
	private $pages;

	/**
	 * @var Location\Absolute
	 */
	private $location;

	public function __construct( $parent_slug, $menu_hook, Request $request, PageCollection $pages, Location\Absolute $location ) {
		$this->parent_slug = $parent_slug;
		$this->menu_hook = $menu_hook;
		$this->pages = $pages;
		$this->request = $request;
		$this->location = $location;
	}

	/**
	 * @return Location\Absolute
	 */
	public function get_location() {
		return $this->location;
	}

	/**
	 * @param string $slug
	 *
	 * @return Page|null
	 */
	public function get_page( $slug ) {
		return $this->pages->get( $slug );
	}

	public function add_page( Page $page ) {
		$this->pages->add( $page );
	}

	/**
	 * @param string $slug
	 *
	 * @return string
	 */
	protected function create_menu_link( $slug ) {
		return add_query_arg(
			[
				self::QUERY_ARG_PAGE => self::NAME,
				self::QUERY_ARG_TAB  => $slug,
			],
			$this->parent_slug
		);
	}

	/**
	 * @return Page
	 */
	private function get_current_page() {
		$slug = $this->request->get( 'tab' );

		if ( $this->pages->has( $slug ) ) {
			return $this->pages->get( $slug );
		}

		return $this->pages->current();
	}

	/**
	 * @return Menu
	 */
	private function get_menu() {
		$menu = new Menu();

		$current_slug = $this->get_current_page()->get_slug();

		foreach ( $this->pages->all() as $page ) {
			$class = $current_slug === $page->get_slug()
				? 'nav-tab-active'
				: null;

			$menu->add( new Menu\Item( $this->create_menu_link( $page->get_slug() ), $page->get_title(), $class ) );
		}

		return $menu;
	}

	public function register() {
		add_action( $this->menu_hook, [ $this, 'register_menu' ] );
	}

	public function register_menu() {
		$hook = add_submenu_page(
			$this->parent_slug,
			__( 'Admin Columns Settings', 'codepress-admin-columns' ),
			__( 'Admin Columns', 'codepress-admin-columns' ),
			Capabilities::MANAGE,
			self::NAME,
			[ $this, 'render' ]
		);

		add_action( "load-" . $hook, [ $this, 'scripts' ] );
	}

	public function render() {
		?>
		<div id="cpac" class="wrap">
			<?= $this->get_menu()->render(); ?>
			<?= $this->get_current_page()->render(); ?>
		</div>
		<?php
	}

	public function scripts() {
		$page = $this->get_current_page();

		if ( $page instanceof Enqueueables ) {
			foreach ( $page->get_assets() as $asset ) {
				$asset->enqueue();
			}
		}

		if ( $page instanceof Helpable ) {
			foreach ( $page->get_help_tabs() as $help ) {
				get_current_screen()->add_help_tab( [
					'id'      => $help->get_id(),
					'title'   => $help->get_title(),
					'content' => $help->get_content(),
				] );
			}
		}

		$assets = [
			new Style( 'wp-pointer' ),
			new Style( 'jquery-qtip2', $this->location->with_suffix( 'external/qtip2/jquery.qtip.min.css' ) ),
			new Script( 'jquery-qtip2', $this->location->with_suffix( 'external/qtip2/jquery.qtip.min.js' ), [ 'jquery' ] ),
			new Script( 'ac-admin-general', $this->location->with_suffix( 'assets/js/admin-general.js' ), [ 'jquery', 'wp-pointer', 'jquery-qtip2' ] ),
			new Style( 'ac-admin', $this->location->with_suffix( 'assets/css/admin-general.css' ) ),
		];

		foreach ( $assets as $asset ) {
			$asset->enqueue();
		}

		do_action( 'ac/admin_scripts' );
		do_action( 'ac/admin_scripts/' . $page->get_slug() );

		// todo: add original hook
	}

}