<?php
/*
Front Page template
*/
if ( have_posts() ) : while ( have_posts() ) : the_post();
  the_content();
  endwhile; else: ?>
  <p>Sorry, no posts matched your criteria.</p>
<?php
endif;

//include countdown timer
get_template_part('/templates/bookings/countdown');
?>
