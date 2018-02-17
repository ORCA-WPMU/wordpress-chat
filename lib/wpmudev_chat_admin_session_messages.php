<?php

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

if ( ! class_exists( 'WPMUDEVChat_Session_Messages_Table' ) ) {
	class WPMUDEVChat_Session_Messages_Table extends WP_List_Table {

		//var $_parent;	// The parent Snapshot instance
		var $filters = array();
		var $item;
		var $log_item;

		var $moderator_names_loaded = false;
		var $moderator_names = array();

		var $user_names_loaded = false;
		var $user_names = array();

		function __construct() {
			global $status, $page;

			//Set parent defaults
			parent::__construct( array(
					'singular' => 'Message',     //singular name of the listed records
					'plural'   => 'Messages',    //plural name of the listed records
					'ajax'     => true        //does this table support ajax?
				)
			);

			$this->check_table_filters();
		}

		function get_table_classes() {
			return array( 'widefat', 'fixed', 'wpmudev-chat-session-messages-table' );
		}

		function get_bulk_actions() {
			global $wpmudev_chat;

			$actions = array(
				'hide'   => __( 'Hide', $wpmudev_chat->translation_domain ),
				'unhide' => __( 'Unhide', $wpmudev_chat->translation_domain )
			);

			if ( $this->log_item->archived == 'yes' ) {
				$actions['delete'] = __( 'Delete', $wpmudev_chat->translation_domain );
			}

			return $actions;
		}

		function check_table_filters() {
			global $wpdb, $blog_id;

			$this->filters = array();

			if ( isset( $_GET['lid'] ) ) {
				$this->filters['chat-log-id'] = intval( $_GET['lid'] );
			} else {
				$this->filters['chat-log-id'] = 0;
			}

			if ( isset( $_GET['chat_id'] ) ) {
				$this->filters['chat_id'] = esc_attr( $_GET['chat_id'] );
			} else {
				$this->filters['chat_id'] = 0;
			}

			if ( ( isset( $_GET['status'] ) ) && ( ! empty( $_GET['status'] ) ) ) {
				$this->filters['status'] = strtolower( esc_attr( $_GET['status'] ) );
				if ( $this->filters['status'] == "open" ) {
					$this->filters['status'] = 'no';
				} else if ( $this->filters['status'] == "archived" ) {
					$this->filters['status'] = 'yes';
				} else if ( $this->filters['status'] == "hidden" ) {
					$this->filters['status'] = 'hidden';
				} else {
					$this->filters['status'] = '';
				}

			} else {
				$this->filters['status'] = '';
			}

			if ( ( isset( $_GET['users'] ) ) && ( ! empty( $_GET['users'] ) ) ) {
				$this->filters['users'] = esc_attr( $_GET['users'] );
			} else {
				$this->filters['users'] = '';
			}

			if ( ( isset( $_GET['moderators'] ) ) && ( ! empty( $_GET['moderators'] ) ) ) {
				$this->filters['moderators'] = esc_attr( $_GET['moderators'] );
			} else {
				$this->filters['moderators'] = '';
			}

			if ( ( isset( $_GET['s'] ) ) && ( ! empty( $_GET['s'] ) ) ) {
				$this->filters['search'] = esc_attr( $_GET['s'] );
			} else {
				$this->filters['search'] = '';
			}

			if ( is_multisite() ) {
				if ( strncasecmp( $this->filters['chat_id'], 'private-', strlen( 'private-' ) ) === 0 ) {
					$this->filters['blog_id'] = 0;
				} else if ( is_network_admin() ) {
					$this->filters['blog_id'] = 0;
				} else {
					$this->filters['blog_id'] = $blog_id;
				}
			} else {
				$this->filters['blog_id'] = $blog_id;
			}

			$sql_str = $wpdb->prepare( "SELECT * FROM " . WPMUDEV_Chat::tablename( 'log' ) . " WHERE id=%d", $this->filters['chat-log-id'] );
			if ( is_multisite() ) {
				$sql_str .= " AND blog_id=" . $this->filters['blog_id'];
			}
			$sql_str .= " LIMIT 1";
			$this->log_item = $wpdb->get_row( $sql_str );

			if ( $this->moderator_names_loaded == false ) {
				if ( $this->log_item->archived == 'no' ) {
					$sql_str = $wpdb->prepare( "SELECT name FROM " . WPMUDEV_Chat::tablename( 'message' ) . " WHERE moderator = %s AND chat_id = %s AND archived = %s GROUP BY name ORDER BY name", 'yes', $this->filters['chat_id'], 'no' );

				} else {
					$sql_str = $wpdb->prepare( "SELECT name FROM " . WPMUDEV_Chat::tablename( 'message' ) . " WHERE moderator = %s AND chat_id = %s AND log_id = %d GROUP BY name ORDER BY name", 'yes', $this->filters['chat_id'], $this->filters['chat-log-id'] );
				}
				$this->moderator_names        = $wpdb->get_col( $sql_str );
				$this->moderator_names_loaded = true;
			}

			if ( $this->user_names_loaded == false ) {
				if ( $this->log_item->archived == 'no' ) {
					$sql_str = $wpdb->prepare( "SELECT name FROM " . WPMUDEV_Chat::tablename( 'message' ) . " WHERE moderator = %s AND chat_id = %s AND archived = %s GROUP BY name ORDER BY name", 'no', $this->filters['chat_id'], 'no' );
				} else {
					$sql_str = $wpdb->prepare( "SELECT name FROM " . WPMUDEV_Chat::tablename( 'message' ) . " WHERE moderator = %s AND chat_id = %s AND log_id = %d GROUP BY name ORDER BY name", 'no', $this->filters['chat_id'], $this->filters['chat-log-id'] );

				}
				//echo "sql_str=[". $sql_str ."]<br />";
				$this->user_names        = $wpdb->get_col( $sql_str );
				$this->user_names_loaded = true;
			}

			return $this->filters;
		}

		function extra_tablenav( $which ) {

			if ( $which == "top" ) {
				$HAS_FILTERS = false;

				?>
				<div class="alignleft actions"><?php

				$this->show_filters_chat_status();
				$this->show_filters_moderators();
				$this->show_filters_users();

				?></div><?php
				?>
				<input id="post-query-submit" class="button-secondary" type="submit" value="Filter" name="chat-filter"><?php
			}
		}

		function show_filters_chat_status() {
			global $wpmudev_chat;
			?>
			<select name="status" id="status">
				<option value=""><?php _e( 'Show All Status', $wpmudev_chat->translation_domain ); ?></option>
				<option <?php if ( 'archived' == $this->filters['status'] ) {
					echo ' selected="selected" ';
				} ?>
					value="archived"><?php _e( 'Archived', $wpmudev_chat->translation_domain ); ?></option>
				<option <?php if ( 'hidden' == $this->filters['status'] ) {
					echo ' selected="selected" ';
				} ?>
					value="hidden"><?php _e( 'Hidden', $wpmudev_chat->translation_domain ); ?></option>
			</select>
		<?php
		}

		function show_filters_moderators() {
			global $wpmudev_chat;

			if ( ( $this->moderator_names ) && ( count( $this->moderator_names ) ) ) {
				?>
				<select name="moderators" id="moderators">
					<option value=""><?php _e( 'Show All Moderators', $wpmudev_chat->translation_domain ); ?></option>
					<?php if ( $this->filters['users'] != '__NONE__' ) { ?>
						<option value="__NONE__" <?php selected( $this->filters['moderators'], '__NONE__' ) ?>><?php _e( 'Show No Moderators', $wpmudev_chat->translation_domain ); ?></option>
					<?php } ?>
					<?php
					foreach ( $this->moderator_names as $moderator_name ) {
						?>
						<option <?php selected( $this->filters['moderators'], urlencode( $moderator_name ) ) ?>
						value="<?php echo urlencode( $moderator_name ) ?>"><?php echo $moderator_name; ?></option><?php
					}
					?>
				</select>
			<?php
			}
		}

		function show_filters_users() {
			global $wpmudev_chat;

			if ( ( $this->user_names ) && ( count( $this->user_names ) ) ) {
				?>
				<select name="users" id="users">
					<option value=""><?php _e( 'Show All Users', $wpmudev_chat->translation_domain ); ?></option>
					<?php if ( $this->filters['moderators'] != '__NONE__' ) { ?>
						<option value="__NONE__" <?php selected( $this->filters['users'], '__NONE__' ) ?>><?php _e( 'Show No Users', $wpmudev_chat->translation_domain ); ?></option>
					<?php } ?>
					<?php
					foreach ( $this->user_names as $user_name ) {
						?>
						<option <?php if ( $user_name == $this->filters['users'] ) {
							echo ' selected="selected" ';
						} ?>
						value="<?php echo urlencode( $user_name ) ?>"><?php echo $user_name; ?></option><?php
					}
					?>
				</select>
			<?php
			}
		}

		function single_row_columns( $item ) {
			list( $columns, $hidden ) = $this->get_column_info();

			if ( $item->deleted == "yes" ) {
				$chat_log_class = " chat-log-deleted";
			} else {
				$chat_log_class = "";
			}

			foreach ( $columns as $column_name => $column_display_name ) {
				$class = "class='$column_name column-$column_name $chat_log_class'";

				$style = '';
				if ( in_array( $column_name, $hidden ) ) {
					$style = ' style="display:none;"';
				}

				$attributes = "$class$style";

				if ( 'cb' == $column_name ) {
					echo '<th scope="row" class="check-column ' . $chat_log_class . '">';
					echo $this->column_cb( $item );
					echo '</th>';
				} elseif ( method_exists( $this, 'column_' . $column_name ) ) {
					echo "<td $attributes>";
					echo call_user_func( array( &$this, 'column_' . $column_name ), $item );
					echo "</td>";
				} else {
					echo "<td $attributes>";
					echo $this->column_default( $item, $column_name );
					echo "</td>";
				}
			}
		}

		function highlight_search_term( $text ) {
			//$this->filters = $this->check_table_filters();
			if ( ( isset( $this->filters['search'] ) ) && ( ! empty( $this->filters['search'] ) ) ) {
				$keys = implode( '|', explode( ' ', $this->filters['search'] ) );
				$text = preg_replace( '/(' . $keys . ')/iu', '<span class="chat-search-term">\0</span>', $text );
			}

			return $text;
		}


		function column_default( $item, $column_name ) {
			echo "&nbsp;";
		}

		function column_cb( $item ) {
			?><input type="checkbox" name="chat-messages-bulk[]" value="<?php echo $item->id; ?>" /><?php
		}

		function get_columns() {
			global $wpmudev_chat;

			$columns = array();

			$columns['cb']        = '<input type="checkbox" />';
			$columns['timestamp'] = __( 'Time', $wpmudev_chat->translation_domain );
			$columns['status']    = __( 'Status', $wpmudev_chat->translation_domain );
			$columns['user']      = __( 'User', $wpmudev_chat->translation_domain );
			$columns['message']   = __( 'Message', $wpmudev_chat->translation_domain );

			return $columns;
		}

		function column_timestamp( $item ) {
			global $wpmudev_chat;

			if ( isset( $wpmudev_chat->_chat_options_defaults[ $item->session_type ]['row_date_format'] ) ) {
				$row_date_format = $wpmudev_chat->_chat_options_defaults[ $item->session_type ]['row_date_format'];
			} else {
				$row_date_format = get_option( 'date_format' );
			}

			if ( isset( $wpmudev_chat->_chat_options_defaults[ $item->session_type ]['row_time_format'] ) ) {
				$row_time_format = $wpmudev_chat->_chat_options_defaults[ $item->session_type ]['row_time_format'];
			} else {
				$row_time_format = get_option( 'time_format' );
			}

			$date_str = date_i18n( $row_date_format, strtotime( $item->timestamp ) + get_option( 'gmt_offset' ) * 3600, false );
			$date_str .= " ";
			$date_str .= date_i18n( $row_time_format, strtotime( $item->timestamp ) + get_option( 'gmt_offset' ) * 3600, false );

			echo $date_str;

			$chat_href = esc_url_raw( remove_query_arg( array( '_wpnonce', 'maction', 'message' ) ) );

			$chat_href = add_query_arg( 'mid', $item->id, $chat_href );
			$chat_href = add_query_arg( '_wpnonce', wp_create_nonce( 'chat-message-item' ), $chat_href );

			$details_array = array();


			$chat_href_tmp = remove_query_arg( array( 's' ), $chat_href );

			if ( $item->session_type != 'private' ) {
				if ( $item->deleted == 'no' ) {
					$chat_hide_href        = add_query_arg( 'maction', 'hide', $chat_href_tmp );
					$details_array['hide'] = array(
						'label' => __( 'hide', $wpmudev_chat->translation_domain ),
						'title' => __( 'Hide this chat message from public view', $wpmudev_chat->translation_domain ),
						'href'  => $chat_hide_href
					);
				} else {
					$chat_unhide_href        = add_query_arg( 'maction', 'unhide', $chat_href_tmp );
					$details_array['unhide'] = array(
						'label' => __( 'unhide', $wpmudev_chat->translation_domain ),
						'title' => __( 'Unhide this chat message allowing public view', $wpmudev_chat->translation_domain ),
						'href'  => $chat_unhide_href
					);
				}
			}
			if ( $this->log_item->archived == 'yes' ) {
				$chat_delete_href        = add_query_arg( 'maction', 'delete', $chat_href_tmp );
				$details_array['delete'] = array(
					'label' => __( 'delete', $wpmudev_chat->translation_domain ),
					'title' => __( 'Delete this chat message permanently', $wpmudev_chat->translation_domain ),
					'href'  => $chat_delete_href
				);
			}
			?>
			<div class="row-actions" style="margin:0; padding:0;"><?php
				$details_link_str = '';
				foreach ( $details_array as $key => $link ) {
					if ( ! empty( $details_link_str ) ) {
						$details_link_str .= ' | ';
					}

					$details_link_str .= '<span class="' . $key . '"><a href="' . $link['href'] . '" title="' . $link['title'] . '">' . $link['label'] . '</a></span>';
				}
				echo $details_link_str;

				?></div>
		<?php
		}

		function column_user( $item ) {
			if ( $item->moderator == 'yes' ) {
				$chat_user_moderator_class = ' chat-user-moderator ';
			} else {
				$chat_user_moderator_class = '';
			}
			echo '<span class="chat-user-avatar ' . $chat_user_moderator_class . '">' . get_avatar( $item->avatar, 32 ) . '</span><span class="chat-user-name ' . $chat_user_moderator_class . '">' . $item->name . '</span><br /><span class="chat-ip-address ' . $chat_user_moderator_class . '">' . $item->ip_address . '</span>';
		}

		function column_status( $item ) {
			global $wpmudev_chat;

			if ( $item->archived == "yes" ) {
				if ( $item->deleted == "yes" ) {
					_e( 'Hidden', $wpmudev_chat->translation_domain );
				} else {
					_e( 'Archived', $wpmudev_chat->translation_domain );
				}
			} else if ( $item->archived == "no" ) {
				_e( 'Open', $wpmudev_chat->translation_domain );
			}
		}

		function column_message( $item ) {
			global $wpmudev_chat;

			echo $this->highlight_search_term( stripslashes( $item->message ) );
		}

		function column_blog( $item ) {

			if ( isset( $item->blog_id ) ) {
				$blog = get_blog_details( $item->blog_id );
				if ( $blog ) {
					echo $blog->blogname . "<br /> (" . $blog->domain . ")";
				} else {
					echo "&nbsp;";
				}
			} else {
				echo "&nbsp;";
			}
		}

		function get_hidden_columns() {
			$screen = get_current_screen();
			$hidden = get_hidden_columns( $screen );

			// Don't want the user to hide the 'File' column
			//$file_idx = array_search('file', $hidden);
			//if ($file_idx !== false) {
			//	unset($hidden[$file_idx]);
			//}

			return $hidden;
		}

		function get_sortable_columns() {

			$sortable_columns = array();

			return $sortable_columns;
		}

		function display() {
			extract( $this->_args );
			$this->display_tablenav( 'top' );
			?>
			<table class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>" cellspacing="0">
				<thead>
				<tr>
					<?php $this->print_column_headers(); ?>
				</tr>
				</thead>
				<tbody id="the-list"<?php if ( $singular ) {
					echo " class='list:$singular'";
				} ?>>
				<?php $this->display_rows_or_placeholder(); ?>
				</tbody>
				<tfoot>
				<tr>
					<?php $this->print_column_headers( false ); ?>
				</tr>
				</tfoot>
			</table>
			<?php
			$this->display_tablenav( 'bottom' );
		}


		function prepare_items() {
			global $wpdb, $blog_id;

			$columns  = $this->get_columns();
			$hidden   = $this->get_hidden_columns();
			$sortable = $this->get_sortable_columns();

			$this->_column_headers = array( $columns, $hidden, $sortable );

			$current_page = $this->get_pagenum();

			$per_page = get_user_meta( get_current_user_id(), 'chat_page_chat_session_messages_per_page', true );
			//echo "per_page[". $per_page ."]<br />";
			if ( ( ! $per_page ) || ( $per_page < 1 ) ) {
				$per_page = 20;
			}

			$current_page = $this->get_pagenum();
			$page_offset  = ( $current_page - 1 ) * intval( $per_page );

			if ( empty( $this->filters['chat-log-id'] ) ) {
				return;
			}

			if ( $this->log_item->archived == 'no' ) {
				$sql_str = $wpdb->prepare( "SELECT * FROM " . WPMUDEV_Chat::tablename( 'message' ) . " WHERE blog_id = %d AND chat_id = %s AND log_id=%d", $this->filters['blog_id'], $this->filters['chat_id'], $this->log_item->id );
			} else {
				$sql_str = $wpdb->prepare( "SELECT * FROM " . WPMUDEV_Chat::tablename( 'message' ) . " WHERE blog_id = %d AND chat_id = %s AND log_id=%d", $this->filters['blog_id'], $this->filters['chat_id'], $this->log_item->id );
			}

			if ( ! empty( $this->filters['search'] ) ) {
				$sql_str .= " AND message like '%" . $this->filters['search'] . "%'";
			}

			if ( ( isset( $this->filters['status'] ) ) && ( ! empty( $this->filters['status'] ) ) ) {
				if ( $this->filters['status'] == "hidden" ) {
					$sql_str .= " AND `deleted` ='yes' ";
				} else {
					//$sql_str .= " AND `archived` ='". $this->filters['status']."' ";
				}
			}

			$sql_str .= " AND `session_type` ='" . $this->log_item->session_type . "' ";

			$names_array = array();

			if ( ( isset( $this->filters['moderators'] ) ) && ( ! empty( $this->filters['moderators'] ) ) ) {
				if ( $this->filters['moderators'] != '__NONE__' ) {
					$names_array = array_merge( $names_array, array( urldecode( $this->filters['moderators'] ) ) );
				}
			} else {
				$names_array = array_merge( $this->moderator_names, $names_array );
			}

			if ( ( isset( $this->filters['users'] ) ) && ( ! empty( $this->filters['users'] ) ) ) {
				if ( $this->filters['users'] != '__NONE__' ) {
					$names_array = array_merge( $names_array, array( urldecode( $this->filters['users'] ) ) );
				}
			} else {
				$names_array = array_merge( $names_array, $this->user_names );
			}
			$names_array = array_unique( $names_array );

			if ( count( $names_array ) ) {
				$names_str = '';
				foreach ( $names_array as $name ) {
					if ( ! empty( $names_str ) ) {
						$names_str .= ",";
					}
					$names_str .= "'" . addslashes( $name ) . "'";
				}
				$sql_str .= " AND name IN(" . $names_str . ") ";
			}

			$sql_str .= " ORDER BY timestamp ASC";
			//echo "sql_str[". $sql_str ."]<br />";
			$items = $wpdb->get_results( $sql_str );
			if ( $items ) {
				if ( count( $items ) ) {
					$total_items = count( $items );
					//echo "total_items=[". $total_items ."]<br />";
					//echo "per_page[". $per_page ."]<br />";
					$this->items = array_slice( $items, $per_page * ( intval( $current_page ) - 1 ), intval( $per_page ), true );

					$this->set_pagination_args( array(
							'total_items' => $total_items,
							// WE have to calculate the total number of items
							'per_page'    => intval( $per_page ),
							// WE have to determine how many items to show on a page
							'total_pages' => ceil( intval( $total_items ) / intval( $per_page ) )
							// WE have to calculate the total number of pages
						)
					);
				}
				$total_items = count( $items );


			}
		}
	}
}