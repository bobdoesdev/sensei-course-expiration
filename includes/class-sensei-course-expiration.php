<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !class_exists( 'WC_SC_Checkout_Fields' ) ) {
	class Sensei_Course_Expiration{

		public function __construct(){
			add_action('wp', array($this, 'cron_activate') );
			add_action('sce_course_removal_cron', array($this, 'remove_user_from_course') );
		}
		
		public function cron_activate(){
		  if ( ! wp_next_scheduled( 'sce_course_removal_cron' ) ) {
		    wp_schedule_event(time(), 'hourly', 'sce_course_removal_cron');
		  }
		}
		 
		public function remove_user_from_course(){
		    global $wpdb;
		  $comments_courses = $wpdb->get_results('SELECT * FROM {$wpdb->prefix}comments WHERE comment_type = "sensei_course_status"', OBJECT);
		  foreach ($comments_courses as $comment) {

		    $sql = $wpdb->prepare('SELECT * FROM {$wpdb->prefix}commentmeta WHERE comment_id = %d AND meta_key = "start"', $comment->comment_ID);
		    $results = $wpdb->get_results($sql);

		    foreach ($results as $result) {
				if ( strtotime($result->meta_value) < strtotime('-1 year', time()) ) {
					wp_delete_comment($comment->comment_ID, true);
				}
		    }
		  }  

		  $comments_lessons = $wpdb->get_results('SELECT * FROM {$wpdb->prefix}comments WHERE comment_type = "sensei_lesson_status"', OBJECT);
		  foreach ($comments_lessons as $comment) {

		    $sql = $wpdb->prepare('SELECT * FROM {$wpdb->prefix}commentmeta WHERE comment_id = %d AND meta_key = "start"', $comment->comment_ID);
		    $results = $wpdb->get_results($sql);

			    foreach ($results as $result) {
					if ( strtotime($result->meta_value) < strtotime('-1 year', time()) ) {
					 	wp_delete_comment($comment->comment_ID, true);
					}
			    }
		  	}  
		}

	}
}