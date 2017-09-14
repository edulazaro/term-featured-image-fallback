<?php
/*** ----- ------------------------------------------------------------------- ----- ***/
/*** --------------------------------- page_options -------------------------------- ***/
/*** ----- ------------------------------------------------------------------- ----- ***/
$this->addMethod('page_options', function () {
	cs__includeAdminScriptsStyles();
	?>
	<div class="wrap">
		<h1><?php echo __('Term Featured Images', 'term-featured-image-fallback'); ?></h2>
		<p><?php echo('Term Featured Images: '); echo __('Options', 'term-featured-image-fallback'); ?></p>
		<?php
		if( isset($_POST['cs_button_save']) ){
			$this->save_page_options();
			?>
			<span class="cs__message cs__message_ok"><?php echo __('Options saved', 'term-featured-image-fallback'); ?></span>
			<?php
		}
		$arr_act_taxonomies = $this->get_option('act_taxonomies'); if(!$arr_act_taxonomies) { $arr_act_taxonomies= array(); }
		$arr_taxonomy_fallback_priority = $this->get_option('taxonomy_fallback_priority'); if(!$arr_taxonomy_fallback_priority) { $arr_taxonomy_fallback_priority= array(); }
		$arr_act_posts_fallback = $this->get_option('act_posts_fallback'); if(!$arr_act_posts_fallback) { $arr_act_posts_fallback= array(); }
		$delete_data = $this->get_option('delete_data');
		?>
		<div class="clear"></div>
		<?php if (isset($_POST['cs_save'])) { ?><p class="cs__message_ok"><?php echo __( 'Data saved corretly.', 'term-featured-image-fallback'); ?></p><?php }	?>		
		<form action="" method="post" >	
		<div class="postbox-container" style="width:100%">
			<div class="postbox">
				<h3><?php echo __( 'Taxonomy configuration', 'term-featured-image-fallback'); ?></h3>
				<div style="position:relative; float:left;  width:100%; height:1px;  margin-top:0px; margin-bottom: 15px; text-align:left; background-color:#e5e5e5;">
				</div>	
				<div class="inside">
					<div class="inside-block">
						<?php echo __('Select in the featured image should be included or not for each taxonomy. You can also select the priority for the featured image in case a post is associated to more than one taxonomies.', 'term-featured-image-fallback');
						?>
					</div>				
					<div class="cs__block">
						<table class="form-table">
							<tbody>
								<?php
								$taxonomies = get_taxonomies();
								foreach ( $taxonomies as $taxonomy ) {
									if(($taxonomy !='nav_menu') && ($taxonomy !='link_category') && ($taxonomy !='post_format')) {
										$valueact = in_array($taxonomy, $arr_act_taxonomies) ? true : false;
										$valuefall = array_key_exists($taxonomy,$arr_taxonomy_fallback_priority)  ? $arr_taxonomy_fallback_priority[$taxonomy] : false;
										?>
										<tr class="form-field form-required term-name-wrap">
											<th scope="row">
												<label for="<?php echo($taxonomy); ?>"><?php echo($taxonomy); ?></label>
											</th>
											<td>
												<select name="<?php echo($taxonomy.'_taxonomy_featured'); ?>" class="postform">
													<option <?php cs__select_var($valueact, 0); ?> ><?php echo __('No featured image', 'term-featured-image-fallback'); ?></option>
													<option <?php cs__select_var($valueact, 1); ?> ><?php echo __('Add featured image', 'term-featured-image-fallback'); ?></option>														
												</select>
											</td>
											<td>
												<select name="<?php echo($taxonomy.'_taxonomy_fallback'); ?>" class="postform">
													<option <?php cs__select_var($valuefall, 0); ?>><?php echo __('Do not use as fallback for post featured images', 'term-featured-image-fallback'); ?></option>
													<?php
													$i=1;
													while ($i < 100) {
														?>
														<option <?php cs__select_var($valuefall, $i); ?>><?php echo __('Use as post featured image fallback: Priority ', 'term-featured-image-fallback'); echo($i); ?></option>	
														<?php
														$i++;
													}
													?>														
												</select>
											</td>											
										</tr>											
										<?php
									}
								}
								?>
							</tbody>
						</table>
					</div>	
				</div>
			</div>
		</div>
		<div class="postbox-container" style="width:100%">
			<div class="postbox">
				<h3><?php echo __( 'Post type configuration', 'term-featured-image-fallback'); ?></h3>
				<div style="position:relative; float:left;  width:100%; height:1px;  margin-top:0px; margin-bottom: 15px; text-align:left; background-color:#e5e5e5;">
				</div>	
				<div class="inside">
					<div class="inside-block">
						<?php echo __('Enable or disable the taxonomy featured image fallback for each post type.', 'term-featured-image-fallback');
						?>
					</div>				
					<div class="cs__block">
						<table class="form-table">
							<tbody>
							
								<?php
								$args = array('public'   => true);
								$post_types = get_post_types($args,'names');
								foreach ( $post_types as $name ) {
									if($name!='attachment'){
										$val=in_array($name,$arr_act_posts_fallback)  ? true : false;
										?>
										<tr class="form-field form-required term-name-wrap">
											<th scope="row">
												<label for="<?php echo($name); ?>"><?php echo($name); ?></label>
											</th>
											<td>
												<select name="<?php echo($name.'_post_fallback'); ?>" class="postform">
													<option <?php cs__select_var($val, 0); ?> ><?php echo __('Disable taxonomy featured image fallback', 'term-featured-image-fallback'); ?></option>	
													<option <?php cs__select_var($val, 1); ?> ><?php echo __('Enable taxonomy featured image fallback', 'term-featured-image-fallback'); ?></option>	
												</select>
											</td>
										</tr>
										<?php
									}
								}
								?>
							</tbody>
						</table>
					</div>	
				</div>
			</div>
		</div>
		<div class="postbox-container" style="width:100%">
			<div class="postbox">
				<h3><?php echo __( 'Keeep clean your database [Uninstall Configuration]', 'term-featured-image-fallback'); ?></h3>
				<div style="position:relative; float:left;  width:100%; height:1px;  margin-top:0px; margin-bottom: 15px; text-align:left; background-color:#e5e5e5;">
				</div>	
				<div class="inside">
					<div class="inside-block">
						<?php echo __("We like to keep WordPress database clean. If you temporary disable this plugin, do not check this option. However, if you don't plan to use the plugin anymore and you don't need to use the associated data anymore, you can check these options to remove all data associated with this plugin.", 'term-featured-image-fallback');
						?>
					</div>				
					<div class="cs__block">
						<table class="form-table">
							<tbody>
								<tr class="form-field form-required term-name-wrap">
									<th scope="row">
										<label for="delete_data"><?php echo __('Delete data when disabling this plugin:', 'term-featured-image-fallback'); ?></label>
										<input name="delete_data" <?php if($delete_data){ echo('checked'); } ?> type="checkbox" style="margin: 0px 0px 0px 20px;">
									</th>
								</tr>
							</tbody>
						</table>
					</div>	
				</div>
			</div>
		</div>		
		<input type="submit" name="cs_button_save" class="button-primary" value="<?php echo __( 'Save options', 'term-featured-image-fallback'); ?>">
		</form>
	</div>
	<?php
	
});

