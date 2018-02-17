<?php
if (!class_exists('WPMUDEVChatWidget')) {

	class WPMUDEVChatWidget extends WP_Widget {

		var $defaults = array();

		function __construct () {
			global $wpmudev_chat;

			// Set defaults
			// ...
			$this->defaults = array(
				'box_title' 		=> 	'',
				'id'				=>	'',
				'box_height'		=>	'300px',
				'box_sound'			=>	'disabled',
				'row_name_avatar'	=>	'avatar',
				'box_emoticons'		=>	'disabled',
				'row_date'			=>	'disabled',
				'row_date_format'	=>	get_option('date_format'),
				'row_time'			=>	'disabled',
				'row_time_format'	=>	get_option('time_format'),
			);

			$widget_ops = array('classname' => __CLASS__, 'description' => __('WordPress Chat Widget.', $wpmudev_chat->translation_domain));
			parent::__construct(__CLASS__, __('WordPress Chat Widget', $wpmudev_chat->translation_domain), $widget_ops);
		}

		function WPMUDEVChatWidget () {
			$this->__construct();
		}

		function convert_settings_keys($instance) {

			if (isset($instance['title'])) {
				$instance['box_title'] = $instance['title'];
				unset($instance['title']);
			}

			if (isset($instance['height'])) {
				$instance['box_height'] = $instance['height'];
				unset($instance['height']);
			}

			if (isset($instance['sound'])) {
				$instance['box_sound'] = $instance['sound'];
				unset($instance['sound']);
			}

			if (isset($instance['avatar'])) {
				$instance['row_name_avatar'] = $instance['avatar'];
				unset($instance['avatar']);
			}

			return $instance;
		}

		function form($instance) {
			global $wpmudev_chat;

			$instance = wp_parse_args( $this->convert_settings_keys($instance), $this->defaults );
			//echo "instance<pre>"; print_r($instance); echo "</pre>";

			//if (empty($instance['height'])) {
			//	$instance['height'] = "300px";
			//}

			?>
			<input type="hidden" name="<?php echo $this->get_field_name('id'); ?>" id="<?php echo $this->get_field_id('id'); ?>"
				class="widefat" value="<?php echo $instance['id'] ?> "/>
			<p>
				<label for="<?php echo $this->get_field_id('box_title') ?>"><?php _e('Title:', $wpmudev_chat->translation_domain); ?></label>
				<input type="text" name="<?php echo $this->get_field_name('box_title'); ?>" id="<?php echo $this->get_field_id('box_title'); ?>"
					class="widefat" value="<?php echo $instance['box_title'] ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'box_height' ); ?>"><?php
					_e('Height for widget:', $wpmudev_chat->translation_domain); ?></label>

				<input type="text" id="<?php echo $this->get_field_id( 'box_height' ); ?>" value="<?php echo $instance['box_height']; ?>"
					name="<?php echo $this->get_field_name( 'box_height'); ?>" class="widefat" style="width:100%;" />
					<span class="description"><?php _e('The width will be 100% of the widget area', $wpmudev_chat->translation_domain); ?></span>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'box_sound' ); ?>"><?php
										_e('Enable Sound', $wpmudev_chat->translation_domain); ?></label><br />
				<select id="<?php echo $this->get_field_id( 'box_sound' ); ?>" name="<?php echo $this->get_field_name('box_sound'); ?>">
					<option value="enabled" <?php print ($instance['box_sound'] == 'enabled')?'selected="selected"':''; ?>><?php
						_e("Enabled", $wpmudev_chat->translation_domain); ?></option>
					<option value="disabled" <?php print ($instance['box_sound'] == 'disabled')?'selected="selected"':''; ?>><?php
						_e("Disabled", $wpmudev_chat->translation_domain); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'row_name_avatar' ); ?>"><?php _e("Show Avatar/Name", $wpmudev_chat->translation_domain); ?></label><br />
				<select id="<?php echo $this->get_field_id( 'row_name_avatar' ); ?>" name="<?php echo $this->get_field_name( 'row_name_avatar' ); ?>" >
					<option value="avatar" <?php print ($instance['row_name_avatar'] == 'avatar')?'selected="selected"':''; ?>><?php
					 	_e("Avatar", $wpmudev_chat->translation_domain); ?></option>
					<option value="name" <?php print ($instance['row_name_avatar'] == 'name')?'selected="selected"':''; ?>><?php
						_e("Name", $wpmudev_chat->translation_domain); ?></option>
					<option value="name-avatar" <?php print ($instance['row_name_avatar'] == 'name-avatar')?'selected="selected"':''; ?>><?php
					 	_e("Avatar and Name", $wpmudev_chat->translation_domain); ?></option>
					<option value="disabled" <?php print ($instance['row_name_avatar'] == 'disabled')?'selected="selected"':''; ?>><?php
					 	_e("None", $wpmudev_chat->translation_domain); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'box_emoticons' ); ?>"><?php
										_e('Show Emoticons', $wpmudev_chat->translation_domain); ?></label><br />
				<select id="<?php echo $this->get_field_id( 'box_emoticons' ); ?>" name="<?php echo $this->get_field_name( 'box_emoticons'); ?>">
					<option value="enabled" <?php print ($instance['box_emoticons'] == 'enabled')?'selected="selected"':''; ?>><?php
						_e("Enabled", $wpmudev_chat->translation_domain); ?></option>
					<option value="disabled" <?php print ($instance['box_emoticons'] == 'disabled')?'selected="selected"':''; ?>><?php
						_e("Disabled", $wpmudev_chat->translation_domain); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'row_date' ); ?>"><?php
										_e('Show Date', $wpmudev_chat->translation_domain); ?></label><br />
				<select id="<?php echo $this->get_field_id( 'row_date' ); ?>" name="<?php echo $this->get_field_name( 'row_date'); ?>">
					<option value="enabled" <?php print ($instance['row_date'] == 'enabled')?'selected="selected"':''; ?>><?php
						_e("Enabled", $wpmudev_chat->translation_domain); ?></option>
					<option value="disabled" <?php print ($instance['row_date'] == 'disabled')?'selected="selected"':''; ?>><?php
						_e("Disabled", $wpmudev_chat->translation_domain); ?></option>
				</select> <input id="<?php echo $this->get_field_id( 'row_date_format' ); ?>" type="text" style="width:100px;" name="<?php echo $this->get_field_name( 'row_date_format'); ?>" value="<?php echo $instance['row_date_format']; ?>"/>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'row_time' ); ?>"><?php
					_e('Show Time', $wpmudev_chat->translation_domain); ?></label><br />
				<select id="<?php echo $this->get_field_id( 'row_time' ); ?>" name="<?php echo $this->get_field_name( 'row_time'); ?>">
					<option value="enabled" <?php print ($instance['row_time'] == 'enabled')?'selected="selected"':''; ?>><?php
						_e("Enabled", $wpmudev_chat->translation_domain); ?></option>
					<option value="disabled" <?php print ($instance['row_time'] == 'disabled')?'selected="selected"':''; ?>><?php
						_e("Disabled", $wpmudev_chat->translation_domain); ?></option>
				</select> <input id="<?php echo $this->get_field_id( 'row_time_format' ); ?>" type="text" style="width:100px;" name="<?php echo $this->get_field_name( 'row_time_format'); ?>" value="<?php echo $instance['row_time_format']; ?>"/>
			</p>
			<p><?php _e('More control over widgets options via', $wpmudev_chat->translation_domain)?> <a
				href="<?php echo admin_url( 'admin.php?page=chat_settings_panel_widget'); ?>"><?php _e('Widget Settings Menu', $wpmudev_chat->translation_domain); ?></a></p>
			<?php
		}

		function update($new_instance, $old_instance) {
			global $wpmudev_chat;

			$instance = $old_instance;
			$instance = $this->convert_settings_keys($instance);

			if (isset($new_instance['box_title'])) {
				$instance['box_title'] 			= strip_tags($new_instance['box_title']);
			}

			if (isset($new_instance['box_height'])) {
				$instance['box_height'] 		= esc_attr($new_instance['box_height']);
			}

			if (isset($new_instance['box_sound']))
				{$instance['box_sound'] 			= esc_attr($new_instance['box_sound']);}

			if (isset($new_instance['row_name_avatar']))
				{$instance['row_name_avatar'] 	= esc_attr($new_instance['row_name_avatar']);}

			if (isset($new_instance['box_emoticons']))
				{$instance['box_emoticons'] 		= esc_attr($new_instance['box_emoticons']);}

			if (isset($new_instance['row_date']))
				{$instance['row_date'] 			= esc_attr($new_instance['row_date']);}

			if (isset($new_instance['row_date_format']))
				{$instance['row_date_format'] 	= esc_attr($new_instance['row_date_format']);}

			if (isset($new_instance['row_time']))
				{$instance['row_time'] 			= esc_attr($new_instance['row_time']);}

			if (isset($new_instance['row_time_format']))
				{$instance['row_time_format'] 	= esc_attr($new_instance['row_time_format']);}

			return $instance;
		}

		function widget($args, $instance) {
			global $wpmudev_chat, $post, $bp;

			if ($wpmudev_chat->get_option('blocked_on_shortcode', 'widget') == "enabled") {
				if (strstr($post->post_content, '[chat ') !== false)
					{return;}
			}

			if ((isset($bp->groups->current_group->id)) && (intval($bp->groups->current_group->id))) {

				// Are we viewing the Group Admin screen?
				$bp_group_admin_url_path 	= parse_url(bp_get_group_admin_permalink($bp->groups->current_group), PHP_URL_PATH);
				$request_url_path 			= parse_url(get_option('siteurl') . $_SERVER['REQUEST_URI'], PHP_URL_PATH);

				if ( (!empty($request_url_path)) && (!empty($bp_group_admin_url_path))
			  	  && (substr($request_url_path, 0, strlen($bp_group_admin_url_path)) == $bp_group_admin_url_path) ) {
					if ($wpmudev_chat->get_option('bp_group_admin_show_widget', 'global') != "enabled") {
						return;
					}
				} else {
					if ($wpmudev_chat->get_option('bp_group_show_widget', 'global') != "enabled") {
						return;
					}
				}
			}

			if ($wpmudev_chat->_chat_plugin_settings['blocked_urls']['widget'] != true) {

				$instance['id'] = $this->id;
				//echo "instance before<pre>"; print_r($instance); echo "</pre>";
				//die();
				$instance = wp_parse_args( $this->convert_settings_keys($instance), $this->defaults );
				//echo "instance<pre>"; print_r($instance); echo "</pre>";

				$instance['session_type'] = 'widget';
				$chat_output = $wpmudev_chat->process_chat_shortcode($instance);
				if (!empty($chat_output)) {
					echo $args['before_widget'];

					$title = apply_filters('widget_title', $instance['box_title']);
					if ($title) {echo $args['before_title'] . $title . $args['after_title'];}

					echo $chat_output;

					echo $args['after_widget'];
				}
			}
		}
	}
}

