<?php
namespace AC\Parser\Encode;

use AC\ListScreenCollection;
use AC\Parser\Encode;
use AC\Parser\Version480;

class PhpEncoder extends Encode {

	public function encode( ListScreenCollection $listScreens ) {
		$data = [
			'version' => Version480::VERSION,
		];

		foreach ( $listScreens as $listScreen ) {
			$data['list_screens'][] = $this->toArray( $listScreen );
		}

		return sprintf( '<?php return %s; ?>', var_export( $data, true ) );
	}

}