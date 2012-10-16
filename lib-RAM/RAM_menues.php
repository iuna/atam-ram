<?php 
/* 
 * generar itemes
 * por: lisandro fernandez 
 * 
 */
 
////////////////////////////////////////////
/* 
 * access menu
 * crear items del menu
 */
////////////////////////////////////////////
 

// Function for registering wp_nav_menu() in 3 locations
add_action( 'init', 'lifo_register_navmenus' );

function RAM_register_navmenus() {
	
	register_nav_menus( array( //registrar los menues
		'Primero' 		=> __( 'Primer caja de menu' ),
		)
	);

	// Check if Top menu exists and make it if not
	if ( !is_nav_menu( 'Primero' )) {
		
		$menu_id = wp_create_nav_menu( 'Primero' ); //crear menu (reservo id del menu)
		
		$menu = array( 'menu-item-type' => 'custom', 
		'menu-item-url' => get_home_url('/').'/acerca-de-atam', 
		'menu-item-title' => 'Acerca de', 
		'menu-item-status' => 'publish');
		wp_update_nav_menu_item( $menu_id, 0, $menu ); //adicionar item
		
		
		$menu = array( 'menu-item-type' => 'custom', 
		'menu-item-url' => get_home_url('/').'/institucional',
		'menu-item-title' => 'Institucional', 
		'menu-item-status' => 'publish');
		$institucional_ID = wp_update_nav_menu_item( $menu_id, 0, $menu ); //adicionar item (reservo id del item)
			
			
			$menu = array( 'menu-item-type' => 'custom', 
			'menu-item-url' => get_home_url('/').'/institucional/academica/',
			'menu-item-title' => 'Académicas',
			'menu-item-parent-id' => $institucional_ID, 
			'menu-item-status' => 'publish');
			 wp_update_nav_menu_item( $menu_id, 0, $menu ); //adicionarle subitem (al item creado antes)
			 
			
		
	
	}
	// Check if Header menu exists and make it if not
	
	// Get any menu locations that dont have a menu assigned to it and give it on
	/* Currently not working. couldnt fix it.
	$loc = array('Top', 'Header', 'Footer');
	if ( has_nav_menu( $location )) {
		$locations = get_nav_menu_locations();
		return (!empty( $locations[ $location ] ));
	}
	*/
}
 
 