if (!class_exists('WPMUDEVChatFriendsWidget')) {

	class WPMUDEVChatFriendsWidget extends WP_Widget {

		var $defaults = array();
		var $plugin_error_message;

		function __construct () {
			global $wpmudev_chat;

			$this->defaults = array(
				'box_title' 		=> 	'',
				'height'			=>	'300px',
				'row_name_avatar'	=>	'avatar',
				'avatar_width'		=>	'25px'
			);

			$this->plugin_error_message = __('This widget requires either BuddyPress Friends enabled or Friends plugins.', $wpmudev_chat->translation_domain);

			// Set defaults
			// ...
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Shows Chat Friends and status. (Friends plugin required)', $wpmudev_chat->translation_domain));
			parent::__construct(__CLASS__, __('WordPress Chat Friends Widget', $wpmudev_chat->translation_domain), $widget_ops);
		}

		function WPMUDEVChatFriendsWidget () {
			$this->__construct();
		}

		function form($instance) {
			global $wpmudev_chat, $bp;

			if ((empty($bp)) && (!is_plugin_active('friends/friends.php'))
			 && ((is_multisite()) && (!is_plugin_active_for_network('friends/friends.php')))) {
				?><p class="error"><?php echo $this->plugin_error_message ;?></p><?php
			}
			$instance = wp_parse_args( $instance, $this->defaults );

			?>
			<p class="info"><?php _e('This widget will show information specific to the WordPress authenticated user. If the user is not authenticated the widget will not output anything.', $wpmudev_chat->translation_domain);?></p>
			<input type="hidden" name="<?php echo $this->get_field_name('id'); ?>" id="<?php echo $this->get_field_id('id'); ?>"
				class="widefat" value="<?php echo $instance['id'] ?> "/>
			<p>
				<label for="<?php echo $this->get_field_id('box_title') ?>"><?php _e('Title:', $wpmudev_chat->translation_domain); ?></label>
				<input type="text" name="<?php echo $this->get_field_name('box_title'); ?>" id="<?php echo $this->get_field_id('box_title'); ?>"
					class="widefat" value="<?php echo $instance['box_title'] ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php
					_e('Height for widget:', $wpmudev_chat->translation_domain); ?></label>

				<input type="text" id="<?php echo $this->get_field_id( 'height' ); ?>" value="<?php echo $instance['height']; ?>"
					name="<?php echo $this->get_field_name( 'height'); ?>" class="widefat" style="width:100%;" />
					<span class="description"><?php _e('The widget will scroll output when needed.', $wpmudev_chat->translation_domain); ?></span>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'row_name_avatar' ); ?>"><?php _e("Show Avatar/Name", $wpmudev_chat->translation_domain); ?></label><br />
				<select id="<?php echo $this->get_field_id( 'row_name_avatar' ); ?>" name="<?php echo $this->get_field_name( 'row_name_avatar' ); ?>" >
					<option value="avatar" <?php print ($instance['row_name_avatar'] == 'avatar')?'selected="selected"':''; ?>><?php
					 	_e("Avatar", $wpmudev_chat->translation_domain); ?></option>
					<option value="name" <?php print ($instance['row_name_avatar'] == 'name')?'selected="selected"':''; ?>><?php
						_e("Name", $wpmudev_chat->translation_domain); ?></option>
					<option value="name-avatar" <?php print ($instance['row_name_avatar'] == 'name-avatar')?'selected="selected"':''; ?>><?php
					 	_e("Avatar and Name", $wpmudev_chat->translation_domain); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'avatar_width' ); ?>"><?php
					_e('Avatar width/height:', $wpmudev_chat->translation_domain); ?></label>

				<input type="text" id="<?php echo $this->get_field_id( 'avatar_width' ); ?>" value="<?php echo $instance['avatar_width']; ?>"
					name="<?php echo $this->get_field_name( 'avatar_width'); ?>" class="widefat" style="width:100%;" />
			</p>

			<?php
		}

		function update($new_instance, $old_instance) {
			global $wpmudev_chat;

			$instance = $old_instance;

			if (isset($new_instance['box_title']))
				{$instance['box_title'] 			= strip_tags($new_instance['box_title']);}

			if (isset($new_instance['height']))
				{$instance['height'] 		= esc_attr($new_instance['height']);}

			if (isset($new_instance['row_name_avatar']))
				{$instance['row_name_avatar'] 	= esc_attr($new_instance['row_name_avatar']);}


			if (isset($new_instance['avatar_width']))
				{$instance['avatar_width'] 		= esc_attr($new_instance['avatar_width']);}

			return $instance;
		}

		function widget($args, $instance) {
			global $wpmudev_chat, $bp, $current_user;

			if (!$current_user->ID) {return;}

			// IF we are blocking the Widgets from Chat
			if ($wpmudev_chat->_chat_plugin_settings['blocked_urls']['widget'] == true) {
				return;
			}

			// If BuddyPress or Friends plugins is not active
			if ((empty($bp)) && (!is_plugin_active('friends/friends.php'))
			 && ((is_multisite()) && (!is_plugin_active_for_network('friends/friends.php')))) {
				 return;
			}

			$friends_list_ids = array();

			if ((!empty($bp)) && (function_exists('bp_get_friend_ids'))) {
				$friends_ids = bp_get_friend_ids($bp->loggedin_user->id);
				if (!empty($friends_ids)) {
					$friends_list_ids = explode(',', $friends_ids);
				}

			} else {

				if ((!is_admin()) && (!function_exists('is_plugin_active'))) {
					include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				if (!is_plugin_active('friends/friends.php')) {
					if ((is_multisite()) && (!is_plugin_active_for_network('friends/friends.php'))) {
						return;
					}
				}
				if (!function_exists('friends_get_list')) {return;}

				$friends_list_ids = friends_get_list($current_user->ID);
			}

			if ((!is_array($friends_list_ids)) || (!count($friends_list_ids))) {
				return;
			}

			if ($wpmudev_chat->_chat_plugin_settings['blocked_urls']['widget'] == true)
				{return;}

			$instance['id'] = $this->id;
			$instance = wp_parse_args( $instance, $this->defaults );

			$chat_output = '';

			$friends_status = wpmudev_chat_get_friends_status($current_user->ID, $friends_list_ids);
			if ( ($friends_status) && (is_array($friends_status)) && (count($friends_status)) ) {
				foreach($friends_status as $friend) {
					if ((isset($friend->chat_status)) && ($friend->chat_status == "available")) {
						$friend_status_data = wpmudev_chat_get_chat_status_data($current_user->ID, $friend);

						$chat_output .= '<li><a class="'. $friend_status_data['href_class'] .'" title="'. $friend_status_data['href_title'] .' - '. __('Click to start private chat session', $wpmudev_chat->translation_domain) .'" href="#" rel="'.md5($friend->ID) .'">';

						//$chat_output .= '<span class="wpmudev-chat-ab-icon wpmudev-chat-ab-icon-'. $friend->chat_status .'"></span>';

						if (($instance['row_name_avatar'] == "name-avatar") || ($instance['row_name_avatar'] == "avatar")) {
							$friend->avatar	= get_avatar($friend->ID, intval($instance['avatar_width']), get_option('avatar_default'), $friend->display_name);
							if (!empty($friend->avatar)) {
								$chat_output .= '<span class="wpmudev-chat-friend-avatar">'. $friend->avatar .'</span>';
							}
						}
						if ($instance['row_name_avatar'] == "name-avatar") {
							$chat_name_spacer_style = ' style="margin-left: 3px;" ';
						} else {
							$chat_name_spacer_style = '';
						}
						if (($instance['row_name_avatar'] == "name-avatar") || ($instance['row_name_avatar'] == "name")) {
							$chat_output .= '<span '. $chat_name_spacer_style .' class="wpmudev-chat-ab-label">'. $friend->display_name .'</span>';
						}
						$chat_output .= '</a></li>';
					}
				}
				if (!empty($chat_output)) {
					if ((isset($instance['height'])) && (!empty($instance['height']))) {
						$height_style = ' style="max-height: '. $instance['height'] .'; overflow:auto;" ';
					} else {
						$height_style = '';
					}
					$chat_output = '<ul id="wpmudev-chat-friends-widget-'. $this->number .'" '. $height_style .' class="wpmudev-chat-friends-widget">'. $chat_output .'</ul>';
				}

			} else {
				$chat_output = '<p>'. __("No Friends online.", $wpmudev_chat->translation_domain) .'</p>';
			}

			if (!empty($chat_output)) {
				echo $args['before_widget'];

				$title = apply_filters('widget_title', $instance['box_title']);
				if ($title) {echo $args['before_title'] . $title . $args['after_title'];}

				echo $chat_output;

				echo $args['after_widget'];
			}
		}
	}
}


