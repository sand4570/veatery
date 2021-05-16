<!--Vores functions.php sørger for at hente al indhold fra vores parent theme. Derudover sørger den for at hente al indholdet fra vores style.ccs, der blandt andet beskriver hvilket parent theme vi har valgt at arbejde med. -->


<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style('style', get_stylesheet_uri());
}



?>