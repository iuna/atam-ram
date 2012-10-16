<?php

/* 
 * 
 * TIPOS DE CONTENIDOS 
 * crea tipos de contenidos customizados similares
 * Developed by: lifofernandez
 * 
 */

/////////////////////////////////////////////////////////////////////////////
///////////////////////INSERTAR CUSTOM TYPES/////////////////////////////////
/////////////////////////////////////////////////////////////////////////////

function lifo_contenidos($tipos,$taxos,$supports, $capa_type){//params: nombre del contenidos y taxos a la que va estar relacionada
//$taxosTrueStr = '';
$taxxx = 'taxonomies';

//if ($taxos !=null) { $taxosTrueStr = ''.$taxxx.' => '.$taxos.',';}

   foreach($tipos as $tipo){

   //$tipo_clean = normalizer_normalize($tipo);
    $tipo_clean = str_replace(array('á', 'é', 'í', 'ó','ú','ñ'), array('a', 'e', 'i','o','u','n'), $tipo);
    $tipo_clean = preg_replace('/[^A-Za-z0-9]+/', '_', strtolower($tipo_clean));
 
	
	$Tipo = ucwords($tipo); //tipo Capitalizado
	$Tipo_clean  = ucwords($tipo_clean);
	
    $label = '$label'; 	$arg = '$arg';
	$labels = $label.$Tipo_clean; //nuevo string=lablesTipo 
	$args = $arg.$Tipo_clean; //nuevo string=argsTipo

	/* Here's how to create your customized labels */
	$labels = array(
		'name' => _x( ''.$Tipo.'s', 'post type general name' ), // Tip: _x('') is used for localization
		'singular_name' => _x(  $Tipo, 'post type singular name' ),
		'add_new' => _x( 'Agregar ',  $Tipo ),
		'add_new_item' => __( 'Agregar  '. $Tipo.'' ),
		'edit_item' => __( 'Editar '. $Tipo.'' ),
		'new_item' => __( 'Nuevx '. $Tipo.'' ),
		'view_item' => __( 'Ver '. $Tipo.'' ),
		'search_items' => __( 'Buscar '. $Tipo.'s' ),
		'not_found' =>  __( 'No se han encontrado '. $Tipo.'' ),
		'not_found_in_trash' => __( 'No hay '. $Tipo.'s en la Papelera' ),
		//'parent_item_colon' => ''
);
$menu_pos = 1;
if($tipo == 'noticia') $menu_pos = 0;
	// Create an array for the $args
	$args = array( 'labels' => $labels, /* NOTICE: the $labels variable is used here... */
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array('slug' => $tipo_clean),
		'capability_type' => $capa_type,
		'hierarchical' => true,
		'menu_position' => $menu_pos,
		'supports' => $supports,
		 $taxxx => $taxos,
        //'has_archive' => true, // Will use the post type slug, ie. example
    //'has_archive' => 'my-example-archive', // Explicitly setting the archive slug


); 

  // The register_post_type() function is not to be used before the 'init'.

		if(post_type_exists($tipo_clean) == null){
			register_post_type($tipo_clean, $args); /* Register it and move on */
		}	
	}//cierra forceah tipos

}///termina contenidos


/////////////////////////////////////////////////////////////////////////////
///////////////////////INSERTAR TAXONOMIAS Y TERMINOS ///////////////////////
/////////////////////////////////////////////////////////////////////////////

