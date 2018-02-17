<?php
/**
 * Tries to determine what a post is being shown/edited. Gathers post_id, post_type, etc information
 *
 * @since 2.0.0
 * @uses environment
 *
 * @param none
 *
 * @return array of post_info
 */
function wpmudev_chat_utility_get_post_info() {
	$post_info = array();

	if ( isset( $_GET['post'] ) ) {
		$post_info['post_id'] = $post_ID = (int) $_GET['post'];
	} elseif ( isset( $_POST['post_ID'] ) ) {
		$post_info['post_id'] = $post_ID = (int) $_POST['post_ID'];
	} else {
		$post_info['post_id'] = $post_ID = 0;
	}

	$post = $post_type = $post_type_object = null;

	if ( $post_info['post_id'] ) {
		$post = get_post( $post_info['post_id'] );
		if ( $post ) {
			$post_info['post_type'] = $post->post_type;
		}

	} else {
		if ( isset( $_GET['post_type'] ) ) {
			$post_info['post_type'] = $_GET['post_type'];
		} else {
			$post_info['post_type'] = 'post';
		}
	}

	return $post_info;
}

/**
 * Get the last chat id for the given blog
 *
 * @global    object $wpdb
 * @global    int $blog_id
 */
function wpmudev_chat_get_last_chat_id() {
	//global $wpdb, $blog_id;
	//$last_id = $wpdb->get_var("SELECT chat_id FROM `".WPMUDEV_Chat::tablename('message')."` WHERE blog_id = '{$blog_id}' ORDER BY chat_id DESC LIMIT 1");

	//if ($last_id) {
	//	return substr($last_id, 0, -1);
	//}
	//return 1;

	return wp_generate_password( 16, false );
}

/**
 * Test whether logged in user is a moderator
 *
 * @param    Array $moderator_roles Moderator roles
 *
 * @return    bool    $moderator     True if moderator False if not
 */
function wpmudev_chat_is_moderator( $chat_session, $debug = false ) {
	global $current_user, $bp;

	if ( $chat_session['session_type'] === "bp-group" ) {
		if ( ( function_exists( 'groups_is_user_mod' ) )
		     && ( function_exists( 'groups_is_user_admin' ) )
		) {
			if ( ( groups_is_user_mod( $bp->loggedin_user->id, $bp->groups->current_group->id ) )
			     || ( groups_is_user_admin( $bp->loggedin_user->id, $bp->groups->current_group->id ) )
			     || ( is_super_admin() )
			) {
				return true;
			}
		}

		return false;

	}

	if ( $chat_session['session_type'] === "private" ) {
		global $wpmudev_chat;

		if ( ! isset( $chat_session['invite-info']['message']['host']['auth_hash'] ) ) {
			return false;
		} else if ( ! isset( $wpmudev_chat->chat_auth['auth_hash'] ) ) {
			return false;
		} else if ( $chat_session['invite-info']['message']['host']['auth_hash'] === $wpmudev_chat->chat_auth['auth_hash'] ) {
			return true;
		} else {
			return false;
		}
	}

	// all others

	// If the chat session doesn't have any defined moderator roles then no need to go further.
	if ( ( ! is_array( $chat_session['moderator_roles'] ) ) || ( ! count( $chat_session['moderator_roles'] ) ) ) {
		return false;
	}

	if ( ! is_multisite() ) {
		if ( $current_user->ID ) {
			foreach ( $chat_session['moderator_roles'] as $role ) {
				if ( in_array( $role, $current_user->roles ) ) {
					return true;
				}
			}
		}

	} else {
		// We only consider super admins IF the normal 'administrator' role is set.
		if ( ( is_super_admin() ) && ( array_search( 'administrator', $chat_session['moderator_roles'] ) !== false ) ) {
			return true;
		}


		if ( $current_user->ID ) {
			foreach ( $chat_session['moderator_roles'] as $role ) {
				if ( in_array( $role, $current_user->roles ) ) {
					return true;
				}
			}
		}
	}

	return false;
}

