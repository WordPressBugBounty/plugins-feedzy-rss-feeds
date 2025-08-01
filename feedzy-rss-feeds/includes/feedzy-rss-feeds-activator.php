<?php
/**
 * Fired during plugin activation
 *
 * @link       https://themeisle.com
 * @since      3.0.0
 *
 * @package    feedzy-rss-feeds
 * @subpackage feedzy-rss-feeds/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      3.0.0
 * @package    feedzy-rss-feeds
 * @subpackage feedzy-rss-feeds/includes
 * @author     Themeisle <friends@themeisle.com>
 */
class Feedzy_Rss_Feeds_Activator {

	/**
	 * Plugin activation action.
	 *
	 * Triggers the plugin activation action on plugin activate.
	 *
	 * @since    3.0.0
	 * @access   public
	 */
	public static function activate() {
		$options           = get_option( Feedzy_Rss_Feeds::get_plugin_name(), array() );
		$is_fresh_install  = get_option( 'feedzy_fresh_install', false );
		$old_logger_option = get_option( 'feedzy_logger_flag', 'no' );
		if ( 'yes' === $old_logger_option ) {
			update_option( 'feedzy_rss_feeds_logger_flag', 'yes' );
			update_option( 'feedzy_logger_flag', 'no' );
		}
		if ( ! isset( $options['is_new'] ) ) {
			update_option(
				Feedzy_Rss_Feeds::get_plugin_name(),
				array(
					'is_new' => 'yes',
				)
			);
		}
		if ( ! defined( 'TI_CYPRESS_TESTING' ) && false === $is_fresh_install ) {
			update_option( 'feedzy_fresh_install', '1' );
		}
		add_option( 'feedzy-activated', true );

		if ( Feedzy_Rss_Feeds_Usage::get_instance()->is_new_user() ) {
			Feedzy_Rss_Feeds_Usage::get_instance()->update_usage_data(
				array(
					'can_track_first_usage' => true,
				)
			);
		}
	}
}
