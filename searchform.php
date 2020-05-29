?<?php
/* 
  * Search form Template
  *@package Lumen Ambient
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}?>

<div class="search-form">
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <div class="input-group">
    <input class="input-group-field" type="search"  value="<?php echo get_search_query(); ?>" name="s" >
    <div class="input-group-button">
      <input type="submit" class="button" value="Search">
    </div>
  </div>
</form>
</div>

