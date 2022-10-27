<?php
/**
 * @since      1.0.0
 *
 * @package    Submited_Forms
 * @subpackage Submited_Forms/admin
 */
class Submited_Forms_Admin {
	private $plugin_name;

	public function __construct( $plugin_name ) {
		$this->plugin_name = $plugin_name;
	}

	public function enqueue_styles_script($adminpage) {
		if ( $adminpage == 'toplevel_page_submited-forms' ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bootstrap-3.3.4.css', array(), '1', 'all' );
		}
	}

	public function delete_row() {
		check_ajax_referer( 'submited_forms_delete_row' );

		$id 	= sanitize_text_field($_POST['id']);
		$db 	= submited_forms()->get_db();
		$table = submited_forms()->get_table_name();

		$db->delete( $table, ['id' => $id] );
	}

	public function add_comment() {
		check_ajax_referer( 'submited_forms_add_comment' );

		$id 	= sanitize_text_field($_POST['id']);
		$data 	= sanitize_textarea_field($_POST['comment']);
		$db 	= submited_forms()->get_db();
		$table  = submited_forms()->get_table_name();

		$db->update( $table, [ 'comment' => $data ], [ 'id' => $id ] );
	}

	public function admin_menu() {
		add_menu_page( 'Формы', 'Формы', 'manage_options', 'submited-forms', [ $this, 'display' ] );
	}

	public function display() {
		$form_data 		= submited_forms()->get_data();
		$posts_per_page = 20;
		$post_count 	= count( $form_data );
		$max_page 		= ceil( $post_count / $posts_per_page );
		$current_page 	= isset($_GET['paged']) ? (int)$_GET['paged'] : 1;

		if ( $current_page > $max_page )
			$current_page = 1;

		$data = submited_forms()->get_data( $posts_per_page * ($current_page - 1), $posts_per_page );

		if ( $data )
			include 'partials/display.php';

		if ( $max_page > 1 )
			$this->_pagination( $current_page, $max_page );
	}

	private function _pagination( $current, $max ) {
		?>
		<ul class="pagination">
			<?php
				if ( $current != 1 )
					echo '<li><a class="prev page-numbers" href="'.add_query_arg(['paged' => $current-1]).'"><</a></li>';

				 for ( $i = 1; $i < $max + 1; $i++ )
					echo '<li>'.$this->_pagination_item($i, $current).'</li>';

				 if ( $current != $max )
					echo '<li><a class="next page-numbers" href="'.add_query_arg(['paged' => $current+1]).'">></a></li>';
			  ?>
		</ul>
		<?php
	}

	private function _pagination_item($current, $goal) {
		if ( $current == $goal )
			return '<span class="page-numbers current">' . $current . '</span>';

		return '<a class="page-numbers" href="' . add_query_arg( [ 'paged' => $current ] ) . '">' . $current . '</a>';
	}
}
