<?php 
/* 
 * Cambios y extenciones en el sistema wp
 * por: lisandro fernandez 
 * 
 */
 
////////////////////////////////////////////
/* 
 * remover ciertos item del
 * menu de administarador
 */
////////////////////////////////////////////

if (!function_exists('remove_posts_from_admin')) {
	function remove_posts_from_admin() {
		global $menu;
		unset($menu[5]);
        unset($menu[2]);
	}
}
add_action('admin_menu', 'remove_posts_from_admin');



////////////////////////////////////////////
/* 
 * Soporte para imaganes y seteo de tamaños
 * de las imagenes incrustadas al post.
 */
////////////////////////////////////////////

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 300, 300, 0); // default Post Thumbnail dimensions   
        update_option('medium_size_w', 600);
		update_option('medium_size_h', 600);
		
		update_option('large_size_w', 1024);
		update_option('large_size_h', 1024);
		
}

if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'realy-long', 2048, 2048, false ); 
	//add_image_size( 'homepage-thumb', 220, 180, true ); //(cropped)
}



////////////////////////////////////////////
/* 
 * Limitar cantidad de la palabras de un string
 */
////////////////////////////////////////////

function limit_words($string, $word_limit)
    {
        $words = str_word_count($string, 1);
        return implode(" ",array_splice($words,0,$word_limit));
    }
    
    
    
////////////////////////////////////////////
/* 
 * category for custom types...
 
////////////////////////////////////////////

add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
	if($post_type)
	    $post_type = $post_type;
	else
	    $post_type = array('post','noticia','nav_menu_item');
    $query->set('post_type',$post_type);
	return $query;
    }
}

*/
////////////////////////////////////////////
/* 
 * RSSS
 
////////////////////////////////////////////

function myfeed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('noticia');
	return $qv;
}
add_filter('request', 'myfeed_request');
*/







////////////////////////////////////////////
/* 
 * mejorar el auto-paragraf
 */
////////////////////////////////////////////

function better_wpautop($pee){
$pee = wpautop($pee);

//TABLAS borra los br al pedo arriba de las tablas
$pee = str_replace('<TABLE><br />', '<TABLE>', $pee);
$pee = str_replace('<TD><br />', '<TD>', $pee);
$pee = str_replace('</TD><br />', '</TD>', $pee);
$pee = str_replace('<TR><br />', '<TR>', $pee);
$pee = str_replace('</TR><br />', '</TR>', $pee);
$pee = str_replace('<TH><br />', '<TH>', $pee);
$pee = str_replace('</TH><br />', '</TH>', $pee);
$pee = str_replace('</p><br />', '</p>', $pee);
$pee = str_replace('<br /><epigrafe>', '<epigrafe>', $pee);
return $pee;
}

remove_filter('the_content','wpautop');
add_filter('the_content','better_wpautop');

// Remove WordPress Auto P
// remove_filter( 'the_content', 'wpautop' );
// Auto P is also called in these filters, I'm just adding these lines for your information.
// If you want to disable them, uncomment
// remove_filter( 'the_content', 'wpautop' );
// remove_filter( 'the_excerpt', 'wpautop' );
// remove_filter( 'comment_text', 'wpautop' ); // <-- Be careful with this one
// Remove WordPress Auto P


