<?php

// Prevents direct access to the file for security reasons.
if ( ! defined( 'WPINC' ) ) {
	die();
}

?>

<div>
	<?php if ( ! empty( $status ) ) : ?>
		<p><?php echo esc_html( $status ); ?></p>
	<?php else : ?>
		<p>
			<?php esc_html_e( 'No status found.', 'ta-status' ); ?>

			<?php if ( current_user_can( 'admnistrator' ) ) : ?>
				<a href="<?php menu_page_url( 'ta-status' ); ?>"><?php esc_html_e( 'Add one here', 'ta-status' ); ?></a>
			<?php endif; ?>
		</p>
	<?php endif; ?>
</div>