if (!class_exists('WPMUDEVChatRoomsWidget')) {

	class WPMUDEVChatRoomsWidget extends WP_Widget {

		var $defaults = array();
		var $plugin_error_message;

		function __construct () {
			global $wpmudev_chat, $bp;

			$this->defaults = array(
				'box_title' 				=> 	__('Chat Rooms', $wpmudev_chat->translation_domain),
				'height'					=>	'300px',
				'show_active_user_count'	=>	'enabled',
				'show_title'				=>	'chat',
				'session_types'				=>	array(
					'page'		=>	'on',
				),
				'session_types_labels'		=>	array(
					'page'		=>	__('Page', $wpmudev_chat->translation_domain),
				)

			);

			if ((!empty($bp)) && (is_object($bp))) {
				$this->defaults['session_types_labels']['bp-group'] =	__('BuddyPress Group', $wpmudev_chat->translation_domain);
				$this->defaults['session_types']['bp-group'] 		=	'on';
			}

			$this->plugin_error_message = __('This widget requires either BuddyPress Friends enabled or Friends plugins.', $wpmudev_chat->translation_domain);

			// Set defaults
			// ...
			$widget_ops = array('classname' => __CLASS__, 'description' => __('Shows Active Chats Sessions across site.', $wpmudev_chat->translation_domain));
			parent::__construct(__CLASS__, __('WordPress Chat Rooms', $wpmudev_chat->translation_domain), $widget_ops);
		}

		function WPMUDEVChatRoomsWidget () {
			$this->__construct();
		}

		function form($instance) {
			global $wpmudev_chat, $bp;

			$session_types = $instance['session_types'];
			$instance = wp_parse_args( $instance, $this->defaults );
			$instance['session_types'] = $session_types;

			?>
			<p class="info"><?php _e('This widget will show all active chat sessions across the site.', $wpmudev_chat->translation_domain);?></p>
			<input type="hidden" name="<?php echo $this->get_field_name('id'); ?>" id="<?php echo $this->get_field_id('id'); ?>"
				class="widefat" value="<?php echo $instance['id'] ?> "/>
			<p>
				<label for="<?php echo $this->get_field_id('box_title') ?>"><?php _e('Title:', $wpmudev_chat->translation_domain); ?></label>
				<input type="text" name="<?php echo $this->get_field_name('box_title'); ?>" id="<?php echo $this->get_field_id('box_title'); ?>"
					class="widefat" value="<?php echo $instance['box_title'] ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php
					_e('Height for widget:', $wpmudev_chat->translation_domain); ?></label>

				<input type="text" id="<?php echo $this->get_field_id( 'height' ); ?>" value="<?php echo $instance['height']; ?>"
					name="<?php echo $this->get_field_name( 'height'); ?>" class="widefat" style="width:100%;" />
					<span class="description"><?php _e('The widget will scroll output when needed.', $wpmudev_chat->translation_domain); ?></span>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'show_active_user_count' ); ?>"><?php
										_e('Show Active User Count', $wpmudev_chat->translation_domain); ?></label><br />
				<select id="<?php echo $this->get_field_id( 'show_active_user_count' ); ?>" name="<?php echo $this->get_field_name('show_active_user_count'); ?>">
					<option value="enabled" <?php print ($instance['show_active_user_count'] == 'enabled')?'selected="selected"':''; ?>><?php
						_e("Enabled", $wpmudev_chat->translation_domain); ?></option>
					<option value="disabled" <?php print ($instance['show_active_user_count'] == 'disabled')?'selected="selected"':''; ?>><?php
						_e("Disabled", $wpmudev_chat->translation_domain); ?></option>
				</select>
			</p>

			<p><label for="<?php echo $this->get_field_id('session_types'); ?>"><?php _e('Include Session Types - must chose at least one'); ?></label><br />
				<ul>
				<?php

				if ((empty($bp)) || (!is_object($bp))) {
					if (isset($instance['session_types']['bp-group']))
						{unset($instance['session_types']['bp-group']);}
				}

				if (count($instance['session_types']) == 0) {
					$instance['session_types']['page'] = 'on';
				}

				foreach($this->defaults['session_types'] as $session_type_slug => $session_type_active) {
					?><li><input id="<?php echo $this->get_field_id('session_types'); ?>-<?php echo $session_type_slug ?>" name="<?php echo $this->get_field_name('session_types'); ?>[<?php echo $session_type_slug ?>]" type="checkbox" <?php
					checked($instance['session_types'][$session_type_slug], 'on', true)?> />&nbsp;<label for="<?php echo $this->get_field_id('session_types'); ?>-<?php echo $session_type_slug ?>"><?php
					if (isset($this->defaults['session_types_labels'][$session_type_slug])) {
						echo $this->defaults['session_types_labels'][$session_type_slug];
					} else {
						echo $session_type_slug;
					}
					?></label></li><?php
				}
				?>
			</ul>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e('Show link title from Chat session or the Page/Group', $wpmudev_chat->translation_domain); ?></label><br />
				<select id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name('show_title'); ?>">
					<option value="page" <?php selected($instance['show_title'], 'page') ?>><?php
						_e("Page/Group", $wpmudev_chat->translation_domain); ?></option>
					<option value="chat" <?php selected($instance['show_title'], 'chat') ?>><?php
						_e("Chat Session", $wpmudev_chat->translation_domain); ?></option>
				</select>
			</p>


			<?php
		}

		function update($new_instance, $old_instance) {
			global $wpmudev_chat;

			//$instance = $old_instance;

			//echo "new_instance<pre>"; print_r($new_instance); echo "</pre>";

			if (isset($new_instance['box_title']))
				{$instance['box_title'] 			= strip_tags($new_instance['box_title']);}
			else

			if (isset($new_instance['height']))
				{$instance['height'] 			= esc_attr($new_instance['height']);}

			if (isset($new_instance['show_active_user_count']))
				{$instance['show_active_user_count'] 	= strip_tags($new_instance['show_active_user_count']);}

			if (isset($new_instance['session_types']))
				{$instance['session_types'] 		= $new_instance['session_types'];}

			if (isset($new_instance['show_title']))
				{$instance['show_title'] 		= esc_attr($new_instance['show_title']);}


			//echo "instance<pre>"; print_r($instance); echo "</pre>";
			//die();

			return $instance;
		}

		function widget($args, $instance) {
			global $wpmudev_chat, $bp, $current_user;

			if (!$current_user->ID) {return;}

			// IF we are blocking the Widgets from Chat
			if ($wpmudev_chat->_chat_plugin_settings['blocked_urls']['widget'] == true) {
				return;
			}

			// If BuddyPress or Friends plugins is not active
//			if ((empty($bp)) && (!is_plugin_active('friends/friends.php'))
//			 && ((is_multisite()) && (!is_plugin_active_for_network('friends/friends.php')))) {
//				 return;
//			}

			$instance['id'] = $this->id;

			$session_types = $instance['session_types'];
			$instance = wp_parse_args( $instance, $this->defaults );
			$instance['session_types'] = $session_types;

			if ((empty($bp)) || (!is_object($bp))) {
				if (isset($instance['session_types']['bp-group'])) {
					unset($instance['session_types']['bp-group']);
				}
			}

			$chat_output = '';

			$chat_sessions = wpmudev_chat_get_active_sessions($instance['session_types']);
			//echo "chat_sessions<pre>"; print_r($chat_sessions); echo "</pre>";

			if ((isset($instance['show_active_user_count'])) && ($instance['show_active_user_count'] == 'enabled')) {
				$chat_sessions_users = wpmudev_chat_get_active_sessions_users($chat_sessions);
				//echo "chat_sessions_users<pre>"; print_r($chat_sessions_users); echo "</pre>";
			}

			if (!empty($chat_sessions)) {
				echo $args['before_widget'];

				$title = apply_filters('widget_title', $instance['box_title']);
				if ($title) {echo $args['before_title'] . $title . $args['after_title'];}

				?><ul class="wpmudev-chat-active-chats-list"><?php
				foreach($chat_sessions as $chat_session) {
					?><li><a href="<?php
						if (isset($chat_session['session_url'])) {
							echo $chat_session['session_url'];
						} else {
							echo "#";
						}
					?>"><?php
					//echo "session_title[". $chat_session['session_title'] ."]<br />";
					//echo "session_url[". $chat_session['session_url'] ."]<br />";

					$link_title = '';
					if ((empty($link_title)) && ($instance['show_title'] == 'chat')
					 && (isset($chat_session['box_title'])) && (!empty($chat_session['box_title']))) {
						$link_title = $chat_session['box_title'];
					}

					if ((empty($link_title)) && ($instance['show_title'] == 'page')
					 && (isset($chat_session['session_title'])) && (!empty($chat_session['session_title']))) {
						$link_title = $chat_session['session_title'];
					}

					if (empty($link_title)) {
						$link_title = $chat_session['id'];
					}
					echo $link_title;
					?></a><?php

					if ((isset($instance['show_active_user_count'])) && ($instance['show_active_user_count'] == 'enabled')) {
						?> (<?php
						if (isset($chat_sessions_users[$chat_session['id']])) {
							echo $chat_sessions_users[$chat_session['id']];
						} else {
							echo "0";
						}
						?>)<?php
					}

					?></li><?php
				}
				?></ul><?php


				echo $args['after_widget'];
			}
		}
	}
}


