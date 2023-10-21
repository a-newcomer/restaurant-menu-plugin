<?php 
/*
* Template Name: Single AFN Menu
*/
get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<!-- POSTS SECTION -->
<article class="menu-section single">
	<div class="section-info">
		<h2 class="section-title"><?php the_title(); ?></h2>
		<p><?php the_content(); ?></p>
	</div>
    <?php

        if ( have_rows('menu_items') ):
        while ( have_rows('menu_items') ) : the_row();
            $item_title = get_sub_field('item_title');
            $item_desc = get_sub_field('item_description');
            $item_image = get_sub_field('item_image'); ?>
            
           <div class="afn-menu-item">

				<?php if ( !empty( $item_image ) ) { ?>
					<div class="image-wrapper">
						<div class="item-image" style="background-image:url('<?php echo $item_image['url']; ?>');"></div>
					</div>
				<?php } ?>
				<div class="info">
					<h3 class="item-title"> <?php echo $item_title  ?> </h3>
					<?php
						//sub subfields
						if( have_rows('prices_columns') ): ?>
							

							<!-- loop through rows (sub repeater) -->
							<div class="price-line">
								<?php
								while( have_rows('prices_columns') ): the_row();

									// display each sub item
									?>
									<div class="price-col">
									<?php if ( !empty( the_sub_field('size_or_amount' ) ) ){ ?>
										<h5><?php the_sub_field('size_or_amount'); ?></h5>
									<?php } ?>
										<p class="item-price">$<?php the_sub_field('price'); ?></p>
									</div>
								<?php endwhile; ?>
							</div>
						<?php endif; //if( get_sub_field('prices_columns') ): ?>
					<div class="item-desc"><?php echo $item_desc ?></div>
				</div>
            </div>
		<?php 
        endwhile;
        else :
            echo '<p>No menu items found.</p>';
        endif;
    ?>
</article>

<?php endwhile; else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.', 'foto-by-silvia' ); ?></p>
<?php endif; ?>			

<?php get_footer(); ?>
