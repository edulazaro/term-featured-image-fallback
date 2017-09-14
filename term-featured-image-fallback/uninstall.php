<?php

/*

if (! defined('ABSPATH')) {exit; }
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {	exit; }
	if ( ! current_user_can( 'activate_plugins' ) ) { return; }
*/
	/*
	
	$delete_data = $cs__tfi->get_option('delete_data');
	if($delete_data){
		$taxonomies = get_taxonomies();
		if(count($taxonomies)){
			foreach($taxonomies as $taxonomy){
				$terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);
					
				if(count($terms)){				
					foreach($terms as $term){		echo("sadasdsa");			
						delete_term_meta($term->term_id, 'cs__featured_image_id') ;
						delete_term_meta($term->term_id, 'cs__featured_image_priority');
					}
				}
			}
		}

		delete_option('cs__tfi');
		delete_site_option('cs__tfi');
	}
	
	*/