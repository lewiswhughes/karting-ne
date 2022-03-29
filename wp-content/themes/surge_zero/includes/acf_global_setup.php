<?php
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => 'Global Areas',
    'menu_title'  => 'Global Areas',
    'menu_slug'   => 'theme-global-areas',
    'capability'  => 'edit_posts',
    'redirect'  => true
  ));
}

if( function_exists('acf_add_options_sub_page') ){
  //track schedule settings
  acf_add_options_sub_page(array(
    'page_title' => 'Track Schedule Settings',
    'parent_slug' => 'theme-global-areas',
    'capability' => 'edit_posts'
  ));
  //footer settings
  acf_add_options_sub_page(array(
    'page_title' => 'Footer Settings',
    'parent_slug' => 'theme-global-areas',
    'capability' => 'edit_posts'
  ));
  //general
  acf_add_options_sub_page(array(
    'page_title' => 'General',
    'parent_slug' => 'theme-global-areas',
    'capability' => 'edit_posts'
  ));
}


?>
