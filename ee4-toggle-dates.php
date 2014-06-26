<?php
/*
Plugin Name: Event Espresso 4 Toggle dates
Plugin URI: https://github.com/joshfeck/ee4-toggle-dates
Description: A tiny plugin that hides datetimes and adds a toggle button to show them, with JavaScript.
Version: 0.1
License: GPL
Author: Josh Feck

=== RELEASE NOTES ===
2014-06-25 - v1.0 - first version
*/

/* 
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Online: http://www.gnu.org/licenses/gpl.txt
*/

add_action( 'wp_footer', 'td_toggle_extra_datetimes');

function td_toggle_extra_datetimes() {
	global $post;
	
	// set up a check for the [ESPRESSO_EVENTS] shortcode in the post content
	$content_post = get_post($post);
	$content = $content_post->post_content;

	// check for Event Espresso event content and if it's there, inject some JS
	if ( 'espresso_events' == get_post_type( $post ) || has_shortcode( $content, 'ESPRESSO_EVENTS' ) ) {
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			$( 'ul[id^="ee-event-datetimes-ul-"]' ).each(function(){
				var n = $( this ).find( 'li' ).length;
				var b = '<ul style="list-style-type:none;">';
				b += '<li style="list-style-type:none;">';
				b += '<button class="toggle-button">More Dates</button>';
				b += '</li></ul>';
				if ( n > 1 ) {
    				$( this ).find( 'li:gt(0)' ).hide();
    				$( this ).after( b );
    			}
			});
		    $( '.toggle-button' ).click(function() {
				var txt = $( 'ul[id^="ee-event-datetimes-ul-"] li:not(:first-child)' ).is( ':visible' ) ?
				'More Dates' :
				'Less Dates';
				$( this ).text( txt );
				$( this )
					.parents( 'div.event-datetimes' )
					.children( '.ee-event-datetimes-ul' )
					.find( 'li:not(:first-child)' )
					.slideToggle( 'slow' );
			});
		});
		</script>
		<?php
	}
}
