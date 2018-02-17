<?php
define( 'DONOTCACHEPAGE', '1' );
if ( ! file_exists( dirname( __FILE__ ) . '/wpmudev-chat-config.php' ) ) {
	die();
}
$configs_array = file_get_contents( dirname( __FILE__ ) . '/wpmudev-chat-config.php' );
if ( ! empty( $configs_array ) ) {
	$configs_array = unserialize( $configs_array );
} else {
	$configs_array = array();
}
if ( ( isset( $configs_array['ABSPATH'] ) ) && ( ! empty( $configs_array['ABSPATH'] ) ) ) {
	$configs_array['ABSPATH'] = base64_decode( $configs_array['ABSPATH'] );
	if ( ! file_exists( $configs_array['ABSPATH'] . "/wp-load.php" ) ) //header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	{
		die();
	}
} else {
	//header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	die();
}

// For all actions/function where we are not polling for new messages we want full WP with all plugins enabled.
if ( $_POST['function'] !== "chat_messages_update" ) {

	define( 'SHORTINIT', false );
	define( 'WP_USE_THEMES', false );
	define( 'WP_DEBUG', false );

	// Load in WP core.
	require( $configs_array['ABSPATH'] . 'wp-load.php' );

} else {
	// To let out own plugin know we are in SHORTINIT mode
	define( 'WPMUDEV_CHAT_SHORTINIT', true );

	// But when polling for new messages we only want minimal WP no plugins loaded.
	define( 'SHORTINIT', true );
	define( 'WP_USE_THEMES', false );

	// Load in WP core.
	require( $configs_array['ABSPATH'] . 'wp-load.php' );

	// The following taken from wp-load.php. Comment out everything we don't need.
	// **************************************************************************
	require_once( ABSPATH . WPINC . '/l10n.php' );
	require( ABSPATH . WPINC . '/formatting.php' );
	require( ABSPATH . WPINC . '/capabilities.php' );
	require( ABSPATH . WPINC . '/user.php' );
	//Added in WordPress 4.4
	if ( file_exists( ABSPATH . WPINC . '/class-wp-user.php' ) ) {
		require( ABSPATH . WPINC . '/class-wp-user.php' );
	}
	if ( file_exists( ABSPATH . WPINC . '/class-wp-role.php' ) ) {
		require( ABSPATH . WPINC . '/class-wp-role.php' );
	}
	if ( file_exists( ABSPATH . WPINC . '/class-wp-roles.php' ) ) {
		require( ABSPATH . WPINC . '/class-wp-roles.php' );
	}
	if ( file_exists( ABSPATH . WPINC . '/rest-api.php' ) ) {
		require( ABSPATH . WPINC . '/rest-api.php' );
	}

	//Since WordPress 4.7
	if ( file_exists( ABSPATH . WPINC . '/class-wp-session-tokens.php' ) ) {
		require_once( ABSPATH . WPINC . '/class-wp-session-tokens.php' );
		require_once( ABSPATH . WPINC . '/class-wp-user-meta-session-tokens.php' );
	} elseif ( file_exists( ABSPATH . WPINC . '/session.php' ) ) {
		require( ABSPATH . WPINC . '/session.php' );
	}
	require( ABSPATH . WPINC . '/meta.php' );
	require( ABSPATH . WPINC . '/link-template.php' );
	require( ABSPATH . WPINC . '/post.php' );
	require( ABSPATH . WPINC . '/kses.php' );

	wp_plugin_directory_constants();
	wp_cookie_constants();

	require( ABSPATH . WPINC . '/vars.php' );

	require( ABSPATH . WPINC . '/pluggable.php' );
	require( ABSPATH . WPINC . '/pluggable-deprecated.php' );

	// Set internal encoding.
	wp_set_internal_encoding();

	// Define constants which affect functionality if not already defined.
	wp_functionality_constants();

	// Add magic quotes and set up $_REQUEST ( $_GET + $_POST )
	wp_magic_quotes();

	// Setup for WP_PLUGIN_URL and others. See it in wp-includes/default-constants.php
	//wp_plugin_directory_constants();
	//wp_cookie_constants();
	smilies_init();

	$wp = new WP();
	// Set up current user.

	$wp->init();

	// Load the default text localization domain.
	load_default_textdomain();

	$locale      = get_locale();
	$locale_file = WP_LANG_DIR . "/" . $locale . ".php";
	if ( ( 0 === validate_file( $locale ) ) && is_readable( $locale_file ) ) {
		require( $locale_file );
	}
	unset( $locale_file );

	// Pull in locale data after loading text domain.
	if ( file_exists( ABSPATH . WPINC . '/class-wp-locale.php' ) ) {
		require_once( ABSPATH . WPINC . '/class-wp-locale.php' );
	} elseif ( file_exists( ABSPATH . WPINC . '/locale.php' ) ) {
		require_once( ABSPATH . WPINC . '/locale.php' );
	}

	/**
	 * WordPress Locale object for loading locale domain date and various strings.
	 * @global object $wp_locale
	 * @since 2.1.0
	 */
	$GLOBALS['wp_locale'] = new WP_Locale();
	// **************************************************************************
	// end wp-load.php

	global $wp_version;
	if ( version_compare( $wp_version, '3.9' ) >= 0 ) {
		global $wp_plugin_paths;
		if ( ! $wp_plugin_paths ) {
			$wp_plugin_paths = array();
		}
	}
}

// Now load out plugin code. Using as a library here.
include_once( dirname( __FILE__ ) . '/wordpress-chat.php' );
global $wpmudev_chat;
$wpmudev_chat->init();
$wpmudev_chat->process_chat_actions();

die();