<?php
  $menu_items = wp_get_nav_menu_items('primary');

  echo '<ul>';

  foreach( $menu_items as $item ){
    //class list
    $classes = implode(' ', $item->classes);
    echo '<li class="'.$classes.'"><a href="'.$item->url.'">'.$item->title.'</a></li>';
  }

  echo '</ul>';
?>
