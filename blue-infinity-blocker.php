<?php

/**
 * Plugin Name: Blue Infinity Blocker
 * Plugin URI: https://git.sr.ht/~mfru/wp-blue-infinity-blocker
 * Description: A plugin that acts as a measure against Metas newest habit of injecting custom tracking JS into in-app browser sessions.
 * Version: 1.0.0
 * Author: Maximilian Frühschütz
 * Author URI: https://maxfruehschuetz.dev
 * License: GPL 3.0 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 *    Blue Infinity Blocker — A plugin that acts as a measure against Metas newest habit of injecting custom tracking JS into in-app browser sessions.
 *    Copyright (C) 2022  Maximilian Frühschütz
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

// Source for implementation: https://krausefx.com/blog/ios-privacy-instagram-and-facebook-can-track-anything-you-do-on-any-website-in-their-in-app-browser

add_action('wp_head', 'blb_fake_tracker_available');
function blb_fake_tracker_available()
{
	// Let Meta think that their tracker is already installed
?>

	<span id="iab-pcm-sdk"></span>
	<span id="iab-autofill-sdk"></span>
<?php }

add_action('wp_footer', 'blb_stop_text_selection');
function blb_stop_text_selection()
{
	// prevents Meta from tracking selected text
?>

	<script>
		const originalEventListener = document.addEventListener
		document.addEventListener = function(a, b) {
			if (b.toString().indexOf("messageHandlers.fb_getSelection") > -1) {
				return null;
			}
			return originalEventListener.apply(this, arguments);
		}
	</script>

<?php }
