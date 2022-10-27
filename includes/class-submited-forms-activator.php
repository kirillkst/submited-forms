<?php

/**
 * @since      1.0.0
 *
 * @package    Submited_Forms
 * @subpackage Submited_Forms/includes
 */

class Submited_Forms_Activator {

	public static function activate() {
		$db = submited_forms()->get_db();
		$table = submited_forms()->get_table_name();
		$charset_collate = $db->get_charset_collate();
		if ( $db->get_var( "SHOW TABLES LIKE '{$table}'" ) != $table ) {
			$sql = "CREATE TABLE $table (
				id bigint(20) NOT NULL AUTO_INCREMENT,
				date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				subject text NOT NULL DEFAULT '',
				name text NOT NULL DEFAULT '',
				phone text NOT NULL DEFAULT '',
				email text NOT NULL DEFAULT '',
				message longtext NOT NULL DEFAULT '',
				additional_data longtext NOT NULL DEFAULT '',
				page_name text NOT NULL DEFAULT '',
				referer text NOT NULL DEFAULT '',
				comment longtext NOT NULL DEFAULT '',
				PRIMARY KEY  (id)
			) $charset_collate;";
		
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}

}
