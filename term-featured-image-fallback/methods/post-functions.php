<?php
/*** ----- ------------------------------------------------------------------- ----- ***/
/*** ------------------------- fallback_get_post_metadata -------------------------- ***/
/*** ----- ------------------------------------------------------------------- ----- ***/

$this->addMethod('fallback_get_post_metadata', function () {
	$arg_list = func_get_args();
	$spare=$arg_list[0]; $object_id=$arg_list[1]; $meta_key=$arg_list[2]; $single=$arg_list[3];

	// only interested if this is a call for a thumbnail id in the public interface
	if ( is_admin() || $meta_key != '_thumbnail_id' ) return;
 
	// check for an existing thumbnail - note cannot use any function that will set up infinite loop!
	$meta_cache = wp_cache_get( $object_id , 'post_meta' );

	if ( !$meta_cache ) {
		$meta_cache = update_meta_cache( 'post' , array( $object_id ) );
		$meta_cache = $meta_cache[$object_id];
	}
	// if post has a thumbnail then return null to contine
	if ( isset( $meta_cache[$meta_key] ) ) return $meta_cache[$meta_key];


	$arr_act_taxonomies = $this->get_option('act_taxonomies'); if(!$arr_act_taxonomies) { $arr_act_taxonomies= array(); } if(count($arr_act_taxonomies) == 0){ return; }
	$arr_taxonomy_fallback_priority = $this->get_option('taxonomy_fallback_priority'); if(!$arr_taxonomy_fallback_priority) { $arr_taxonomy_fallback_priority= array(); } if(count($arr_taxonomy_fallback_priority) == 0){ return; }
	$arr_act_posts_fallback = $this->get_option('act_posts_fallback'); if(!$arr_act_posts_fallback) { $arr_act_posts_fallback= array(); } if(count($arr_act_posts_fallback) == 0){ return; }
			
	$post_type=get_post_type($object_id);
	if(!in_array(get_post_type($object_id), $arr_act_posts_fallback)){ return; }
	
	$post_taxonomies= get_post_taxonomies($object_id); if(!count($post_taxonomies)){ return; }
	
	$found=false;
	while(!$found && (count($arr_taxonomy_fallback_priority))){
		$maxtax = max(array_keys($arr_taxonomy_fallback_priority));
		unset($arr_taxonomy_fallback_priority[$maxtax]);
		if(in_array($maxtax, $post_taxonomies)) {
		   $args = array(
				'meta_key' => 'cs__featured_image_priority',
				'orderby' => 'meta_value',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key'     => 'cs__featured_image_id',
						'compare' => 'EXISTS',
					)
				)
			);			
			$terms = wp_get_post_terms( $object_id, $maxtax, $args );
			$count=count($terms);


			if ( $count == 0 ) { return null; }
			else {
				$i=0;
				while ( ($i < $count) && !$found ) {
					$term_id = $terms[$i]->term_id;
					$attach_id = get_term_meta( $term_id, 'cs__featured_image_id', true );
					if($attach_id){
						$found=true;
						return $attach_id;
					}
					$i++;
				}
			}
		}
	}
	return null;
});
add_filter( 'get_post_metadata' ,array( $this, 'fallback_get_post_metadata'), 10 , 4 );