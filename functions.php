<?php

/*
** Homepage custom hook form HomePage Controle Plugin
*/
require get_stylesheet_directory() . '/inc/homepage_hook.php';

/*
** Hooks template to customize default loop & out hover loop
*/
require get_stylesheet_directory() . '/inc/template_hook.php';

/*
** Templates Changes Function (eg. use fullwidth template without sidebar)
*/
require get_stylesheet_directory() . '/inc/template_style.php';

/*
** Utils
*/
require get_stylesheet_directory() . '/inc/utils.php';

/*
** Styles load enqueue
*/
function theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

?>