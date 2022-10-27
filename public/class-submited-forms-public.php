<?php
/**
 * @since      1.0.0
 *
 * @package    Submited_Forms
 * @subpackage Submited_Forms/public
 */

class Submited_Forms_Public {

	private $plugin_name;

	public function __construct( $plugin_name ) {
		$this->plugin_name = $plugin_name;

		add_shortcode( 'submited_forms', [ $this, 'shortcode' ] );
	}

	public function shortcode() {
		ob_start();

		if ( ! is_user_logged_in() ) :
			echo '<p>Вы не авторизованы</p>';
			echo '<a href="' . wp_login_url( get_permalink() ) . '">Войти</a>';
		else:
			$data = submited_forms()->get_data();
			
			if ( $data )
				include 'partials/display.php';
		endif;

	    return ob_get_clean();
	}

	public function add( $data ) {
		unset( $data['action'] );
		unset( $data['formName'] );
		unset( $data['successMsg'] );
		unset( $data['_wp_http_referer'] );
		unset( $data['_wpnonce'] );
		unset( $data['agreement'] );

		$fields = ['subject', 'name', 'phone', 'email', 'message', 'page_name', 'referer'];

		$insert['date'] = current_time("Y-m-d H:i:s");

		foreach ( $data as $key => $value ) {
			if ( in_array( $key, $fields ) )
				$insert[$key] = $value;
			else
				$insert['additional_data'] .= $value."\n\n==\n\n";
		}

		submited_forms()->get_db()->insert(
			submited_forms()->get_table_name(),
			$insert
		);
	}

}
