<?php
/**
 * @package markdown-widget
 * @author moxypark
 * @version 1.0.0
 */
/*
Plugin Name: Markdown Widget
Plugin URI: http://moxypark.co.uk/markdown-widget/
Description: Allows authors to enter text using the Markdown syntax in the sidebar
Author: moxypark
Version: 1.0.0
Author URI: http://moxypark.co.uk/
*/
require_once('markdown.php');
class MarkdownWidget extends WP_Widget {
	function MarkdownWidget() {
		$widget_ops = array(
			'classname' => 'widget_markdown',
			'description' => 'Markdown-formatted text'
		);
		
		$this->WP_Widget('markdown', 'Markdown text', $widget_ops);
	}
	
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$text = empty($instance['text']) ? '&nbsp;' : apply_filters('widget_text', $instance['text']);
	
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}
	
		if(!empty($text)) {
			echo Markdown($text);
		}
	
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'entry_title' => '', 'comments_title' => '' ) );
		$title = strip_tags($instance['title']);
		$text = strip_tags($instance['text']); ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		<p><textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" rows="7"><?php echo attribute_escape($text); ?></textarea></p><?php 
	}
}

function MarkdownWidgetInit() {
  register_widget('MarkdownWidget');
}

add_action('widgets_init', 'MarkdownWidgetInit');