if (!class_exists('WPMUDEVChatStatusWidget')) {

	class WPMUDEVChatStatusWidget extends WP_Widget {

		var $defaults = array();
		var $plugin_error_message;

		function __construct () {
			global $wpmudev_chat;

			$this->defaults = array(
				'box_title' 		=> 	'',
			);

			$widget_ops = array('classname' => __CLASS__, 'description' => __('This widget allows WordPress users to set their Chat status via a sidebar widget.', $wpmudev_chat->translation_domain));
			parent::__construct(__CLASS__, __('WordPress Chat Status', $wpmudev_chat->translation_domain), $widget_ops);
		}

		function WPMUDEVChatStatusWidget () {
			$this->__construct();
		}

		function form($instance) {
			global $wpmudev_chat;

			$instance = wp_parse_args( $instance, $this->defaults );

			?>
			<p class="info"><?php _e('This widget will show information specific to the WordPress authenticated user. If the user is not authenticated the widget will not output anything.', $wpmudev_chat->translation_domain);?></p>

			<input type="hidden" name="<?php echo $this->get_field_name('id'); ?>" id="<?php echo $this->get_field_id('id'); ?>"
				class="widefat" value="<?php echo $instance['id'] ?> "/>
			<p>
				<label for="<?php echo $this->get_field_id('box_title') ?>"><?php _e('Title:', $wpmudev_chat->translation_domain); ?></label>
				<input type="text" name="<?php echo $this->get_field_name('box_title'); ?>" id="<?php echo $this->get_field_id('box_title'); ?>"
					class="widefat" value="<?php echo $instance['box_title'] ?>" />
			</p>
			<?php
		}

		function update($new_instance, $old_instance) {
			//global $wpmudev_chat;

			$instance = $old_instance;

			if (isset($new_instance['box_title']))
				{$instance['box_title'] 			= strip_tags($new_instance['box_title']);}

			if (isset($new_instance['box_height']))
				{$instance['box_height'] 		= esc_attr($new_instance['box_height']);}

			return $instance;
		}

		function widget($args, $instance) {
			global $wpmudev_chat, $bp, $current_user;

			if (!$current_user->ID) {return;}

			// IF we are blocking the Widgets from Chat
			if ($wpmudev_chat->_chat_plugin_settings['blocked_urls']['widget'] == true) {
				return;
			}

			$chat_output = '';

			//echo "user-statuses<pre>"; print_r($wpmudev_chat->_chat_options['user-statuses']); echo "</pre>";
//			echo "current_user ID[". $current_user->ID ."]<br />";

			$chat_user_status = wpmudev_chat_get_user_status($current_user->ID);
//			echo "chat_user_status[". $chat_user_status ."]<br />";

			foreach($wpmudev_chat->_chat_options['user-statuses'] as $status_key => $status_label) {
				if ($status_key == $chat_user_status) {
					$selected = ' selected="selected" ';
				} else {
					$selected = '';
				}

				$class = '';
				if ($status_key == 'available')
					{$class .= ' available';}

				$chat_output .= '<option class="'. $class .'" value="'. $status_key .'" '. $selected .'>'. $status_label .'</option>';
			}

			if (!empty($chat_output)) {

				echo $args['before_widget'];

				$title = apply_filters('widget_title', $instance['box_title']);
				if ($title) {echo $args['before_title'] . $title . $args['after_title'];}

				echo '<select id="wpmudev-chat-status-widget-'. $this->number .'" class="wpmudev-chat-status-widget">'. $chat_output .'</select>';

				echo $args['after_widget'];
			}
		}
	}
}