//para crear taxonomias similares 
function lifo_taxonomias($taxo, $terminos, $tipos){
	//params: nombre de taxonomia, $terminos y tipos de contenido al que va estar relacionada

	


	$Taxo = ucwords($taxo); //tipo con Mayuscula
	//$Taxo_Clean = ucwords($taxo_clean); //tipo con Mayuscula
	
	
	
    $label='$label';$arg='$arg';
	$labels = $label.$Taxo; //nuevo string=lables+tipo 

	$args = $arg.$Taxo; //nuevo string=args+tipo


  $labels = array(
    'name' => _x( $Taxo, 'taxonomy general name' ),
    'singular_name' => _x( $Taxo, 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar '.$Taxo.'' ),
    'popular_items' => __( ''.$Taxo.'s Populares' ),
    'all_items' => __( 'Todas las '.$Taxo.'s' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Editar '.$Taxo.'' ), 
    'update_item' => __( 'Actualizar '.$Taxo.'' ),
    'add_new_item' => __( 'Agregar Nuevx '.$Taxo.'' ),
    'new_item_name' => __( 'Nuevx nombre de'.$Taxo.' ' ),
    'separate_items_with_commas' => __( 'separar '.$Taxo.'s con comas' ),
    'add_or_remove_items' => __( 'Agregar o remover '.$Taxo.'s' ),
    'choose_from_most_used' => __( 'elegir de las '.$Taxo.'s mas usadas'),
    'menu_name' => __( ''.$Taxo.'s' ),
  ); 


if(taxonomy_exists($taxo) == null){
  register_taxonomy( $taxo, $tipos, array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => $taxo),
  ));
}


//	function terminos($terminos, $taxo, $tipos){ //para agregar items a la taxonomia $taxo
  		
	foreach($terminos as $termino){
  		$Termino = ucwords($termino['padre']);

	/*
		$term_clean = str_replace(array('á', 'é', 'í', 'ó','ú','ñ'), array('a', 'e', 'i','o','u','n'), strtolower($termino['padre']) );
		$term_clean = trim($term_clean);
	    $term_clean = preg_replace('/[^A-Za-z0-9]+/', '-', $term_clean);
*/

		$tipos2 = $tipos;
		if( is_array($tipos) ){
			$tipos2 = implode("s, ", $tipos);
		}
			$Tipos2 = ucwords($tipos2);  
			
			$parent_term;
			
		
			
			if(term_exists($termino['padre'], $taxo) == null){
				
					$slug = $termino['padre'];
					if($taxo != 'category') $slug=$taxo.'_'.$termino['padre'];
					
  				 $parent_term = wp_insert_term(
  					$Termino, // the term 
  					$taxo, // the taxonomy
  					array('description'=> ''.$Tipos2.'s bajo la <b>'.$Taxo.'</b> -> <b>'.$Termino.'</b>',
    					'slug' => $slug

  					)
				);	
				
			
			//$parent_term_id = get_term_by('slug', $termino['padre'], $taxo); // get numeric term i
			if($termino['hijos'] != null){
				foreach($termino['hijos'] as $hijo){
		  			$Hijo = ucfirst($hijo);
					if(term_exists($hijo, $taxo) == null){
						
		  					$slug = $hijo;
							if($taxo != 'category') $slug=$taxo.'_'.$hijo;
							
						$hijo_term = wp_insert_term(
		  					$Hijo, // the term 
		  					$taxo, // the taxonomy
		  					array(
								'description'=> ''.$Tipos2.' bajo la <b>'.$Taxo.'</b> -> '.$Termino.'/ <b>'.$Hijo.'</b>',
		    					'slug' => $slug,
								'parent' =>$parent_term['term_id']
		  					)
						); 
					
				  	$args = array();
					$args['parent'] = $parent_term['term_id'];
				
					wp_update_term($hijo_term['term_id'], $taxo, $args );

						}//cierra if hijos
					}//cierra foraeach hijo
				}//cierra if $termino['hijos'] 
				
				delete_option(''.$taxo.'_children');
		
			}//cierra if padre
			
		}//cierra foraeach padre
		
		
		

//  }//termina terminos

	//crea terms(array('terms names'),'taxo releated to')
//	terminos($terminos,$taxo,$tipos); 



}///termina taxonomias()


/////////////////////////////////////////////////////////////////////////////
///////////////////////INSERTAR PAGINAS//////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
// Insert the post into the database

function lifo_paginas($paginas){ //para agregar items 

    foreach($paginas as $pagina){
	
   		$existe = get_page_by_title($pagina['post_title'], 'OBJECT', 'page');

		if($existe == null){
			$page_id = wp_insert_post($pagina);
			if($pagina['template'] != null)update_post_meta($page_id, "_wp_page_template", $pagina['template']);
			if($pagina['meta_datos'] != null)add_post_meta($page_id, 'metadatos', $pagina['meta_datos']);
			
				
				if($pagina['post_parent_title'] != null){
			    	$padre = get_page_by_title($pagina['post_parent_title'], 'OBJECT', 'page');
				  	
				$hija = array();
					$hija['ID'] = $post_id;
					$hija['post_parent'] = $padre->ID;
				  	wp_update_post($hija);
				}//cierra if padre esxiste
			
			
			
			
		
		} //cierra if post NULL

	}//cierra foraeach asignaturas

} //crear_paginas


