<?php
/** The \NV\Theme\Custom\Curtain Menu Walker class */

namespace NV\Theme\Custom;

use NV\Theme\Core;

class CurtainMenuWalker extends \Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"submenu curtain-menu-list menu vertical\" data-submenu>\n";
		
	}
} 