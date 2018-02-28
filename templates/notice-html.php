<?php

/* @var AC_Notice $this */

$classes = 'ac-notice notice ' . $this->type;

?>
<div class="<?php echo esc_attr( $classes ); ?>" data-dismissible="<?php echo esc_attr( json_encode( $this->get( 'dismissible' ) ) ); ?>">
	<?php echo $this->message; ?>

	<?php if ( $this->is_dismissible() ) : ?>
		<a href="#" class="notice-dismiss" data-dismiss=""></a>
	<?php endif; ?>
</div>