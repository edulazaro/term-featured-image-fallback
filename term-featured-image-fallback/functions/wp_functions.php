<?php
/*** ----- ------------------------------------------------------------------- ----- ***/
/*** --------------------------- cs__the_term_thumbnail ---------------------------- ***/
/*** ----- ------------------------------------------------------------------- ----- ***/

function cs__the_term_thumbnail($termid=false){
	if (!$termid) {
		$termid = get_queried_object_id();
	}
	if($termid) {
		$attach_id = get_term_meta( $termid, 'cs__featured_image_id', true );
		if($attach_id){
			echo(wp_get_attachment_image($attach_id));
		}
	}
}

/*** ----- ------------------------------------------------------------------- ----- ***/
/*** ------------------------- cs__get_term_thumbnail_id --------------------------- ***/
/*** ----- ------------------------------------------------------------------- ----- ***/

function cs__get_term_thumbnail_id($termid=false){

	if (!$termid) {
		$termid = get_queried_object_id();
	}
	if($termid) {
		$attach_id = get_term_meta( $termid, 'cs__featured_image_id', true );
		if($attach_id){
			return($attach_id);
		}
	}
	return false;
}