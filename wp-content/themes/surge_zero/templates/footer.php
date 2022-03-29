<footer>
  <!--left-->
  <div class="left mailing-form">
    <?= get_template_part('/templates/forms/footer-mailing-list'); ?>
  </div>
  <!--right-->
  <div class="right">
    <ul class="links">
      <?php
        $links = get_field('footer_links', 'option');
        if( is_array($links) ){
          foreach( $links as $link ){
            $post_type = get_post_type( $link['link_item']->ID );
            $href = ( $post_type=='attachment' ) ? wp_get_attachment_url($link['link_item']->ID) : get_permalink($link['link_item']->ID) ;
            echo '<li><a href="'.$href.'">'.$link['display_text'].'</a></li>';
          }
        }
      ?>
    </ul>
    <div class="logo">
      <?= get_template_part('/templates/icons/kne-logo-vertical'); ?>
    </div>
    <div class="copyright">
      <?= get_field('copyright', 'options'); ?>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
