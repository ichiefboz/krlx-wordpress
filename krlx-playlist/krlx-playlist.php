<?php

/*
Plugin Name: KRLX Playlist Widget
Description: A widget to display the most recent songs played on KRLX
Author: Tate Bosler
Version: 1.0
Author URI: https://www.tatebosler.com
*/

// Block direct requests
if (!defined('ABSPATH')) die('-1');

add_action('widgets_init', function() {
	register_widget( 'KRLX_Playlist_Widget' );
});

/**
 * Adds KRLX_Playlist_Widget widget.
 */
class KRLX_Playlist_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'KRLX_Playlist_Widget', // Base ID
			__('Playlist', 'krlx_playlist'), // Name
			array( 'description' => __( 'KRLX Playlist', 'krlx_playlist')) // Args
		);
	}
	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if (!empty( $instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}
		echo __('Hello, World!', 'krlx_playlist');
		echo $args['after_widget'];
	}
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Playlist', 'krlx_playlist');
		}
		
		if (isset($instance['song_count'])) {
			$songCount = $instance['song_count'];
		} else {
			$songCount = __(5, 'krlx_playlist');
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('song_count'); ?>"><?php _e('Song Count:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('song_count'); ?>" name="<?php echo $this->get_field_name('song_count'); ?>" type="number" min="1" max="100" value="<?php echo esc_attr( $songCount ); ?>">
		</p>
		<?php 
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['song_count'] = (!empty($new_instance['song_count']) and ($new_instance['song_count'] >= 1) and ($new_instance['song_count'] <= 100)) ? intval($new_instance['song_count']) : 5;
		
		return $instance;
	}
} // class KRLX_Playlist_Widget

?>