function wpmudev_chat_widget_init_proc() {
	register_widget('WPMUDEVChatWidget');
	register_widget('WPMUDEVChatFriendsWidget');
	register_widget('WPMUDEVChatStatusWidget');
	register_widget('WPMUDEVChatRoomsWidget');
}
add_action( 'widgets_init', 'wpmudev_chat_widget_init_proc');

if (!class_exists('WPMUDEVChatDashboardWidget')) {

	class WPMUDEVChatDashboardWidget {
		var $instance = array();

		function __construct() {

			if (is_network_admin()) {
				if ( !function_exists( 'is_plugin_active_for_network' ) ) {
					require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
				}
				if (!is_plugin_active_for_network('wordpress-chat/wordpress-chat.php')) {return;}

				add_action( 'wp_network_dashboard_setup', array(&$this, 'wpmudev_chat_add_dashboard_widgets') );
			} else {
				add_action( 'wp_dashboard_setup', array(&$this, 'wpmudev_chat_add_dashboard_widgets') );
			}
		}

		function WPMUDEVChatDashboardWidget() {
			$this->__construct();
		}

		function wpmudev_chat_add_dashboard_widgets() {
			global $wpmudev_chat, $blog_id, $current_user;

			$this->instance = $wpmudev_chat->_chat_options['dashboard'];

			$user_meta = get_user_meta( $current_user->ID, 'wpmudev-chat-user', true );
			$user_meta = wp_parse_args( $user_meta, $wpmudev_chat->_chat_options_defaults['user_meta'] );

			if ($user_meta['chat_wp_admin'] == "enabled") {

				if (is_network_admin()) {

					if ((isset($this->instance['dashboard_widget'])) && ($this->instance['dashboard_widget'] == 'enabled')
					 && (isset($user_meta['chat_network_dashboard_widget'])) && ($user_meta['chat_network_dashboard_widget'] == 'enabled')) {

						$this->instance['id'] 					= 'dashboard-0';
						$this->instance['blog_id'] 				= 0;
						$this->instance['box_class']			= 'wpmudev-chat-dashboard-widget';
						$this->instance['session_status']		= 'open';

						if ((!isset($this->instance['dashboard_widget_title'])) || (empty($this->instance['dashboard_widget_title']))) {
							$this->instance['dashboard_widget_title'] = __('Chat', $wpmudev_chat->translation_domain);
						}

						if ((isset($user_meta['chat_dashboard_widget_height'])) && (!empty($user_meta['chat_dashboard_widget_height']))) {
							$this->instance['box_height'] = $user_meta['chat_dashboard_widget_height'];

						} else if ((!isset($this->instance['dashboard_widget_height'])) || (empty($this->instance['dashboard_widget_height']))) {
							$this->instance['box_height'] = $this->instance['dashboard_widget_height'];
						}

						wp_add_dashboard_widget(
							'wpmudev_chat_dashboard_widget',
							$this->instance['dashboard_widget_title'],
							array(&$this, 'wpmudev_chat_dashboard_widget_proc')
						);
					}
				} else {

					if ((isset($this->instance['dashboard_widget'])) && ($this->instance['dashboard_widget'] == 'enabled')
	 				 && (isset($user_meta['chat_dashboard_widget'])) && ($user_meta['chat_dashboard_widget'] == 'enabled')) {

						if (((isset($current_user->allcaps['level_10'])) && ($current_user->allcaps['level_10'] == 1))
						|| (array_intersect($this->instance['login_options'], $current_user->roles))) {

							$this->instance['id'] 					= 'dashboard-'.$blog_id;
							$this->instance['blog_id'] 				= $blog_id;
							$this->instance['box_class']			= 'wpmudev-chat-dashboard-widget';
							$this->instance['session_status']		= 'open';

							if ((!isset($this->instance['dashboard_widget_title'])) || (empty($this->instance['dashboard_widget_title']))) {
								$this->instance['dashboard_widget_title'] = __('Chat', $wpmudev_chat->translation_domain);
							}

							if ((isset($user_meta['chat_dashboard_widget_height'])) && (!empty($user_meta['chat_dashboard_widget_height']))) {
								$this->instance['box_height'] = $user_meta['chat_dashboard_widget_height'];

							} else if ((!isset($this->instance['dashboard_widget_height'])) || (empty($this->instance['dashboard_widget_height']))) {
								$this->instance['box_height'] = $this->instance['dashboard_widget_height'];
							}

							wp_add_dashboard_widget(
								'wpmudev_chat_dashboard_widget',
								$this->instance['dashboard_widget_title'],
								array(&$this, 'wpmudev_chat_dashboard_widget_proc')
								/* array(&$this, 'wpmudev_chat_dashboard_widget_controls_proc') */
							);
						}
					}
				}
			}
		}

		function wpmudev_chat_dashboard_widget_proc() {

			global $wpmudev_chat;

			$chat_output = $wpmudev_chat->process_chat_shortcode($this->instance);
			if (!empty($chat_output)) {
				echo $chat_output;
				?>
				<style>
					div#wpmudev_chat_dashboard_widget .inside { padding:0px; margin-top: 0;}
					div#wpmudev_chat_dashboard_widget .inside .wpmudev-chat-box { border:0px;}
					/* div#wpmudev_chat_dashboard_widget .inside .wpmudev-chat-box .wpmudev-chat-module-header { display:none;} */
					/* div#wpmudev_chat_dashboard_widget .inside .wpmudev-chat-box .wpmudev-chat-module-message-area .wpmudev-chat-send-meta { display:none;} */
				</style>
				<?php
			}
		}

		function wpmudev_chat_dashboard_widget_controls_proc() {
			global $wpmudev_chat;

			//echo "instance<pre>"; print_r($this->instance); echo "</pre>";
			?>
			<p><input id="wpmudev-chat-dashboard-widget-<?php echo $this->instance['id'] ?>-action-archive" type="checkbox" value="1"
				name="wpmudev-chat[dashboard-widget][<?php echo $this->instance['id'] ?>][action][archive]" /> <label
				for="wpmudev-chat-dashboard-widget-<?php echo $this->instance['id'] ?>-action-archive"><?php
					_e('Checked - Archive Chat Message', $wpmudev_chat->translation_domain); ?></label></p>
			<?php
		}
	}
	$wpmudev_chat_dashboard_idget = new WPMUDEVChatDashboardWidget();
}