/*** ----- ------------------------------------------------------------------- ----- ***/
/*** ------------------------------- add_page_options ------------------------------ ***/
/*** ----- ------------------------------------------------------------------- ----- ***/
$this->addMethod('add_page_options', function () {
	add_submenu_page( 'themes.php',  __('Term featured images', 'term-featured-image-fallback'), __('Term featured images', 'term-featured-image-fallback'),'manage_options', 'term-featured-image-options', array( $this, 'page_options'));
});
add_action('admin_menu', array( $this, 'add_page_options'));

/*** ----- ------------------------------------------------------------------- ----- ***/
/*** ------------------------------ save_page_options ------------------------------ ***/
/*** ----- ------------------------------------------------------------------- ----- ***/
$this->addMethod('save_page_options', function () {
	cs__esc_getpost();
	
	$arr_act_taxonomies = array();
	$arr_taxonomy_fallback_priority = array();
	$arr_act_posts_fallback = array();
	
	$taxonomies = get_taxonomies(); 
	foreach ( $taxonomies as $taxonomy ) {
		if(($taxonomy !='nav_menu') && ($taxonomy !='link_category') && ($taxonomy !='post_format')) {	
			if (cs__var($_POST[$taxonomy.'_taxonomy_featured'])){ array_push($arr_act_taxonomies, $taxonomy); }
			if (cs__var($_POST[$taxonomy.'_taxonomy_fallback'])){ $arr_taxonomy_fallback_priority[$taxonomy]=$_POST[$taxonomy.'_taxonomy_fallback']; }
		}
	}
	$args = array('public'   => true);
	$post_types = get_post_types($args,'names');
	foreach ( $post_types as $name ) {
		if($name!='attachment'){
			if (cs__var($_POST[$name.'_post_fallback'])){ array_push($arr_act_posts_fallback, $name); }
		}
	}
	$this->update_option('act_taxonomies', $arr_act_taxonomies);
	$this->update_option('taxonomy_fallback_priority', $arr_taxonomy_fallback_priority);
	$this->update_option('act_posts_fallback', $arr_act_posts_fallback);
	$this->update_option('delete_data', cs__var($_POST['delete_data']));
});