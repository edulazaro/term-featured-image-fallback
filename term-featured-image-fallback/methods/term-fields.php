<?php
/*** /////////////////////////////////////////////////////////////////////////////// ***/
/*** ////////////////////////////////// COMMON DATA //////////////////////////////// ***/
/*** /////////////////////////////////////////////////////////////////////////////// ***/

$array_taxonomy_featured = $this->get_option('act_taxonomies');
if($array_taxonomy_featured) {
	foreach($array_taxonomy_featured as $taxonomy) {
		add_action($taxonomy.'_add_form_fields', array( $this, 'addfields'));
		add_action( 'created_'.$taxonomy, array( $this, 'savefields'), 12, 4 );
		add_action( $taxonomy.'_edit_form_fields', array( $this, 'editfields'), 10, 2 );
		add_action( 'edited_'.$taxonomy, array( $this, 'updatefields'), 10, 2 );
	}
}

/*** ----- ------------------------------------------------------------------- ----- ***/
/*** ---------------------------------- addfields ---------------------------------- ***/
/*** ----- ------------------------------------------------------------------- ----- ***/
$this->addMethod('addfields', function () {
	$arg_list = func_get_args();
	$taxonomia = ($arg_list[0]) ? $arg_list[0] : false;	
	cs__includeAdminScriptsStyles();
	?>
	<div class="form-field" style="max-width: 95%;">
		<label><?php echo __( 'Featured image', 'term-featured-image-fallback'); ?></label>
		<div class="cs__imgdisplay" >										
		</div>	
		<input name="cs__featured_image_id" class="cs__imgid" hidden type="text" />
		<input data-title="<?php echo __( 'Select Featured Image', 'term-featured-image-fallback'); ?>" class="cs__imgselect button" type="button" value="<?php echo __( 'Upload/Edit image', 'term-featured-image-fallback'); ?>" />
		<input class="cs__imgdel button" type="button" style="display:none;" value="<?php echo __( 'Remove image', 'term-featured-image-fallback'); ?>" />		
	</div>
	<div class="form-field">
		<label><?php echo __( 'Featured image priority for this term', 'term-featured-image-fallback'); ?></label>
		<select name="cs__featured_image_priority" style="width: 95%; max-width: 300px;">
			<?php
			$count=1;
			while ($count < 100) {
				?><option value="<?php echo($count); ?>" ><?php echo($count); ?></option><?php $count++;
			}
			?>
		</select>		
	</div>	
	<?php
});

/*** ----- ------------------------------------------------------------------- ----- ***/
/*** ---------------------------------- savefields --------------------------------- ***/
/*** ----- ------------------------------------------------------------------- ----- ***/
$this->addMethod('savefields', function () {
	$arg_list = func_get_args();
	$term_id=$arg_list[0];
	$tt_id=$arg_list[1];
	$op = array();
	if(cs__var($_POST['cs__featured_image_id'])) {
		add_term_meta( $term_id, 'cs__featured_image_id', $_POST['cs__featured_image_id'], true ); 
		if(cs__var($_POST['cs__featured_image_priority'])) {
			add_term_meta( $term_id, 'cs__featured_image_priority', cs__var($_POST['cs__featured_image_priority']) ? $_POST['cs__featured_image_priority'] : 0, true ); 
		}
	}
});

/*** ----- ------------------------------------------------------------------- ----- ***/
/*** ---------------------------------- editfields --------------------------------- ***/
/*** ----- ------------------------------------------------------------------- ----- ***/
$this->addMethod('editfields', function () {
	$arg_list = func_get_args();
	$term=$arg_list[0];
	cs__includeAdminScriptsStyles();
	$priority = get_term_meta( $term->term_id, 'cs__featured_image_priority', true );
	$imgid = get_term_meta( $term->term_id, 'cs__featured_image_id', true );	
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php echo __( 'Featured image', 'term-featured-image-fallback'); ?></label></label></th>
		<td>
			<div style="width:95%;">
				<div class="cs__imgdisplay" >	
					<?php
					if(cs__var($imgid)){
						$imgurl=wp_get_attachment_url($imgid);
						?>
						<img src="<?php cs__evar($imgurl); ?>" style="max-width:360px;" >
						<?php
					}
					?>				
				</div>	
				<input name="cs__featured_image_id" class="cs__imgid"  hidden type="text" value="<?php cs__evar($imgid); ?>" />
				<input data-title="<?php echo __( 'Select Featured Image', 'term-featured-image-fallback'); ?>" class="cs__imgselect button" type="button" value="<?php echo __( 'Upload/Edit image', 'term-featured-image-fallback'); ?>" />
				<input class="cs__imgdel button" type="button" style="<?php if(!cs__evar($imgid)){ echo("display:none;"); } ?>"  value="<?php echo __( 'Remove image', 'term-featured-image-fallback'); ?>" />						
			</div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php echo __( 'Featured image priority', 'term-featured-image-fallback'); ?></label></th>
		<td>
			<select id="cs__featured_image_priority" name="cs__featured_image_priority" style="max-width:300px;">
				<?php
				$count=1;
				while ($count<100){
					?><option <?php cs__select_var($priority, $count); ?> ><?php echo($count); ?></option><?php $count++;
				}
				?>
			</select>
		</td>
	</tr>	
	<?php		
});

/*** ----- ------------------------------------------------------------------- ----- ***/
/*** -------------------------------- updatefields --------------------------------- ***/
/*** ----- ------------------------------------------------------------------- ----- ***/
$this->addMethod('updatefields', function () {
	$arg_list = func_get_args();
	$term_id=$arg_list[0];
	$tt_id=$arg_list[1];
	if(cs__var($_POST['cs__featured_image_priority'])) {
		update_term_meta( $term_id, 'cs__featured_image_priority', $_POST['cs__featured_image_priority']);
	} else {
		delete_term_meta( $term_id, 'cs__featured_image_priority');
	}
	if(cs__var($_POST['cs__featured_image_id'])) {
		update_term_meta( $term_id, 'cs__featured_image_id', $_POST['cs__featured_image_id']);
	} else {
		delete_term_meta( $term_id, 'cs__featured_image_id');
	}
});