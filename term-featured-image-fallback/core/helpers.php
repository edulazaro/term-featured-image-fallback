<?php

if (! defined('ABSPATH')) { exit; }

/*** ---------------------------------------------- cs__var ---------------------------------------------- ***/
if (!function_exists('cs__var')) {
	function cs__var(&$var, $default = false) {
		return (isset($var) && ($var!='')) ? $var : $default;
	}
}

/*** ---------------------------------------------- cs__evar ---------------------------------------------- ***/
if (!function_exists('cs__evar')) {
	function cs__evar(&$var) {
		if(isset($var)) { echo($var); }
	}
}

/*** ---------------------------------------- cs__str_limit_words ----------------------------------------- ***/
if (!function_exists('cs__str_limit_words')) {
	function cs__str_limit_words($string, $word_limit) {
		$words = explode(' ', $string, ($word_limit + 1));
		if(count($words) > $word_limit)
		array_pop($words);
		return implode(' ', $words);
	}
}


/*** --------------------------------------------- cs__content ---------------------------------------------- ***/
if (!function_exists('cs__content')) {
	function cs__content($limit) {
	  $content = explode(' ', wp_strip_all_tags(get_the_content()), $limit);
	  if (count($content)>=$limit) {
		array_pop($content);
		$content = implode(" ",$content).'...';
	  } else {
		$content = implode(" ",$content);
	  }	
	  $content = preg_replace('/\[.+\]/','', $content);
	  $content = apply_filters('the_content', $content); 
	  $content = str_replace(']]>', ']]&gt;', $content);
	  return $content;
	}
}

/*** ------------------------------------------- cs__select_var ------------------------------------------ ***/
if (!function_exists('cs__select_var')) {
	function cs__select_var(&$var, $default = false) {
		if (isset($var) && $var==$default){ echo('selected '); }
		echo('value="'.$default.'"');
	}
}

/*** ------------------------------------------- cs_sortBySubValue ----------------------------------------- ***/
if (!function_exists('cs__sortBySubValue')) {
	function cs__sortBySubValue($array, $value, $asc = true, $preserveKeys = false) {
		if (is_object(reset($array))) {
			$preserveKeys ? uasort($array, function ($a, $b) use ($value, $asc) {
				return $a->{$value} == $b->{$value} ? 0 : ($a->{$value} - $b->{$value}) * ($asc ? 1 : -1);
			}) : usort($array, function ($a, $b) use ($value, $asc) {
				return $a->{$value} == $b->{$value} ? 0 : ($a->{$value} - $b->{$value}) * ($asc ? 1 : -1);
			});
		} else {
			$preserveKeys ? uasort($array, function ($a, $b) use ($value, $asc) {
				return $a[$value] == $b[$value] ? 0 : ($a[$value] - $b[$value]) * ($asc ? 1 : -1);
			}) : usort($array, function ($a, $b) use ($value, $asc) {
				return $a[$value] == $b[$value] ? 0 : ($a[$value] - $b[$value]) * ($asc ? 1 : -1);
			});
		}
		return $array;
	}
}

/*** ------------------------------------------- cs__checkValidUrl ----------------------------------------- ***/
if (!function_exists('cs__checkValidUrl')) {
	function cs__checkValidUrl ($url){
		if($url == '') { return false; }
		$url = filter_var($url, FILTER_SANITIZE_URL); // Remove all illegal characters from a url
		if (!filter_var($url, FILTER_VALIDATE_URL) === false) { return $url; } else { echo($url); echo __(' is not a valid URL.'); return false; } // Validate url
	}
}

/*** -------------------------------------- cs__requireFilesOnce ------------------------------------ ***/
if (!function_exists('cs__requireFilesOnce')) {
	function cs__requireFilesOnce ($folder){
		$scan = preg_grep('/^([^.])/', scandir($folder));
		foreach ($scan as $file) {
			if(is_dir ($folder.'/'.$file)){
				cs__requireFilesOnce($folder.'/'.$file);
			} else {
				require_once($folder.'/'.$file);
			}
		}
	}
}

/*** -------------------------------------- cs__esc_getpost ------------------------------------ ***/
if (!function_exists('cs__esc_getpost')) {
	function cs__esc_getpost (){
		foreach ($_POST as $clave => $valor) {
			$_POST[$clave] = esc_sql($_POST[$clave]);
		}
		foreach ($_GET as $clave => $valor) {
			$_GET[$clave] = esc_sql($_GET[$clave]);
		}
	}
}

/*** -------------------------------------- cs__includeAdminScriptsStyles ------------------------------------ ***/
if (!function_exists('cs__includeAdminScriptsStyles')) {
	function cs__includeAdminScriptsStyles (){
		
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'cs__admin_pages', plugins_url('css/admin_pages.css', __FILE__ ) );
		wp_enqueue_script( 'cs__image_uploader', plugins_url('js/image_uploader.js', __FILE__ ) );
		wp_enqueue_script( 'cs__admin_pages', plugins_url('js/admin_pages.js', __FILE__ ) );
		wp_enqueue_media();
	}
}