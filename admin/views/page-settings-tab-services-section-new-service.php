<?php
global $wpdb;

$appointments = appointments();
$currency     = appointments_get_option( 'currency' );
$services     = appointments_get_services();
$min_time     = $appointments->get_min_time();
$k_max        = apply_filters( 'app_selectable_durations', min( 24, (int) ( 1440 / $min_time ) ) );

$pages = apply_filters( 'app-service_description_pages-get_list', array() );
if ( empty( $pages ) ) {
	$pages = get_pages( apply_filters( 'app_pages_filter', array() ) );
}
?>
<form action="" method="post">
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="service-name"><?php _e( 'Service Name', 'appointments' ); ?></label>
			</th>
			<td>
				<input id="service-name" class="widefat" type="text" name="service_name" value=""/>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="service-capacity"><?php _e( 'Service Capacity', 'appointments' ); ?></label>
			</th>
			<td>
				<input id="service-capacity" type="text" name="service_capacity" value="" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="service-duration"><?php _e( 'Service Duration', 'appointments' ); ?></label>
			</th>
			<td>
				<select id="service-duration" name="service_duration">
					<?php for ( $k=1; $k<=$k_max; $k++ ): ?>
						<option><?php echo $k * $min_time; ?></option>
					<?php endfor; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="service-price"><?php _e( 'Service Price', 'appointments' ); ?></label>
			</th>
			<td>
				<input id="service-price" type="text" name="service_price" value="" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="service-page"><?php _e( 'Description Page', 'appointments' ); ?></label>
			</th>
			<td>
				<select id="service-page" name="service_page">
					<option value="0"><?php esc_html_e( 'None', 'appointments' ); ?></option>
					<?php foreach( $pages as $page ): ?>
						<option value="<?php echo $page->ID; ?>"><?php echo esc_html( get_the_title( $page->ID ) ); ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<?php do_action( 'appointments_add_new_service_form' ); ?>
	</table>

	<input type="hidden" name="action_app" value="add_new_service">
	<?php wp_nonce_field( 'update_app_settings', 'app_nonce' ); ?>
	<?php submit_button( __( 'Add new Service', 'appointments' ) ); ?>
</form>