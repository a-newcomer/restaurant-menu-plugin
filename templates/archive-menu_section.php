<?php
/*
Template Name: Archive Menu Section
*/

get_header();

while ( have_posts() ) : the_post(); 
    // Your custom post content here
    
    ?>
    <h1>Menu archive page</h1>
<?php 
endwhile;

get_footer();
