<?php

class AC_Settings_Setting_Image extends AC_Settings_SettingAbstract {

	/**
	 * @var string
	 */
	private $image_size;

	/**
	 * @var integer
	 */
	private $image_size_w = 80;

	/**
	 * @var integer
	 */
	private $image_size_h = 80;

	protected function set_id() {
		$this->id = 'image';
	}

	protected function set_managed_options() {
		$this->managed_options = array( 'image_size', 'image_size_w', 'image_size_h' );
	}

	public function view() {
		$size = $this->create_element( 'image_size', 'select' )
		             ->set_options( $this->get_grouped_image_sizes() );

		$width = new AC_Settings_View();
		$width->set( 'setting', $this->create_element( 'image_size_w', 'number' ) )
		      ->set( 'label', __( 'Width', 'codepress-admin-columns' ) )
		      ->set( 'description', __( 'Width in pixels', 'codepress-admin-columns' ) );

		$height = new AC_Settings_View();
		$height->set( 'setting', $this->create_element( 'image_size_h', 'number' ) )
		       ->set( 'label', __( 'Height', 'codepress-admin-columns' ) )
		       ->set( 'description', __( 'Height in pixels', 'codepress-admin-columns' ) );

		$view = new AC_Settings_View();
		$view->set( 'label', __( 'Image Size', 'codepress-admin-columns' ) )
		     ->set( 'setting', $size )
		     ->set( 'sections', array( $width, $height ) );

		return $view;
	}

	/**
	 * @since 1.0
	 * @return array
	 */
	private function get_grouped_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array(
			'default' => array(
				'title'   => __( 'Default', 'codepress-admin-columns' ),
				'options' => array(
					'thumbnail' => __( 'Thumbnail', 'codepress-admin-columns' ),
					'medium'    => __( 'Medium', 'codepress-admin-columns' ),
					'large'     => __( 'Large', 'codepress-admin-columns' ),
				),
			),
		);

		$all_sizes = get_intermediate_image_sizes();

		if ( ! empty( $all_sizes ) ) {
			foreach ( $all_sizes as $size ) {
				if ( 'medium_large' == $size || isset( $sizes['default']['options'][ $size ] ) ) {
					continue;
				}

				if ( ! isset( $sizes['defined'] ) ) {
					$sizes['defined']['title'] = __( 'Others', 'codepress-admin-columns' );
				}

				$sizes['defined']['options'][ $size ] = ucwords( str_replace( '-', ' ', $size ) );
			}
		}

		foreach ( $sizes as $key => $group ) {
			foreach ( array_keys( $group['options'] ) as $_size ) {

				$w = isset( $_wp_additional_image_sizes[ $_size ]['width'] ) ? $_wp_additional_image_sizes[ $_size ]['width'] : get_option( "{$_size}_size_w" );
				$h = isset( $_wp_additional_image_sizes[ $_size ]['height'] ) ? $_wp_additional_image_sizes[ $_size ]['height'] : get_option( "{$_size}_size_h" );

				if ( $w && $h ) {
					$sizes[ $key ]['options'][ $_size ] .= " ({$w} x {$h})";
				}
			}
		}

		$sizes['default']['options']['full'] = __( 'Full Size', 'codepress-admin-columns' );

		$sizes['custom'] = array(
			'title'   => __( 'Custom', 'codepress-admin-columns' ),
			'options' => array( 'cpac-custom' => __( 'Custom Size', 'codepress-admin-columns' ) . '&hellip;' ),
		);

		return $sizes;
	}

	/**
	 * @return string
	 */
	public function get_image_size() {
		return $this->image_size;
	}

	/**
	 * @param string $image_size
	 *
	 * @return $this
	 */
	public function set_image_size( $image_size ) {
		$this->image_size = $image_size;

		return $this;
	}

	/**
	 * @return int
	 */
	public function get_image_size_w() {
		return $this->image_size_w;
	}

	/**
	 * @param int $image_size_w
	 *
	 * @return $this
	 */
	public function set_image_size_w( $image_size_w ) {
		$this->image_size_w = $image_size_w;

		return $this;
	}

	/**
	 * @return int
	 */
	public function get_image_size_h() {
		return $this->image_size_h;
	}

	/**
	 * @param int $image_size_h
	 *
	 * @return $this
	 */
	public function set_image_size_h( $image_size_h ) {
		$this->image_size_h = $image_size_h;

		return $this;
	}

}