if (!class_exists('WPMUDEVChatStatusDashboardWidget')) {

	class WPMUDEVChatStatusDashboardWidget {
		var $instance = array();

		function __construct() {

			if (is_network_admin()) {
				if ( !function_exists( 'is_plugin_active_for_network' ) ) {
					require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
				}
				if (!is_plugin_active_for_network('wordpress-chat/wordpress-chat.php')) {return;}

				add_action( 'wp_network_dashboard_setup', array(&$this, 'wpmudev_chat_add_dashboard_widgets') );
			} else {
				add_action( 'wp_dashboard_setup', array(&$this, 'wpmudev_chat_add_dashboard_widgets') );
			}
		}

		function WPMUDEVChatStatusDashboardWidget() {
			$this->__construct();
		}

		function wpmudev_chat_add_dashboard_widgets() {
			global $wpmudev_chat, $blog_id, $current_user;

			$this->instance = $wpmudev_chat->_chat_options['dashboard'];
			//echo "instance<pre>"; print_r($this->instance); echo "</pre>";

			$user_meta = get_user_meta( $current_user->ID, 'wpmudev-chat-user', true );
			$user_meta = wp_parse_args( $user_meta, $wpmudev_chat->_chat_options_defaults['user_meta'] );
			if ($user_meta['chat_wp_admin'] == "enabled") {

				if (is_network_admin()) {

					if ((isset($this->instance['dashboard_status_widget'])) && ($this->instance['dashboard_status_widget'] == 'enabled')
					 && (isset($user_meta['chat_network_dashboard_status_widget'])) && ($user_meta['chat_network_dashboard_status_widget'] == 'enabled')) {

						if ((!isset($this->instance['dashboard_status_widget_title'])) || (empty($this->instance['dashboard_status_widget_title']))) {
							$this->instance['dashboard_status_widget_title'] = __('WordPress Chat', $wpmudev_chat->translation_domain);
						}

						wp_add_dashboard_widget(
							'wpmudev_chat_dashboard_status_widget',
							$this->instance['dashboard_status_widget_title'],
							array(&$this, 'wpmudev_chat_status_dashboard_widget_proc')
						);
					}
				} else {

					if ((isset($this->instance['dashboard_status_widget'])) && ($this->instance['dashboard_status_widget'] == 'enabled')
					 && (isset($user_meta['chat_dashboard_status_widget'])) && ($user_meta['chat_dashboard_status_widget'] == 'enabled')) {

						//if (((isset($current_user->allcaps['level_10'])) && ($current_user->allcaps['level_10'] == 1))
						//	|| (array_intersect($this->instance['login_options'], $current_user->roles))) {

							if ((!isset($this->instance['dashboard_status_widget_title'])) || (empty($this->instance['dashboard_status_widget_title']))) {
								$this->instance['dashboard_status_widget_title'] = __('WordPress Chat', $wpmudev_chat->translation_domain);
							}

							wp_add_dashboard_widget(
								'wpmudev_chat_status_dashboard_widget',
								$this->instance['dashboard_status_widget_title'],
								array(&$this, 'wpmudev_chat_status_dashboard_widget_proc')
							);
							//}
					}
				}
			}
		}

		function wpmudev_chat_status_dashboard_widget_proc() {
			global $wpmudev_chat, $current_user;

			$chat_output = '';

			$chat_user_status = wpmudev_chat_get_user_status($current_user->ID);

			foreach($wpmudev_chat->_chat_options['user-statuses'] as $status_key => $status_label) {
				if ($status_key == $chat_user_status) {
					$selected = ' selected="selected" ';
				} else {
					$selected = '';
				}

				$class = '';
				if ($status_key == 'available')
					{$class .= ' available';}

				$chat_output .= '<option class="'. $class .'" value="'. $status_key .'" '. $selected .'>'. $status_label .'</option>';
			}

			if (!empty($chat_output)) {

				echo '<select id="wpmudev-chat-status-widget-dashboard" class="wpmudev-chat-status-widget">'. $chat_output .'</select>';
			}
		}
	}
	$wpmudev_chat_status_dashboard_widget = new WPMUDEVChatStatusDashboardWidget();
}

