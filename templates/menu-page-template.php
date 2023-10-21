
<?php 
/*
Template Name: Menu Page Template
*/

get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<!-- POSTS SECTION -->
<article class="menu-template menu-section single">
	<h2><?php //the_title(); ?></h2>
<!-- Call in the fields from acf -->
<?php
$menu_sections = get_field('choose_menu_sections');
       
if( $menu_sections ): ?>
        <?php foreach( $menu_sections as $menu_section ): ?>
    <section class="menu-section single">
        <?php
            $title = get_the_title( $menu_section->ID );
            $content = get_post_field('post_content',  $menu_section->ID);
            $menu_items = get_field( 'menu_items', $menu_section->ID );
            ?>
            
            <div class="section-info">
                <h3 class="section-title"> <?php echo esc_html( $title ); ?></h3>
                <p><?php echo ( $content ); ?></p>
            </div>
               <?php


      if ( have_rows('menu_items', $menu_section->ID ) ):
        while ( have_rows('menu_items', $menu_section->ID ) ) : the_row();
            $item_title = get_sub_field('item_title');
            $item_desc = get_sub_field('item_description', $menu_section->ID );
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
						if( have_rows('prices_columns', $menu_section->ID ) ): ?>
							

							<!-- loop through rows (sub repeater) -->
							<div class="price-line">
								<?php
								while( have_rows('prices_columns', $menu_section->ID ) ): the_row();

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
            echo '<p>No menu items found.</p>'; ?>
     
       <?php endif; ?>
    </section>  

    <?php endforeach; ?>
	<section class="overall-menu-info"><?php the_content(); ?></section>
<?php endif; ?>
    
</article>

<?php endwhile; else : ?>
	<p><?php echo 'No menus chosen yet'; ?></p>
<?php endif; ?>			

<?php get_footer(); ?>
