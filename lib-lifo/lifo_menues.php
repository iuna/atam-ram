<?php
/* 
 * extender el menus de wp
 * por: lisandro fernandez 
 * 
 */
 


////////////////////////////////////////////
/* 
 * magnamara menu
 * extiende el walker del menu de wp
 */
////////////////////////////////////////////
function magomra_nav_menu( $menu_id ) {
		    // main navigation menu
    $args = array(
	'link_after'  => "&nbsp;",
	'menu'    => $menu_id ,
	'container'     => 'div',
	'container_id'      => 'top-navigation-primary',
	'conatiner_class'   => 'top-navigation',
	'menu_class'        => 'menu main-menu menu-depth-0 menu-even', 
	'echo'          => true,
	'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	'depth'         => 10, 
	'walker'        => new magomra_walker_nav_menu
    );
   // print menu
    wp_nav_menu( $args );
}


class magomra_walker_nav_menu extends Walker_Nav_Menu {
     
    // add classes to ul sub-menus
    function start_lvl( &$output, $depth ) {
        // depth dependent classes

	
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
       
 		$classes = array(
            'sub-menu',
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            'menu-depth-' . $display_depth, 
            
            );
        $class_names = implode( ' ', $classes );


		//dupplicado corregir esto
		

         
        // build html
        $output .= "\n" . $indent . '<ul class="' . $class_names .  ' ">' . "\n";
    }
 
    // add main/sub classes to li's and links
     function start_el( &$output, $item, $depth, $args ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
         
        // depth dependent classes
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
 
        // passed classes
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
 
	
	
        // build html
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="item-depth-' . $depth . ' ' . $depth_class_names . ' ' . $class_names . '  ">';
 
        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		
         
		if($depth == 0) {
		 	$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s', 
	            $args->before,
	            $attributes,
	           '_',
	            apply_filters( 'the_title', $item->title, $item->ID ),
	            $args->link_after,
	            $args->after
	        );
		}else{
        	$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s', 
            	$args->before,
            	$attributes,
				'&radic; ' ,
            	apply_filters( 'the_title', $item->title, $item->ID ),
				$args->link_after ,
            	$args->after
        	);
 		}

			

        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}