function wpmudev_chat_get_wp_roles() {
	global $wp_roles;
	$login_option_wp_roles = array();

	foreach ( $wp_roles->role_names as $role => $name ) {
		$login_option_wp_roles[] = $role;
	}

	return $login_option_wp_roles;
}


/** Need to check the size_str that it contains one of the values. If not intval the string and append 'px' */
function wpmudev_chat_check_size_qualifier( $size_str = '', $size_qualifiers = array( 'px', 'pt', 'em', '%' ) ) {
	if ( empty( $size_str ) ) {
		$size_str = "0";
	} //return $size_str;

	if ( count( $size_qualifiers ) ) {
		foreach ( $size_qualifiers as $size_qualifier ) {
			if ( empty( $size_qualifier ) ) {
				continue;
			}

			if ( substr( $size_str, strlen( $size_qualifier ) * - 1, strlen( $size_qualifier ) ) === $size_qualifier ) {
				return $size_str;
			}
		}

		return intval( $size_str ) . "px";
	}
}

function wpmudev_chat_get_user_role_highest_level( $user_role_capabilities = array() ) {
	$user_role_hightest_level = 0;

	foreach ( $user_role_capabilities as $capability => $is_set ) {
		if ( strncasecmp( $capability, 'level_', strlen( 'level_' ) ) == 0 ) {
			$capability_int = intval( str_replace( 'level_', '', $capability ) );
			if ( $capability_int > $user_role_hightest_level ) {
				$user_role_hightest_level = $capability_int;
			}
		}
	}

	return $user_role_hightest_level;
}


/**
 * We check the current url against the section blocked_urls.
 *
 * @global    object $wpmudev_chat
 *
 * @param    string $section Section name of options to check: site, widget, etc.
 *
 * @return    true/false            true = URL is blocked. false = URL is not blocked.
 */
