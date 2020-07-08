<?php
/*
Plugin Name: Customization by PyrateTech
Plugin URI: https://pyratetech.com
Description: Adds functionalitity to WP
Author: nitemare
Version: 1.0
License: GPLv2
Text Domain: customPT
*/
// Allow SVG uploads

function allow_svgimg_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'allow_svgimg_types');

function jabberwock_get_verse() {
	
	$lyrics = "’Twas brillig, and the slithy toves	Did gyre and gimble in the wabe:
All mimsy were the borogoves,	And the mome raths outgrabe.
“Beware the Jabberwock, my son!	The jaws that bite, the claws that catch!”
“Beware the Jubjub bird, and shun	The frumious Bandersnatch!”
He took his vorpal sword in hand;	Long time the manxome foe he sought—
So rested he by the Tumtum tree	And stood awhile in thought.
And, as in uffish thought he stood,	The Jabberwock, with eyes of flame,
Came whiffling through the tulgey wood,	And burbled as it came!
One, two! One, two! And through and through	The vorpal blade went snicker-snack!
He left it dead, and with its head	He went galumphing back.
“And hast thou slain the Jabberwock?	Come to my arms, my beamish boy!
O frabjous day! Callooh! Callay!”	He chortled in his joy.
’Twas brillig, and the slithy toves	Did gyre and gimble in the wabe:
All mimsy were the borogoves,	And the mome raths outgrabe.";

	// Here we split it into lines.
	$lyrics = explode( "\n", $lyrics );

	// And then randomly choose a line.
	return wptexturize( $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ] );
}

function jabberwock() {
	$chosen = jabberwock_get_verse();
	$lang   = '';
	if ( 'en_' !== substr( get_user_locale(), 0, 3 ) ) {
		$lang = ' lang="en"';
	}

	printf(
		'<p id="jabberwock"><span class="screen-reader-text">%s </span><span dir="ltr"%s>%s</span></p>',
		__( 'Go back, it is a trap:' ),
		$lang,
		$chosen
	);
}

// Now we set that function up to execute when the admin_notices action is called.
add_action( 'admin_notices', 'jabberwock' );

// We need some CSS to position the paragraph.
function jabber_css() {
	echo "
	<style type='text/css'>
	#jabberwock {
		float: right;
		padding: 8px 10px;
		margin: 0;
		font-size: 10px;
		line-height: 1.6666;
	}
	.rtl #jabberwock {
		float: left;
	}
	.block-editor-page #jabberwock {
		display: none;
	}
	@media screen and (max-width: 782px) {
		#jabberwock,
		.rtl #jabberwock {
			float: none;
			padding-left: 0;
			padding-right: 0;
		}
	}
	</style>
	";
}

add_action( 'admin_head', 'jabber_css' );

add_action( 'wp_enqueue_scripts', 'pt_adding_scripts' );
function pt_adding_scripts() {
	global $post;
	wp_register_script('custom_main',plugins_url('js/main.js',__FILE__),array('jquery'),'1.14', true);
	wp_enqueue_script('custom_main');
}

function nm2mc_displayyear(){ return date('Y'); }
add_shortcode('year', 'nm2mc_displayyear');