if (!class_exists('WPMUDEVChatFriendsDashboardWidget')) {

	class WPMUDEVChatFriendsDashboardWidget {
		var $instance = array();

		function __construct() {

			if (is_network_admin()) {
				if ( !function_exists( 'is_plugin_active_for_network' ) ) {
					require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
				}
				if (!is_plugin_active_for_network('wordpress-chat/wordpress-chat.php')) {return;}

				add_action( 'wp_network_dashboard_setup', array(&$this, 'wpmudev_chat_add_dashboard_widgets') );
			} else {
				add_action( 'wp_dashboard_setup', array(&$this, 'wpmudev_chat_add_dashboard_widgets') );
			}
		}

		function WPMUDEVChatFriendsDashboardWidget() {
			$this->__construct();
		}

		function wpmudev_chat_add_dashboard_widgets() {
			global $bp, $wpmudev_chat, $blog_id, $current_user;

			// If BuddyPress or Friends plugins is not active
			if ((empty($bp)) && (!is_plugin_active('friends/friends.php'))
			 && ((is_multisite()) && (!is_plugin_active_for_network('friends/friends.php')))) {
				 return;
			}

			$this->instance = $wpmudev_chat->_chat_options['dashboard'];

			$user_meta = get_user_meta( $current_user->ID, 'wpmudev-chat-user', true );
			$user_meta = wp_parse_args( $user_meta, $wpmudev_chat->_chat_options_defaults['user_meta'] );
			//echo "user_meta<pre>"; print_r($user_meta); echo "</pre>";

			if ($user_meta['chat_wp_admin'] == "enabled") {
				if (is_network_admin()) {

					if ((isset($this->instance['dashboard_friends_widget'])) && ($this->instance['dashboard_friends_widget'] == 'enabled')
					 && (isset($user_meta['chat_network_dashboard_friends_widget'])) && ($user_meta['chat_network_dashboard_friends_widget'] == 'enabled')) {

						if ((!isset($this->instance['dashboard_friends_widget_title'])) || (empty($this->instance['dashboard_friends_widget_title']))) {
							$this->instance['dashboard_friends_widget_title'] = __('Chat Friends', $wpmudev_chat->translation_domain);
						}

						if ((isset($user_meta['chat_dashboard_friends_widget_height'])) && (!empty($user_meta['chat_dashboard_friends_widget_height']))) {
							$this->instance['box_height'] = $user_meta['chat_dashboard_friends_widget_height'];

						} else if ((!isset($this->instance['dashboard_friends_widget_height'])) || (empty($this->instance['dashboard_friends_widget_height']))) {
							$this->instance['box_height'] = $this->instance['dashboard_friends_widget_height'];
						}

						wp_add_dashboard_widget(
							'wpmudev_chat_dashboard_friends_widget',
							$this->instance['dashboard_friends_widget_title'],
							array(&$this, 'wpmudev_chat_friends_dashboard_widget_proc')
						);
					}
				} else {

					if ((isset($this->instance['dashboard_friends_widget'])) && ($this->instance['dashboard_friends_widget'] == 'enabled')
					 && (isset($user_meta['chat_dashboard_friends_widget'])) && ($user_meta['chat_dashboard_friends_widget'] == 'enabled')) {

						//if (((isset($current_user->allcaps['level_10'])) && ($current_user->allcaps['level_10'] == 1))
						//	|| (array_intersect($this->instance['login_options'], $current_user->roles))) {

							if ((!isset($this->instance['dashboard_friends_widget_title'])) || (empty($this->instance['dashboard_friends_widgettitle']))) {
								$this->instance['dashboard_friends_widget_title'] = __('Chat Friends', $wpmudev_chat->translation_domain);
							}

							if ((isset($user_meta['chat_dashboard_friends_widget_height'])) && (!empty($user_meta['chat_dashboard_friends_widget_height']))) {
								$this->instance['box_height'] = $user_meta['chat_dashboard_friends_widget_height'];

							} else if ((!isset($this->instance['dashboard_friends_widget_height'])) || (empty($this->instance['dashboard_friends_widget_height']))) {
								$this->instance['box_height'] = $this->instance['dashboard_friends_widget_height'];
							}

							wp_add_dashboard_widget(
								'wpmudev_chat_friends_dashboard_widget',
								$this->instance['dashboard_friends_widget_title'],
								array(&$this, 'wpmudev_chat_friends_dashboard_widget_proc')
							);
							//}
					}
				}
			}
		}

		function wpmudev_chat_friends_dashboard_widget_proc() {
			global $bp, $wpmudev_chat, $current_user;

			$friends_list_ids = array();

			if ((!empty($bp)) && (function_exists('bp_get_friend_ids'))) {
				$friends_ids = bp_get_friend_ids($bp->loggedin_user->id);
				//echo "friends_ids=[". $friends_ids ."]<br />";
				if (!empty($friends_ids)) {
					$friends_list_ids = explode(',', $friends_ids);
				}
				//echo "friends_list_ids<pre>"; print_r($friends_list_ids); echo "</pre>";

			} else {

				if ((!is_admin()) && (!function_exists('is_plugin_active'))) {
					include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				if (!is_plugin_active('friends/friends.php')) {
					if ((is_multisite()) && (!is_plugin_active_for_network('friends/friends.php'))) {
						?><p class="error"><?php $this->plugin_error_message; ?></p><?php
						return;
					}
				}
				if (!function_exists('friends_get_list')) {return;}

				$friends_list_ids = friends_get_list($current_user->ID);
			}

			//echo "friends_list_ids<pre>"; print_r($friends_list_ids); echo "</pre>";
			if ((!is_array($friends_list_ids)) || (!count($friends_list_ids))) {
				return;
			}

			$chat_output = '';

			$friends_status = wpmudev_chat_get_friends_status($current_user->ID, $friends_list_ids);
			//echo "friends_status<pre>"; print_r($friends_status); echo "</pre>";
			if ( ($friends_status) && (is_array($friends_status)) && (count($friends_status)) ) {
				//echo "friends_status<pre>"; print_r($friends_status); echo "</pre>";
				foreach($friends_status as $friend) {
					if ((isset($friend->chat_status)) && ($friend->chat_status == "available")) {
						$friend_status_data = wpmudev_chat_get_chat_status_data($current_user->ID, $friend);

						$chat_output .= '<li><a class="'. $friend_status_data['href_class'] .'" title="'. $friend_status_data['href_title'] .'" href="#" rel="'.md5($friend->ID) .'"><span class="wpmudev-chat-ab-icon wpmudev-chat-ab-icon-'. $friend->chat_status .'"></span><span class="wpmudev-chat-ab-label">'. $friend->display_name .'</span>'.'</a></li>';

					}
				}

				if (!empty($chat_output)) {

					$height_style = ' style="max-height: '. $this->instance['box_height'] .'; overflow:auto;" ';
					echo '<ul id="wpmudev-chat-friends-dashboard-widget" '. $height_style.' class="wpmudev-chat-friends-widget">'. $chat_output .'</ul>';
				}
			} else {
				?><p><?php _e("No Friends online.", $wpmudev_chat->translation_domain); ?></p><?php
			}

		}
	}
	$wpmudev_chat_friends_dashboard_widget = new WPMUDEVChatFriendsDashboardWidget();
}