function wpmudev_chat_check_is_blocked_urls( $urls = array(), $blocked_urls_action = 'exclude', $DEBUG = false ) {
	$_FLAG_BLOCK_CHAT = false;

	if ( ( is_array( $urls ) ) && ( count( $urls ) ) ) {

		$request_url       = get_option( 'siteurl' ) . $_SERVER['REQUEST_URI'];
		$request_url_parts = parse_url( $request_url );
		//if ($DEBUG == true) {
		//	echo "request_url_parts<pre>"; print_r($request_url_parts); echo "</pre>";
		//}

		// Rebuild the request_url without the query part.
		$request_url = $request_url_parts['scheme'] . '://' . $request_url_parts['host'] . $request_url_parts['path'];

		if ( ( isset( $request_url_parts['query'] ) ) && ( ! empty( $request_url_parts['query'] ) ) ) {
			//if ($DEBUG == true) {
			//	echo "query[". $request_url_parts['query'] ."]<br />";
			//}
			parse_str( $request_url_parts['query'], $request_url_query );
		} else {
			$request_url_query = '';
		}

		// Now go through and expand the blocked urls. Those which are relative will be prepended with scheme and host
		foreach ( $urls as $_idx => $url ) {
			$url_parts = parse_url( $url );

			if ( ! isset( $url_parts['scheme'] ) ) {
				$url_parts['scheme'] = $request_url_parts['scheme'];
			}

			if ( ! isset( $url_parts['host'] ) ) {
				$url_parts['host'] = $request_url_parts['host'];
			}

			$url_check = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'];

			$blocked_urls[ $_idx ]          = array();
			$blocked_urls[ $_idx ]['url']   = $url_check;
			$blocked_urls[ $_idx ]['query'] = array();

			if ( ( isset( $url_parts['query'] ) ) && ( strlen( $url_parts['query'] ) ) ) {
				$url_parts['query'] = str_replace( "&amp;", '&', $url_parts['query'] );
				parse_str( $url_parts['query'], $_query_string );
				if ( ( is_array( $_query_string ) ) && ( count( $_query_string ) ) ) {
					foreach ( $_query_string as $q_param => $q_val ) {
						$q_param = trim( $q_param );
						$q_val   = trim( $q_val );

						// We are allowing or query string parameters without value!
						if ( ! empty( $q_param ) ) {
							$blocked_urls[ $_idx ]['query'][ $q_param ] = $q_val;
						}
					}
				}
			}
		}

		//if ($DEBUG == true) {
		//
		//	echo "request_url=[". $request_url ."]<br />";
		//	echo "request_url_query<pre>"; print_r($request_url_query); echo "</pre>";
		//
		//	echo "blocked_urls_action=[". $blocked_urls_action ."]<br />";
		//	echo "blocked_urls<pre>"; print_r($blocked_urls); echo "</pre>";
		//}

		$blocked_urls = apply_filters( 'wpmudev-chat-blocked-site-urls', $blocked_urls );
		if ( ! empty( $blocked_urls ) ) {

			//$blocked_urls_action = $wpmudev_chat->get_option('blocked_urls_action', $section);

			if ( $blocked_urls_action == "exclude" ) {
				foreach ( $blocked_urls as $_idx => $blocked_url ) {
					if ( $request_url == $blocked_url['url'] ) {
						if ( count( $blocked_url['query'] ) ) {
							// If our blocked URL contains more query string parameters than our current match then we knowit is not a match.
							if ( count( $blocked_url['query'] ) > count( $request_url_query ) ) {
								$_FLAG_BLOCK_CHAT = false;
							} else {
								foreach ( $blocked_url['query'] as $q_param => $q_val ) {
									if ( ! isset( $request_url_query[ $q_param ] ) ) {
										//$_FLAG_BLOCK_CHAT = false;
									} else if ( $request_url_query[ $q_param ] != $q_val ) {
										//$_FLAG_BLOCK_CHAT = false;
									} else {
										$_FLAG_BLOCK_CHAT = true;
									}
								}
							}
						} else {
							$_FLAG_BLOCK_CHAT = true;
						}
					}
					if ( $_FLAG_BLOCK_CHAT == true ) {
						break;
					}
				}
			} else if ( $blocked_urls_action == "include" ) {
				$_FLAG_BLOCK_CHAT = true;
				foreach ( $blocked_urls as $blocked_url ) {

					//if ($DEBUG == true) {
					//	echo "request_url AAA[". $request_url ."] [". $blocked_url['url']."]<br />";
					//}

					if ( $request_url == $blocked_url['url'] ) {
						//if ($DEBUG == true) {
						//	echo "request_url XXX[". $request_url ."] [". $blocked_url['url']."]<br />";
						//	echo "blocked_url query<pre>"; print_r($blocked_url['query']); echo "</pre>"; echo "</pre>";
						//}

						if ( count( $blocked_url['query'] ) ) {
							// If our blocked URL contains more query string parameters than our current match then we knowit is not a match.
							if ( count( $blocked_url['query'] ) > count( $request_url_query ) ) {
								$_FLAG_BLOCK_CHAT = false;
							} else {
								foreach ( $blocked_url['query'] as $q_param => $q_val ) {
									if ( ! isset( $request_url_query[ $q_param ] ) ) {
										$_FLAG_BLOCK_CHAT = false;
									} else if ( $request_url_query[ $q_param ] != $q_val ) {
										$_FLAG_BLOCK_CHAT = false;
									}
								}
							}
						} else {
							$_FLAG_BLOCK_CHAT = false;
						}
					}
					if ( $_FLAG_BLOCK_CHAT == false ) {
						break;
					}

				}
			}
		}

		//if ($DEBUG == true) {
		//	if ($_FLAG_BLOCK_CHAT == true)
		//		echo "_FLAG_BLOCK_CHAT=true<br />";
		//	else
		//		echo "_FLAG_BLOCK_CHAT=false<br />";
		//}
	}

	return $_FLAG_BLOCK_CHAT;
}

