<?php
/** The \NV\Theme\Custom\Top Menu Walker class */

namespace NV\Theme\Custom;

use NV\Theme\Core;

class TopbarMenuWalker extends \Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"submenu mega menu vertical\" data-submenu>\n";
	}
} 