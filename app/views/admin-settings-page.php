<?php

// Prevents direct access to the file for security reasons.
if ( ! defined( 'WPINC' ) ) {
	die();
}

?>

<div class="wrap">
	<h1><?php esc_html_e( 'TA Status', 'ta-status' ); ?></h1>

	<p><?php esc_attr_e( 'Below status will be visible on dashboard widget.', 'ta-status' ); ?></p>

	<form method="post" action="">
		<fieldset>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">
							<label for="status"><?php esc_html_e( 'Status', 'ta-status' ); ?></label>
							<span class="screen-reader-text"><?php esc_html_e( 'Enter status', 'ta-status' ); ?></span>
						</th>
						<td><input name="status" type="text" id="status" value="<?php echo ( ! empty( $status ) ? esc_html( $status ) : '' ); ?>" class="regular-text" required></td>
					</tr>

					<?php if ( is_multisite() && current_user_can( 'subper-admin' ) ) : ?>
						<tr>
							<th scope="row"></th>
							<td>
								<p class="screen-reader-text"><?php esc_html_e( 'Overwrite status on all sub site', 'ta-status' ); ?></p>

								<label for="overwrite_status">
									<input name="overwrite_status" type="checkbox" id="overwrite_status" value="1" checked="checked">
									<b><?php esc_html_e( 'Overwrite status on all sub site', 'ta-status' ); ?></b>
								</label>
							</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</fieldset>

		<?php wp_nonce_field( 'ta_status_admin_settings', '_wpnonce_ta_status_admin_settings' ); ?>
		<?php submit_button( esc_html__( 'Submit', 'ta-staus' ) ); ?>
	</form>
</div>
<?php