function wpmudev_chat_start_performance( $chat_performance = array() ) {
	if ( ! defined( 'SAVEQUERIES' ) ) {
		define( 'SAVEQUERIES', true );
	}
	$chat_performance['time_start']           = microtime( true );
	$chat_performance['memory_limit']         = ini_get( 'memory_limit' );
	$chat_performance['memory_start']         = memory_get_usage();
	$chat_performance['number_queries_start'] = get_num_queries();

	return $chat_performance;
}

function wpmudev_chat_end_performance( $chat_performance = array() ) {
	$chat_performance['time_end']              = microtime( true );
	$chat_performance['memory_end']            = memory_get_usage();
	$chat_performance['memory_get_peak_usage'] = memory_get_peak_usage();
	$chat_performance['number_queries_end']    = get_num_queries();

	global $wpdb;
	$chat_performance['queries'] = $wpdb->queries;


	$chat_performance['time_summary'] = number_format( $chat_performance['time_end'] - $chat_performance['time_start'], 4 );

	$chat_performance['memory_summary']        = wpmudev_chat_utility_size_format( $chat_performance['memory_end'] - $chat_performance['memory_start'], 4 );
	$chat_performance['memory_limit']          = wpmudev_chat_utility_size_format( $chat_performance['memory_limit'], 4 );
	$chat_performance['memory_start']          = wpmudev_chat_utility_size_format( $chat_performance['memory_start'], 4 );
	$chat_performance['memory_end']            = wpmudev_chat_utility_size_format( $chat_performance['memory_end'], 4 );
	$chat_performance['memory_get_peak_usage'] = wpmudev_chat_utility_size_format( $chat_performance['memory_get_peak_usage'], 4 );

	$chat_performance['number_queries_summary'] = $chat_performance['number_queries_end'] - $chat_performance['number_queries_start'];

	return $chat_performance;
}

function wpmudev_chat_utility_size_format( $bytes = 0, $precision = 2 ) {
	$kilobyte = 1000;
	$megabyte = $kilobyte * 1000;
	$gigabyte = $megabyte * 1000;
	$terabyte = $gigabyte * 1000;

	if ( ( $bytes >= 0 ) && ( $bytes < $kilobyte ) ) {
		return $bytes . 'b';

	} elseif ( ( $bytes >= $kilobyte ) && ( $bytes < $megabyte ) ) {
		return round( $bytes / $kilobyte, $precision ) . 'kb';

	} elseif ( ( $bytes >= $megabyte ) && ( $bytes < $gigabyte ) ) {
		return round( $bytes / $megabyte, $precision ) . 'M';

	} elseif ( ( $bytes >= $gigabyte ) && ( $bytes < $terabyte ) ) {
		return round( $bytes / $gigabyte, $precision ) . 'G';

	} elseif ( $bytes >= $terabyte ) {
		return round( $bytes / $terabyte, $precision ) . 'T';
	} else {
		return $bytes . 'b';
	}
}


/**
 * When using the chat AJAX (wp-content/plugins/wordpress-chat/wpmudev-chat-ajax.php) instead of the default (wp-admin/admin-ajax.php) hook we need
 * to store the path to wp-load.php. This config file created during the plugin activation will contain the path. It is verified here.
 *
 * @global    object $wpmudev_chat
 *
 * @param    string $section Section name of options to check: site, widget, etc.
 *
 * @return    true/false            true = URL is blocked. false = URL is not blocked.
 */
function wpmudev_chat_validate_config_file( $config_file = '' ) {
	if ( empty( $config_file ) ) {
		return false;
	}

	if ( ! file_exists( $config_file ) ) {
		return false;
	}

	$configs_array = file_get_contents( $config_file );
	if ( empty( $configs_array ) ) {
		return false;
	}

	$configs_array = unserialize( $configs_array );
	if ( ! is_array( $configs_array ) ) {
		return false;
	}

	if ( ( ! isset( $configs_array['ABSPATH'] ) ) || ( empty( $configs_array['ABSPATH'] ) ) ) {
		return false;
	}

	$configs_array['ABSPATH'] = base64_decode( $configs_array['ABSPATH'] );
	if ( ! file_exists( $configs_array['ABSPATH'] . '/wp-load.php' ) ) {
		return false;
	}

	return true;
}

