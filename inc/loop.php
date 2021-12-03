<?php
/**
 * Loop
 *
 * @package 	TheDock
 * @author      Luis Colomé
 * @since       0.9.0
 * @license     GPL-2.0+
**/

/**
 * Use Archive Loop in every archive page (blog page included)
 *
 */
function lcm_use_archive_loop() {

    if( is_post_type_archive( 'etnias' ) || is_tax('destinos') || is_post_type_archive( 'viajes' ) ) {
        return;
    }

	if( ! is_singular()  ) {
		add_action( 'genesis_loop', 'lcm_archive_loop' );
		remove_action( 'genesis_loop', 'genesis_do_loop' );
	}
}
add_action( 'template_redirect', 'lcm_use_archive_loop', 20 );

/**
 * Archive Loop
 * Uses template partials from /partials
 */
function lcm_archive_loop() {

	if ( have_posts() ) {
		echo '<section class="lcm-posts grid ' . get_post_type() .'">'; // grid: for three column grid. list: for a image left align post list style.
            do_action( 'genesis_before_while' );

            while ( have_posts() ) {

                the_post();
                do_action( 'genesis_before_entry' );

                // Template part
                $partial = apply_filters( 'lcm_loop_partial', 'archive' );
                $context = apply_filters( 'lcm_loop_partial_context', is_search() ? 'search' : get_post_type() );
            
                get_template_part( 'partials/' . $partial, $context );

                do_action( 'genesis_after_entry' );

            }

            do_action( 'genesis_after_endwhile' );
		echo '</section>';

	} else {

		do_action( 'genesis_loop_else' );

	}
}