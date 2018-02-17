<?php
if ( ! class_exists( "wpmudev_chat_admin_panels" ) ) {
	class wpmudev_chat_admin_panels {

		/**
		 * The PHP5 Class constructor. Used when an instance of this class is needed.
		 * Sets up the initial object environment and hooks into the various WordPress
		 * actions and filters.
		 *
		 * @since 1.0.0
		 * @uses $this->_settings array of our settings
		 * @uses $this->_admin_notice_messages array of admin header message texts.
		 *
		 * @param none
		 *
		 * @return self
		 */
		function __construct() {

		}

		/**
		 * The old-style PHP Class constructor. Used when an instance of this class
		 * is needed. If used (PHP4) this function calls the PHP5 version of the constructor.
		 *
		 * @since 2.0.0
		 *
		 * @param none
		 *
		 * @return self
		 */
		function wpmudev_chat_admin_panels() {
			$this->__construct();
		}

		function chat_settings_panel_page() {
			global $wpmudev_chat;

			$form_section = "page";
			?>
			<div id="wpmudev-chat-wrap" class="wrap wpmudev-chat-wrap-settings-page">
				<h2><?php _e( 'Chat Settings Page', $wpmudev_chat->translation_domain ); ?></h2>

				<form method="post" id="wpmudev-chat-settings-form" action="?page=<?php echo $_GET['page']; ?>">

					<p><?php _e( 'The following settings are used to control the inline chat shortcodes applied to Posts, Pages, etc. You can setup default options here. As well as override these default options with shortcode parameters on the specific Post, Page, etc.', $wpmudev_chat->translation_domain ); ?></p>

					<div id="chat_tab_pane" class="chat_tab_pane">
						<ul>
							<li id="chat_box_appearance_tab"><a href="#chat_box_appearance_panel"><span><?php
										_e( 'Box Appearance', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_messages_appearance_tab"><a href="#chat_messages_appearance_panel"><span><?php
										_e( 'Message Appearance', $wpmudev_chat->translation_domain ); ?></span></a>
							</li>
							<li id="chat_messages_input_tab"><a href="#chat_messages_input_panel"><span><?php
										_e( 'Message Input', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_users_list_tab"><a href="#chat_users_list_panel"><span><?php
										_e( 'Users List', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_authentication_tab"><a href="#chat_authentication_panel"><span><?php
										_e( 'Authentication', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="wpmudev_chat_timymce_buttom_tab"><a href="#wpmudev_chat_timymce_buttom_panel"><span><?php
										_e( 'WYSIWYG Button', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_advanced_tab"><a href="#chat_advanced_panel"><span><?php
										_e( 'Advanced', $wpmudev_chat->translation_domain ); ?></span></a></li>
						</ul>
						<div id="chat_box_appearance_panel" class="panel">
							<?php wpmudev_chat_form_section_container( $form_section ); ?>
						</div>
						<div id="chat_messages_appearance_panel" class="panel">
							<?php wpmudev_chat_form_section_messages_wrapper( $form_section ); ?>
							<?php wpmudev_chat_form_section_messages_rows( $form_section ); ?>
						</div>
						<div id="chat_messages_input_panel" class="panel">
							<?php wpmudev_chat_form_section_messages_input( $form_section ); ?>
							<?php wpmudev_chat_form_section_messages_send_button( $form_section ); ?>
						</div>
						<div id="chat_users_list_panel" class="panel">
							<?php wpmudev_chat_users_list( $form_section ); ?>
							<?php wpmudev_chat_form_section_user_enter_exit_messages( $form_section ); ?>
						</div>
						<div id="chat_authentication_panel" class="chat_panel">
							<?php wpmudev_chat_form_section_login_options( $form_section ); ?>
							<?php wpmudev_chat_form_section_login_view_options( $form_section ); ?>
							<?php wpmudev_chat_form_section_moderator_roles( $form_section ); ?>
						</div>
						<div id="wpmudev_chat_timymce_buttom_panel" class="chat_panel">
							<?php wpmudev_chat_form_section_tinymce_button_post_types( $form_section ); ?>
							<?php wpmudev_chat_form_section_tinymce_button_roles( $form_section ); ?>
						</div>
						<div id="chat_advanced_panel" class="chat_panel">
							<?php wpmudev_chat_form_section_logs( $form_section ); ?>
							<?php wpmudev_chat_form_section_logs_limit( $form_section ); ?>
							<?php wpmudev_chat_form_section_session_messages( $form_section ); ?>

							<?php if ( $wpmudev_chat->get_option( 'blocked_ip_addresses_active', 'global' ) == "enabled" ) {
								wpmudev_chat_form_section_blocked_ip_addresses( $form_section );
							}
							wpmudev_chat_form_section_blocked_words( $form_section );
							?>
						</div>
					</div>
					<input type="hidden" name="chat[section]" value="<?php echo $form_section; ?>"/>
					<?php wp_nonce_field( 'wpmudev_chat_settings_save', 'wpmudev_chat_settings_save_wpnonce' ); ?>
					<p class="submit"><input type="submit" name="Submit" class="button-primary"
					                         value="<?php _e( 'Save Changes', $wpmudev_chat->translation_domain ) ?>"/>
					</p>
				</form>
			</div>
			<?php
		}

		function chat_settings_panel_site() {
			global $wpmudev_chat;

			$form_section = "site";

			?>
			<div id="wpmudev-chat-wrap" class="wrap wpmudev-chat-wrap-settings-page">
				<h2><?php _e( 'Chat Settings Site', $wpmudev_chat->translation_domain ); ?></h2>

				<form method="post" id="wpmudev-chat-settings-form" action="?page=<?php echo $_GET['page']; ?>">

					<p><?php _e( 'The following settings are used to control the bottom corner and private chat area settings.', $wpmudev_chat->translation_domain ); ?></p>
					<?php if ( is_multisite() ) {
						?>
						<p><?php _e( 'Under Multisite the bottom corner chat can be enabled at the Netowrk. When this happens it will replace the local site bottom corner chat.', $wpmudev_chat->translation_domain ); ?></p><?php
					} ?>
					<div id="chat_tab_pane" class="chat_tab_pane">
						<ul>
							<li id="chat_bottom_corner_tab"><a href="#chat_bottom_corner_panel" class="current"><span><?php
										_e( 'Bottom Corner', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_box_appearance_tab"><a href="#chat_box_appearance_panel" class="current"><span><?php
										_e( 'Box Appearance', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_box_position_tab"><a href="#chat_box_position_panel"><span><?php
										_e( 'Box Position', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_messages_appearance_tab"><a href="#chat_messages_appearance_panel"><span><?php
										_e( 'Message Appearance', $wpmudev_chat->translation_domain ); ?></span></a>
							</li>
							<li id="chat_messages_input_tab"><a href="#chat_messages_input_panel"><span><?php
										_e( 'Message Input', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_users_list_tab"><a href="#chat_users_list_panel"><span><?php
										_e( 'Users List', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_authentication_tab"><a href="#chat_authentication_panel"><span><?php
										_e( 'Authentication', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_advanced_tab"><a href="#chat_advanced_panel"><span><?php
										_e( 'Advanced', $wpmudev_chat->translation_domain ); ?></span></a></li>
						</ul>
						<div id="chat_bottom_corner_panel" class="panel current">
							<?php wpmudev_chat_form_section_bottom_corner( $form_section ); ?>
						</div>
						<div id="chat_box_appearance_panel" class="panel">
							<?php wpmudev_chat_form_section_container( $form_section ); ?>
						</div>
						<div id="chat_box_position_panel" class="panel">
							<?php wpmudev_chat_form_section_site_position( $form_section ); ?>
						</div>
						<div id="chat_messages_appearance_panel" class="panel">
							<?php wpmudev_chat_form_section_messages_wrapper( $form_section ); ?>
							<?php wpmudev_chat_form_section_messages_rows( $form_section ); ?>
						</div>
						<div id="chat_messages_input_panel" class="panel">
							<?php wpmudev_chat_form_section_messages_input( $form_section ); ?>
							<?php wpmudev_chat_form_section_messages_send_button( $form_section ); ?>
						</div>
						<div id="chat_users_list_panel" class="panel">
							<?php wpmudev_chat_users_list( $form_section ); ?>
							<?php wpmudev_chat_form_section_user_enter_exit_messages( $form_section ); ?>
						</div>
						<div id="chat_authentication_panel" class="chat_panel">
							<?php wpmudev_chat_form_section_login_options( $form_section ); ?>
							<?php wpmudev_chat_form_section_login_view_options( $form_section ); ?>
							<?php wpmudev_chat_form_section_moderator_roles( $form_section ); ?>
						</div>
						<div id="chat_advanced_panel" class="chat_panel">
							<?php wpmudev_chat_form_section_logs( $form_section ); ?>
							<?php wpmudev_chat_form_section_logs_limit( $form_section ); ?>
							<?php wpmudev_chat_form_section_session_messages( $form_section ); ?>

							<?php if ( $wpmudev_chat->get_option( 'blocked_ip_addresses_active', 'global' ) == "enabled" ) {
								wpmudev_chat_form_section_blocked_ip_addresses( $form_section );
							}
							wpmudev_chat_form_section_blocked_words( $form_section );
							?>
							<?php wpmudev_chat_form_section_block_urls_site( $form_section ); ?>
						</div>
					</div>
					<input type="hidden" name="chat[section]" value="<?php echo $form_section; ?>"/>
					<?php wp_nonce_field( 'wpmudev_chat_settings_save', 'wpmudev_chat_settings_save_wpnonce' ); ?>
					<p class="submit"><input type="submit" name="Submit" class="button-primary"
					                         value="<?php _e( 'Save Changes', $wpmudev_chat->translation_domain ) ?>"/>
					</p>

				</form>
			</div>
			<?php
		}

		function chat_settings_panel_widget() {
			global $wpmudev_chat;

			$form_section = "widget";

			?>
			<div id="wpmudev-chat-wrap" class="wrap wpmudev-chat-wrap-settings-page">
				<h2><?php _e( 'Chat Settings Widget', $wpmudev_chat->translation_domain ); ?></h2>

				<form method="post" id="wpmudev-chat-settings-form" action="?page=<?php echo $_GET['page']; ?>">

					<p><?php _e( 'The following settings are used to control all Chat Widgets.', $wpmudev_chat->translation_domain ); ?></p>

					<div id="chat_tab_pane" class="chat_tab_pane">
						<ul>
							<li id="chat_box_appearance_tab"><a href="#chat_box_appearance_panel" class="current"><span><?php
										_e( 'Box Appearance', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_messages_appearance_tab"><a href="#chat_messages_appearance_panel"><span><?php
										_e( 'Message Appearance', $wpmudev_chat->translation_domain ); ?></span></a>
							</li>
							<li id="chat_messages_input_tab"><a href="#chat_messages_input_panel"><span><?php
										_e( 'Message Input', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_users_list_tab"><a href="#chat_users_list_panel"><span><?php
										_e( 'Users List', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_authentication_tab"><a href="#chat_authentication_panel"><span><?php
										_e( 'Authentication', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_advanced_tab"><a href="#chat_advanced_panel"><span><?php
										_e( 'Advanced', $wpmudev_chat->translation_domain ); ?></span></a></li>
						</ul>
						<div id="chat_box_appearance_panel" class="panel current">
							<?php wpmudev_chat_form_section_container( $form_section ); ?>
						</div>
						<div id="chat_messages_appearance_panel" class="panel">
							<?php wpmudev_chat_form_section_messages_wrapper( $form_section ); ?>
							<?php wpmudev_chat_form_section_messages_rows( $form_section ); ?>
						</div>
						<div id="chat_messages_input_panel" class="panel">
							<?php wpmudev_chat_form_section_messages_input( $form_section ); ?>
							<?php wpmudev_chat_form_section_messages_send_button( $form_section ); ?>
						</div>
						<div id="chat_users_list_panel" class="panel">
							<?php wpmudev_chat_users_list( $form_section ); ?>
							<?php wpmudev_chat_form_section_user_enter_exit_messages( $form_section ); ?>
						</div>
						<div id="chat_authentication_panel" class="chat_panel">
							<?php wpmudev_chat_form_section_login_options( $form_section ); ?>
							<?php wpmudev_chat_form_section_login_view_options( $form_section ); ?>
							<?php wpmudev_chat_form_section_moderator_roles( $form_section ); ?>
						</div>
						<div id="chat_advanced_panel" class="chat_panel">
							<?php wpmudev_chat_form_section_logs( $form_section ); ?>
							<?php wpmudev_chat_form_section_logs_limit( $form_section ); ?>
							<?php wpmudev_chat_form_section_session_messages( $form_section ); ?>

							<?php if ( $wpmudev_chat->get_option( 'blocked_ip_addresses_active', 'global' ) == "enabled" ) {
								wpmudev_chat_form_section_blocked_ip_addresses( $form_section );
							}
							wpmudev_chat_form_section_blocked_words( $form_section );
							?>
							<?php wpmudev_chat_form_section_block_urls_widget( $form_section ); ?>
						</div>
					</div>
					<input type="hidden" name="chat[section]" value="<?php echo $form_section; ?>"/>
					<?php wp_nonce_field( 'wpmudev_chat_settings_save', 'wpmudev_chat_settings_save_wpnonce' ); ?>
					<p class="submit"><input type="submit" name="Submit" class="button-primary"
					                         value="<?php _e( 'Save Changes', $wpmudev_chat->translation_domain ) ?>"/>
					</p>
				</form>
			</div>
			<?php
		}

		function chat_settings_panel_buddypress() {
			global $wpmudev_chat;

			$form_section = "bp-group";
			?>
			<div id="wpmudev-chat-wrap" class="wrap wpmudev-chat-wrap-settings-page">
				<h2><?php _e( 'Group Chat Settings', $wpmudev_chat->translation_domain ); ?></h2>

				<?php if ( version_compare( bp_get_version(), '1.8' ) < 0 ) { ?>
				<form method="post" id="wpmudev-chat-settings-form" action="?page=<?php echo $_GET['page']; ?>">
					<?php } ?>

					<?php
					include_once( dirname( dirname( __FILE__ ) ) . '/lib/wpmudev_chat_form_sections.php' );
					include_once( dirname( dirname( __FILE__ ) ) . '/lib/wpmudev_chat_admin_panels_help.php' );
					?>

					<div id="chat_tab_pane" class="chat_tab_pane">
						<ul>
							<li id="chat_box_appearance_tab"><a href="#chat_box_appearance_panel"><span><?php
										_e( 'Box Appearance', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_messages_appearance_tab"><a href="#chat_messages_appearance_panel"><span><?php
										_e( 'Message Appearance', $wpmudev_chat->translation_domain ); ?></span></a>
							</li>
							<li id="chat_messages_input_tab"><a href="#chat_messages_input_panel"><span><?php
										_e( 'Message Input', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_users_list_tab"><a href="#chat_users_list_panel"><span><?php
										_e( 'Users List', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_advanced_tab"><a href="#chat_advanced_panel"><span><?php
										_e( 'Advanced', $wpmudev_chat->translation_domain ); ?></span></a></li>
						</ul>
						<div id="chat_box_appearance_panel" class="panel">
							<?php wpmudev_chat_form_section_information( $form_section ); ?>
							<?php wpmudev_chat_form_section_container( $form_section ); ?>
						</div>
						<div id="chat_messages_appearance_panel" class="panel">
							<?php wpmudev_chat_form_section_messages_wrapper( $form_section ); ?>
							<?php wpmudev_chat_form_section_messages_rows( $form_section ); ?>
						</div>
						<div id="chat_messages_input_panel" class="panel">
							<?php wpmudev_chat_form_section_messages_input( $form_section ); ?>
							<?php wpmudev_chat_form_section_messages_send_button( $form_section ); ?>
						</div>
						<div id="chat_users_list_panel" class="panel">
							<?php wpmudev_chat_users_list( $form_section ); ?>
							<?php wpmudev_chat_form_section_user_enter_exit_messages( $form_section ); ?>
						</div>
						<div id="chat_advanced_panel" class="chat_panel">
							<?php wpmudev_chat_form_section_logs( $form_section ); ?>
							<?php wpmudev_chat_form_section_logs_limit( $form_section ); ?>
							<?php wpmudev_chat_form_section_session_messages( $form_section ); ?>

							<?php if ( $wpmudev_chat->get_option( 'blocked_ip_addresses_active', 'global' ) == "enabled" ) {
								wpmudev_chat_form_section_blocked_ip_addresses( $form_section );
							}
							wpmudev_chat_form_section_blocked_words( $form_section ); ?>
						</div>
					</div>
					<input type="hidden" name="chat[section]" value="<?php echo $form_section; ?>"/>
					<?php wp_nonce_field( 'wpmudev_chat_settings_save', 'wpmudev_chat_settings_save_wpnonce' ); ?>

					<?php /* if (!is_admin()) { ?>
						<p class="submit"><input type="submit" name="Submit" class="button-primary"
							value="<?php _e('Save Changes', $wpmudev_chat->translation_domain) ?>" /></p>
					<?php } */
					?>

					<?php if ( version_compare( bp_get_version(), '1.8' ) < 0 ) { ?>
				</form>
			<?php } ?>
				<style type="text/css">

					#wpmudev-chat-wrap .ui-tabs-panel.ui-widget-content {
						background-color: <?php echo $wpmudev_chat->get_option('bp_form_background_color', 'global'); ?> !important;
					}

					#wpmudev-chat-wrap fieldset table td.chat-label-column {
						color: <?php echo $wpmudev_chat->get_option('bp_form_label_color', 'global'); ?> !important;
					}
				</style>
			</div>
			<?php
		}

		function chat_settings_panel_global() {
			global $wpmudev_chat;

			$buddypress_active = false;
			if ( is_plugin_active( 'buddypress/bp-loader.php' ) ) {
				$buddypress_active = true;
			} else if ( ( is_multisite() ) && ( is_plugin_active_for_network( 'buddypress/bp-loader.php' ) ) ) {
				$buddypress_active = true;
			}

			$form_section = "global";
			?>
			<div id="wpmudev-chat-wrap" class="wrap wpmudev-chat-wrap-settings-page">
				<?php if ( is_network_admin() ) { ?>
					<h2><?php _e( 'Chat Settings Network Common', $wpmudev_chat->translation_domain ); ?></h2>
				<?php } else { ?>
					<h2><?php _e( 'Chat Settings Common', $wpmudev_chat->translation_domain ); ?></h2>
				<?php } ?>

				<form method="post" id="wpmudev-chat-settings-form" action="?page=<?php echo $_GET['page']; ?>">

					<p><?php _e( 'The following settings are used for all chat session types (Page, Site, Private, Support).',
							$wpmudev_chat->translation_domain ); ?></p>

					<div id="chat_tab_pane" class="chat_tab_pane">
						<ul>
							<li id="wpmudev_chat_interval_tab"><a href="#wpmudev_chat_interval_panel"><span><?php
										_e( 'Poll Intervals', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<?php if ( ! is_network_admin() ) { ?>
								<li id="wpmudev_chat_google_plus_tab"><a href="#wpmudev_chat_google_plus_panel"><span><?php
											_e( 'Google+', $wpmudev_chat->translation_domain ); ?></span></a></li>
								<li id="wpmudev_chat_facebook_tab"><a href="#wpmudev_chat_facebook_panel"><span><?php
											_e( 'Facebook', $wpmudev_chat->translation_domain ); ?></span></a></li>
								<li id="wpmudev_chat_twitter_tab"><a href="#wpmudev_chat_twitter_panel"><span><?php
											_e( 'Twitter', $wpmudev_chat->translation_domain ); ?></span></a></li>
								<li id="wpmudev_chat_blocked_ip_addresses_tab">
									<a href="#wpmudev_chat_blocked_ip_addresses_panel"><span><?php
											_e( 'Block IP/User', $wpmudev_chat->translation_domain ); ?></span></a></li>
								<li id="wpmudev_chat_blocked_words_tab">
									<a href="#wpmudev_chat_blocked_words_panel"><span><?php
											_e( 'Blocked Words', $wpmudev_chat->translation_domain ); ?></span></a></li>
								<li id="wpmudev_chat_wp_tab"><a href="#wpmudev_chat_blocked_urls"><span><?php
											_e( 'Blocked URLs', $wpmudev_chat->translation_domain ); ?></span></a></li>
								<li id="chat_wpadmin_tab"><a href="#chat_wpadmin_panel"><span><?php
											_e( 'WPAdmin', $wpmudev_chat->translation_domain ); ?></span></a></li>
								<?php if ( $buddypress_active ) { ?>
									<li>
										<a href="#wpmudev_chat_buddypress_panel"><span><?php _e( 'BuddyPress', $wpmudev_chat->translation_domain ); ?></span></a>
									</li>
								<?php } ?>
							<?php } ?>
						</ul>
						<div id="wpmudev_chat_interval_panel" class="chat_panel current">
							<?php wpmudev_chat_form_section_polling_interval( $form_section ); ?>

							<?php if ( ! is_network_admin() ) { ?>
								<?php wpmudev_chat_form_section_polling_content( $form_section ); ?>
							<?php } ?>
							<?php wpmudev_chat_form_section_performance_content( $form_section ); ?>
						</div>
						<?php if ( ! is_network_admin() ) { ?>
							<div id="wpmudev_chat_google_plus_panel" class="chat_panel">
								<?php wpmudev_chat_form_section_google_plus( $form_section ); ?>
							</div>
							<div id="wpmudev_chat_facebook_panel" class="chat_panel">
								<?php wpmudev_chat_form_section_facebook( $form_section ); ?>
							</div>
							<div id="wpmudev_chat_twitter_panel" class="chat_panel current">
								<?php wpmudev_chat_form_section_twitter( $form_section ); ?>
							</div>
							<div id="wpmudev_chat_blocked_ip_addresses_panel" class="chat_panel">
								<?php wpmudev_chat_form_section_blocked_ip_addresses_global( $form_section ); ?>
								<?php wpmudev_chat_form_section_block_users_global( 'global' ); ?>
							</div>
							<div id="wpmudev_chat_blocked_words_panel" class="chat_panel">
								<?php wpmudev_chat_form_section_blocked_words_global( 'banned' ); ?>
							</div>
							<div id="wpmudev_chat_blocked_urls" class="chat_panel">
								<?php wpmudev_chat_form_section_blocked_urls_admin( 'global' ); ?>
								<?php wpmudev_chat_form_section_blocked_urls_front( 'global' ); ?>
							</div>
							<div id="chat_wpadmin_panel" class="panel">
								<?php wpmudev_chat_form_section_wpadmin( $form_section ); ?>
							</div>
							<?php if ( $buddypress_active ) { ?>
								<div id="wpmudev_chat_buddypress_panel" class="chat_panel">
									<p class="info"><?php _e( 'This section control how Chat works within the BuddyPress system. These are global settings and effect all Groups', $wpmudev_chat->translation_domain ); ?></p>
									<?php wpmudev_chat_form_section_buddypress_group_information( $form_section ); ?>
									<?php wpmudev_chat_form_section_buddypress_group_hide_site( $form_section ); ?>
									<?php wpmudev_chat_form_section_buddypress_group_hide_widget( $form_section ); ?>
									<?php wpmudev_chat_form_section_buddypress_group_admin_colors( $form_section ); ?>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
					<input type="hidden" name="chat[section]" value="<?php echo $form_section; ?>"/>
					<?php wp_nonce_field( 'wpmudev_chat_settings_save', 'wpmudev_chat_settings_save_wpnonce' ); ?>
					<p class="submit"><input type="submit" name="Submit" class="button-primary"
					                         value="<?php _e( 'Save Changes', $wpmudev_chat->translation_domain ) ?>"/>
					</p>
				</form>
			</div>
			<?php
		}

		function chat_settings_panel_session_logs() {
			global $wpdb, $wpmudev_chat;

			if ( isset( $_GET['message'] ) ) {
				$message_idx = esc_attr( $_GET['message'] );
				if ( isset( $wpmudev_chat->_admin_notice_messages[ $message_idx ] ) ) {
					?>
					<div id='chat-warning' class='updated fade'>
					<p><?php echo $wpmudev_chat->_admin_notice_messages[ $message_idx ]; ?></p></div><?php
				}
			}
			if ( ( isset( $_GET['laction'] ) ) && ( $_GET['laction'] == "show" ) ) {
				?>
				<div id="wpmudev-chat-messages-listing-panel"
				     class="wrap wpmudev-chat-wrap wpmudev-chat-wrap-settings-page">
					<?php //screen_icon('wpmudev-chat'); ?>
					<h2><?php _ex( "Chat Session", "Page Title", $wpmudev_chat->translation_domain ); ?></h2>

					<p>
						<a href="admin.php?page=chat_session_logs"><?php _e( 'Return to Logs', $wpmudev_chat->translation_domain ); ?></a>
					</p>
					<?php
					if ( ( isset( $_GET['chat_id'] ) ) && ( ! empty( $_GET['chat_id'] ) ) ) {
						$chat_id = esc_attr( $_GET['chat_id'] );
					} else {
						die();
					}
					if ( ( isset( $_GET['session_type'] ) ) && ( ! empty( $_GET['session_type'] ) ) ) {
						$session_type = esc_attr( $_GET['session_type'] );
					} else {
						die();
					}

					$transient_key = "chat-session-" . $chat_id . '-' . $session_type;
					if ( defined( 'WP_CACHE' ) && WP_CACHE ) {
						$chat_session_transient = get_option( $transient_key );
					} else {
						$chat_session_transient = get_transient( $transient_key );
					}
					if ( ( ! empty( $chat_session_transient ) ) && ( is_array( $chat_session_transient ) ) ) {
						$chat_session_transient                     = $wpmudev_chat->chat_session_show_via_logs( $chat_session_transient );
						$chat_session_transient['update_transient'] = 'disabled';
						$chat_session_transient['box_class']        = '';
						// Always make sure to keep the chat_id, session_type
						echo $wpmudev_chat->process_chat_shortcode( $chat_session_transient );

					}

					?>
				</div>
				<?php

			} else if ( ( isset( $_GET['laction'] ) ) && ( $_GET['laction'] == "details" ) ) {
				?>
				<div id="wpmudev-chat-messages-listing-panel"
				     class="wrap wpmudev-chat-wrap wpmudev-chat-wrap-settings-page">
					<?php //screen_icon('wpmudev-chat'); ?>
					<h2><?php _ex( "Chat Session Messages", "Page Title", $wpmudev_chat->translation_domain ); ?></h2>

					<p>
						<a href="admin.php?page=chat_session_logs"><?php _e( 'Return to Logs', $wpmudev_chat->translation_domain ); ?></a>
					</p>
					<?php
					//require_once( dirname(__FILE__) . '/wpmudev_chat_admin_session_messages.php');
					//$this->_logs_table = new WPMUDEVChat_Session_Messages_Table( );
					$wpmudev_chat->chat_log_list_table->prepare_items();

					if ( ( isset( $wpmudev_chat->chat_log_list_table->log_item->deleted ) ) && ( $wpmudev_chat->chat_log_list_table->log_item->deleted == 'yes' ) ) {
						?>
						<div id='chat-error' class='error fade'>
						<p><?php _e( 'This entire Chat Session is marked as hidden. It will not be show on public logs display. You may still hide/unhide or delete individual messages below.', $wpmudev_chat->translation_domain ); ?></p>
						</div><?php
					}

					?>
					<form id="wpmudev-chat-edit-listing" action="" method="get">
						<input type="hidden" name="page" value="chat_session_logs"/>
						<?php if ( isset( $_GET['chat_id'] ) ) { ?>
							<input type="hidden" name="chat_id" value="<?php echo $_GET['chat_id']; ?>"/>
						<?php } ?>
						<?php if ( isset( $_GET['lid'] ) ) { ?>
							<input type="hidden" name="lid" value="<?php echo $_GET['lid']; ?>"/>
						<?php } ?>
						<?php if ( isset( $_GET['laction'] ) ) { ?>
							<input type="hidden" name="laction" value="<?php echo $_GET['laction']; ?>"/>
						<?php } ?>
						<?php // The WP_List_table class automatically adds a _wpnonce field with the secret 'bulk-'+ args[plural] as in 'bulk-logs' or 'bulk-messages'. So no need to add another nonce field to the form?>

						<?php $wpmudev_chat->chat_log_list_table->search_box( __( 'Search Messages' ), 'chat-search' ); ?>
						<?php $wpmudev_chat->chat_log_list_table->display(); ?>
					</form>
				</div>
				<?php
			} else {
				?>
				<div id="wpmudev-chat-messages-listing-panel"
				     class="wrap wpmudev-chat-wrap wpmudev-chat-wrap-settings-page">
					<?php //screen_icon('wpmudev-chat'); ?>
					<h2><?php _ex( "Chat Session Logs", "Page Title", $wpmudev_chat->translation_domain ); ?></h2>

					<p><?php _ex( "", 'page description', $wpmudev_chat->translation_domain ); ?></p>
					<?php
					//require_once( dirname(__FILE__) . '/wpmudev_chat_admin_session_logs.php');
					//$this->_logs_table = new WPMUDEVChat_Session_Logs_Table( );
					$wpmudev_chat->chat_log_list_table->prepare_items();
					?>
					<form id="chat-edit-listing" action="?page=chat_session_logs" method="get">
						<input type="hidden" name="page" value="chat_session_logs"/>
						<?php $wpmudev_chat->chat_log_list_table->search_box( __( 'Search Logs' ), 'chat-search' ); ?>
						<?php $wpmudev_chat->chat_log_list_table->display(); ?>
						<?php // The WP_List_table class automatically adds a _wpnonce field with the secret 'bulk-'+ args[plural] as in 'bulk-logs' or 'bulk-messages'. So no need to add another nonce field to the form?>

					</form>
				</div>
				<?php
			}
		}

		function chat_settings_panel_network_site() {
			global $wpmudev_chat;

			$form_section = "network-site";

			?>
			<div id="wpmudev-chat-wrap" class="wrap wpmudev-chat-wrap-settings-page">
				<h2><?php _e( 'Chat Settings Network Site', $wpmudev_chat->translation_domain ); ?></h2>

				<form method="post" id="wpmudev-chat-settings-form" action="?page=<?php echo $_GET['page']; ?>">

					<p><?php _e( 'The following settings are used to control the bottom corner for all sites within the Multisite environment. This bottom corner chat is global, meaning messages are the same across all sites within the Multisite Network URLs. Once enabled this Network bottom corner chat box will <strong>replace</strong> the Site bottom corner chat box.', $wpmudev_chat->translation_domain ); ?></p>

					<div id="chat_tab_pane" class="chat_tab_pane">
						<ul>
							<li id="chat_bottom_corner_tab"><a href="#chat_bottom_corner_panel" class="current"><span><?php
										_e( 'Bottom Corner', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_box_appearance_tab"><a href="#chat_box_appearance_panel" class="current"><span><?php
										_e( 'Box Appearance', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_box_position_tab"><a href="#chat_box_position_panel"><span><?php
										_e( 'Box Position', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_messages_appearance_tab"><a href="#chat_messages_appearance_panel"><span><?php
										_e( 'Message Appearance', $wpmudev_chat->translation_domain ); ?></span></a>
							</li>
							<li id="chat_messages_input_tab"><a href="#chat_messages_input_panel"><span><?php
										_e( 'Message Input', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_users_list_tab"><a href="#chat_users_list_panel"><span><?php
										_e( 'Users List', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_authentication_tab"><a href="#chat_authentication_panel"><span><?php
										_e( 'Authentication', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_advanced_tab"><a href="#chat_advanced_panel"><span><?php
										_e( 'Advanced', $wpmudev_chat->translation_domain ); ?></span></a></li>
						</ul>
						<div id="chat_bottom_corner_panel" class="panel current">
							<?php wpmudev_chat_form_section_bottom_corner( $form_section ); ?>
						</div>
						<div id="chat_box_appearance_panel" class="panel">
							<?php wpmudev_chat_form_section_container( $form_section ); ?>
						</div>
						<div id="chat_box_position_panel" class="panel">
							<?php wpmudev_chat_form_section_site_position( $form_section ); ?>
						</div>
						<div id="chat_messages_appearance_panel" class="panel">
							<?php wpmudev_chat_form_section_messages_wrapper( $form_section ); ?>
							<?php wpmudev_chat_form_section_messages_rows( $form_section ); ?>
						</div>
						<div id="chat_messages_input_panel" class="panel">
							<?php wpmudev_chat_form_section_messages_input( $form_section ); ?>
							<?php wpmudev_chat_form_section_messages_send_button( $form_section ); ?>
						</div>
						<div id="chat_users_list_panel" class="panel">
							<?php wpmudev_chat_users_list( $form_section ); ?>
							<?php wpmudev_chat_form_section_user_enter_exit_messages( $form_section ); ?>
						</div>
						<div id="chat_authentication_panel" class="chat_panel">
							<?php wpmudev_chat_form_section_login_options( $form_section ); ?>
							<?php //wpmudev_chat_form_section_login_view_options($form_section); ?>
							<?php wpmudev_chat_form_section_moderator_roles( $form_section ); ?>
						</div>
						<div id="chat_advanced_panel" class="chat_panel">
							<?php //wpmudev_chat_form_section_logs($form_section); ?>
							<?php wpmudev_chat_form_section_logs_limit( $form_section ); ?>
							<?php wpmudev_chat_form_section_session_messages( $form_section ); ?>

							<?php if ( $wpmudev_chat->get_option( 'blocked_ip_addresses_active', 'global' ) == "enabled" ) {
								wpmudev_chat_form_section_blocked_ip_addresses( $form_section );
							} ?>

						</div>
					</div>
					<input type="hidden" name="chat[section]" value="<?php echo $form_section; ?>"/>
					<?php wp_nonce_field( 'wpmudev_chat_settings_save', 'wpmudev_chat_settings_save_wpnonce' ); ?>
					<p class="submit"><input type="submit" name="Submit" class="button-primary"
					                         value="<?php _e( 'Save Changes', $wpmudev_chat->translation_domain ) ?>"/>
					</p>

				</form>
			</div>
			<?php
		}

		function chat_settings_panel_dashboard() {
			global $wpmudev_chat;

			$form_section = "dashboard";

			?>
			<div id="wpmudev-chat-wrap" class="wrap wpmudev-chat-wrap-settings-page">
				<?php if ( is_network_admin() ) { ?>
					<h2><?php _e( 'Chat Settings Network Dashboard Widgets', $wpmudev_chat->translation_domain ); ?></h2>
				<?php } else { ?>
					<h2><?php _e( 'Chat Settings Dashboard Widgets', $wpmudev_chat->translation_domain ); ?></h2>
				<?php } ?>
				<form method="post" id="wpmudev-chat-settings-form" action="?page=<?php echo $_GET['page']; ?>">

					<?php if ( is_network_admin() ) { ?>
						<p><?php _e( 'This section controls visibiliy of Network Dashboard Chat Widgets', $wpmudev_chat->translation_domain ); ?></p>
					<?php } else { ?>
						<p><?php _e( 'This section controls visibiliy Dashboard Chat Widgets', $wpmudev_chat->translation_domain ); ?></p>
					<?php } ?>
					<div id="chat_tab_pane" class="chat_tab_pane">
						<ul>
							<li id="chat_widgets_tab"><a href="#chat_widgets_panel" class="current"><span><?php
										_e( 'Widgets', $wpmudev_chat->translation_domain ); ?></span></a></li>

							<li id="chat_box_appearance_tab"><a href="#chat_box_appearance_panel"><span><?php
										_e( 'Box Appearance', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_messages_appearance_tab"><a href="#chat_messages_appearance_panel"><span><?php
										_e( 'Message Appearance', $wpmudev_chat->translation_domain ); ?></span></a>
							</li>
							<li id="chat_messages_input_tab"><a href="#chat_messages_input_panel"><span><?php
										_e( 'Message Input', $wpmudev_chat->translation_domain ); ?></span></a></li>
							<li id="chat_users_list_tab"><a href="#chat_users_list_panel"><span><?php
										_e( 'Users List', $wpmudev_chat->translation_domain ); ?></span></a></li>

							<?php if ( ! is_network_admin() ) { ?>
								<li id="chat_authentication_tab"><a href="#chat_authentication_panel"><span><?php
											_e( 'Authentication', $wpmudev_chat->translation_domain ); ?></span></a>
								</li>
							<?php } ?>
							<li id="chat_advanced_tab"><a href="#chat_advanced_panel"><span><?php
										_e( 'Advanced', $wpmudev_chat->translation_domain ); ?></span></a></li>
						</ul>
						<div id="chat_widgets_panel" class="panel current">
							<?php wpmudev_chat_form_section_dashboard( $form_section ); ?>
						</div>

						<div id="chat_box_appearance_panel" class="panel">
							<?php wpmudev_chat_form_section_container( $form_section ); ?>
						</div>
						<div id="chat_messages_appearance_panel" class="panel">
							<?php wpmudev_chat_form_section_messages_wrapper( $form_section ); ?>
							<?php wpmudev_chat_form_section_messages_rows( $form_section ); ?>
						</div>
						<div id="chat_messages_input_panel" class="panel">
							<?php wpmudev_chat_form_section_messages_input( $form_section ); ?>
							<?php wpmudev_chat_form_section_messages_send_button( $form_section ); ?>
						</div>
						<div id="chat_users_list_panel" class="panel">
							<?php wpmudev_chat_users_list( $form_section ); ?>
							<?php wpmudev_chat_form_section_user_enter_exit_messages( $form_section ); ?>
						</div>

						<?php if ( ! is_network_admin() ) { ?>
							<div id="chat_authentication_panel" class="chat_panel">
								<?php wpmudev_chat_form_section_login_options( $form_section ); ?>
								<?php //wpmudev_chat_form_section_login_view_options($form_section); ?>
								<?php wpmudev_chat_form_section_moderator_roles( $form_section ); ?>
							</div>
						<?php } ?>
						<div id="chat_advanced_panel" class="chat_panel">
							<?php wpmudev_chat_form_section_logs( $form_section ); ?>
							<?php wpmudev_chat_form_section_logs_limit( $form_section ); ?>
						</div>
					</div>
					<input type="hidden" name="chat[section]" value="<?php echo $form_section; ?>"/>
					<?php wp_nonce_field( 'wpmudev_chat_settings_save', 'wpmudev_chat_settings_save_wpnonce' ); ?>
					<p class="submit"><input type="submit" name="Submit" class="button-primary"
					                         value="<?php _e( 'Save Changes', $wpmudev_chat->translation_domain ) ?>"/>
					</p>

				</form>
			</div>
			<?php
		}

	}
}