function wpmudev_chat_get_active_sessions( $session_types = array( 'page' ) ) {
	global $wpdb, $blog_id;

	$chat_sessions = array();

	$session_types_str = '';
	foreach ( $session_types as $session_type_slug => $session_type_active ) {
		if ( $session_type_active == 'on' ) {
			if ( strlen( $session_types_str ) ) {
				$session_types_str .= ',';
			}
			$session_types_str .= "'" . $session_type_slug . "'";
		}
	}

	$sql_str      = $wpdb->prepare( "SELECT * FROM " . WPMUDEV_Chat::tablename( 'log' ) . " WHERE session_type IN (" . $session_types_str . ") AND archived=%s AND deleted=%s AND blog_id=%d", 'no', 'no', $blog_id );
	$active_chats = $wpdb->get_results( $sql_str );
	if ( ! empty( $active_chats ) ) {
		foreach ( $active_chats as $active_chat ) {
			$transient_key = "chat-session-" . $active_chat->chat_id . '-' . $active_chat->session_type;

			if ( defined( 'WP_CACHE' ) && WP_CACHE ) {
				$transient_data = get_option( $transient_key );
			}else{
				$transient_data = get_transient( $transient_key );
			}
			if ( ! empty( $transient_data ) ) {
				$chat_sessions[ $active_chat->chat_id ] = $transient_data;
			}
		}
	}

	return $chat_sessions;

}

function wpmudev_chat_get_active_sessions_users( $chat_sessions = array() ) {
	global $wpdb;

	$chat_sessions_users = array();

	foreach ( $chat_sessions as $chat_session ) {
		$sql_str = $wpdb->prepare( "SELECT count(*) FROM " . WPMUDEV_Chat::tablename( 'users' ) . " WHERE chat_id=%s AND blog_id=%d", $chat_session['id'], $chat_session['blog_id'] );
		//echo "sql_str[". $sql_str ."]<br />";
		$chat_sessions_users[ $chat_session['id'] ] = $wpdb->get_var( $sql_str );
	}

	//echo "chat_sessions_users<pre>"; print_r($chat_sessions_users); echo "</pre>";
	return $chat_sessions_users;
}

if ( ! class_exists( 'ChatLogger' ) ) {
	class ChatLogger {

		var $DEBUG;
		var $logFolder;
		var $logFileFull;
		var $item_key;
		var $data_item_key;
		var $log_fp;

		function __construct( $backupLogFolderFull ) {
			$this->logFolder = trailingslashit( $backupLogFolderFull );
			$this->logFile   = "chat_debug.log";
			$this->start_logger();
		}

		function ChatLogger() {
			$this->__construct();
		}

		function __destruct() {
			if ( $this->log_fp ) {
				fclose( $this->log_fp );
			}
		}

		function start_logger() {
			$this->logFileFull = $this->logFolder . "/" . $this->logFile;
			$this->log_fp      = fopen( $this->logFileFull, 'a' );
		}

		function get_log_filename() {
			return $this->logFileFull;
		}

		function log_message( $message ) {
			if ( $this->log_fp ) {
				$message_out = date( 'Y-m-d H:i:s' ) . ": " . getmypid() . ":" . $message . "\r\n";
				fwrite( $this->log_fp, $message_out );
				//echo $message_out;

				fflush( $this->log_fp );
			}
		}
	}
}

if ( defined( 'CHAT_DEBUG_LOG' ) ) {
	$chat_logger = new ChatLogger( ABSPATH );
}

function log_chat_message( $message ) {
	global $chat_logger;

	if ( is_object( $chat_logger ) ) {
		$chat_logger->log_message( $message );
	}
}