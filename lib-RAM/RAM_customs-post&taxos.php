<?php
/* 
 * 
 * RAM Custom Post Type 
 * Developed by: lifofernandez
 * :lista de tipos de contenidos, taxonimoas y agregarlos al RSS
 * 
 */

function my_custom_init() {

	//crea taxonomias:('taxo name', array('taxos terms'), array('tipeposts releated to'))

   	$tipos = array('publicacion','video','imagen','link','twitt');

	//crear tipos de contendio $tipos
	$soporta = array( 'title', 'editor', 'author','custom-fields', 'trackbacks');
	lifo_contenidos($tipos,array('procedencia','post_tag','category'), $soporta,'post'); 
	
	//CREAR categorias para noticas
	
	$terminos = array(
		array(
		'padre' => 'instituciones',
		'hijos' => array('educación','museos', 'ONGs')
		),
		array(
		'padre' => 'empresas',
		'hijos' => array('software','hardware', 'galerías')
		),
		array(
		'padre' => 'desarrollo',
		'hijos' => array('entornos','librerías','lenguajes')
		),
		array(
		'padre' => 'eventos',
		'hijos' => array('exposiciones','muestras','charlas','seminarios', 'festivales')
		),
		array(
		'padre' => 'publicaciones',
		'hijos' => array('blogs','periódicos')
		),
		array(
		'padre' => 'referentes',
		'hijos' => array('artistas','colectivos','educadores')
		),
		array(
		'padre' => 'ATAM',
		'hijos' => array('académica','extensión','investigación & postgrado')
		),
	);
	lifo_taxonomias('procedencia', $terminos, $tipos);
	$cats = array(
		array(
		'padre' => 'imagen',
		'hijos' => array('animacion','generativa', 'data-viz')
		),
		array(
		'padre' => 'sonido',
		'hijos' => array('improvisacion','equipamiento','lenguage')
		),
		array(
		'padre' => 'programcion',
		'hijos' => array('codigo','interactivos')
		),
	);
	lifo_taxonomias('category', $cats, $tipos);
	//register_taxonomy_for_object_type('category', $tipos);
	//register_taxonomy_for_object_type('procedencia', $tipos);
	
} ///termina custom init

add_action( 'init', 'my_custom_init' );


///agregar custom types al feed rss
add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
	$tipos_custom = array('publicacion','video','imagen','link','twitt');
   	
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
	if($post_type)
	    $post_type = $post_type;
	else
	    $post_type = $tipos_custom;
    $query->set('post_type',$post_type);
	return $query;
    }
}
function myfeed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = $tipos_custom;
	return $qv;
}
add_filter('request', 'myfeed_request');

