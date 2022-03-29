<?php
  use SurgeZero\Wrapper;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>

  <body <?php body_class(); ?>>
    <?php get_template_part('templates/header'); ?>
    <?php
      include Wrapper\template_path();
    ?>

    <?php get_template_part('/templates/bookings/countdown'); //CALL CART AND COUNTDOWN ?>
    <?php get_template_part('/templates/bookings/remove-non-linked-items'); //CALL CART AND COUNTDOWN ?>

    <?php //echo Wrapper\template_path(); ?>
    <?php get_template_part('templates/footer'); ?>

    <!--ms detection-->
    <?php get_template_part('templates/ms-detector'); ?>
  </body>
</html>
