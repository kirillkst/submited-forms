<?php
/**
 * @since      1.0.0
 * @package    Submited_Forms
 * @subpackage Submited_Forms/includes
 */

class Submited_Forms {

	protected $loader;
	protected $plugin_name; //The unique identifier of this plugin.
	protected $db;
	protected $table_name;
	private static $instance = null;


 	public static function instance() {
 		if ( null === self::$instance ) {
 			self::$instance = new self();
 		}

 		return self::$instance;
 	}

	public function __construct() {
		global $wpdb;
		$this->db = $wpdb;
		$this->table_name  = 'submited_forms';
		$this->plugin_name = 'submited-form';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	private function load_dependencies() {
		$path = plugin_dir_path( dirname( __FILE__ ) );
		require_once $path . 'includes/class-submited-forms-loader.php';
		require_once $path . 'admin/class-submited-forms-admin.php';
		require_once $path . 'public/class-submited-forms-public.php';

		$this->loader = new Submited_Forms_Loader();
	}

	private function define_admin_hooks() {
		$admin = new Submited_Forms_Admin( $this->get_plugin_name() );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles_script' );
		$this->loader->add_action( 'admin_menu', $admin, 'admin_menu' );

		if ( wp_doing_ajax() ) {
			$this->loader->add_action( 'wp_ajax_submited_forms_delete_row', $admin, 'delete_row' );
			$this->loader->add_action( 'wp_ajax_submited_forms_add_comment', $admin, 'add_comment' );
		}
	}

	private function define_public_hooks() {
		$public = new Submited_Forms_Public( $this->get_plugin_name() );
		$this->loader->add_action( 'submited_form_add', $public, 'add', 10, 1 );
	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_db() {
		return $this->db;
	}

	public function get_table_name() {
		return $this->table_name;
	}

	public function get_data( $offset = NULL, $count = NULL ) {
		$db	   = $this->get_db();
		$table = $this->get_table_name();
		$sql   = "SELECT * FROM {$table} ORDER by id DESC";

		if ( ! is_null( $offset ) && ! is_null( $count ) )
			$sql = $db->prepare( $sql." LIMIT %d, %d", [ $offset, $count ] );

		return $db->get_results( $sql, ARRAY_A );
	}
}
