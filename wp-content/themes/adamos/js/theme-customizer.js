/**

 * Theme Customizer enhancements for a better user experience.

 *

 * Contains handlers to make Theme Customizer preview reload changes asynchronously.

 */



( function( $ ) {

	// Site title and description.

	wp.customize( 'blogname', function( value ) {

		value.bind( function( to ) {

			$( '.site-title a' ).html( to );

		} );

	} );

	wp.customize( 'blogdescription', function( value ) {

		value.bind( function( to ) {

			$( '.site-description' ).html( to );

		} );

	} );

	wp.customize( 'header_textcolor', function( value ) {

		value.bind( function( to ) {

			$( '.site-title a, .site-description' ).css( 'color', to );

		} );

	} );

	wp.customize( 'background_color', function( value ) {

		value.bind( function( to ) {

			$( '#wrap' ).css( 'background-color', to );

		} );

	} );



	wp.customize( 'copyright_text', function( value ) {

		value.bind( function( to ) {

			$( '.site-info p' ).html( to );

		} );

	} );

	wp.customize( 'homepage_recent_title', function( value ) {

		value.bind( function( to ) {

			$( '.section_thumbnails h3' ).html( to );

		} );

	} );


	/* SERVICE SECTION */

	wp.customize( 'homepage_service_title', function( value ) {

		value.bind( function( to ) {

			$( '.featuretext_middle h3' ).html( to );

		} );

	} );

	wp.customize( 'featured_textbox_header_one', function( value ) {

		value.bind( function( to ) {

			$( '.box-1 .featuretext h4 a' ).html( to );

		} );

	} );

	wp.customize( 'featured_textbox_header_two', function( value ) {

		value.bind( function( to ) {

			$( '.box-2 .featuretext h4 a' ).html( to );

		} );

	} );

	wp.customize( 'featured_textbox_header_three', function( value ) {

		value.bind( function( to ) {

			$( '.box-3 .featuretext h4 a' ).html( to );

		} );

	} );

	wp.customize( 'featured_textbox_text_one', function( value ) {

		value.bind( function( to ) {

			$( '.box-1 .featuretext p' ).html( to );

		} );

	} );

	wp.customize( 'featured_textbox_text_two', function( value ) {

		value.bind( function( to ) {

			$( '.box-2 .featuretext p' ).html( to );

		} );

	} );

	wp.customize( 'featured_textbox_text_three', function( value ) {

		value.bind( function( to ) {

			$( '.box-3 .featuretext p' ).html( to );

		} );

	} );


	wp.customize( 'adamos_custom_main_color', function( value ) {

		value.bind( function( to ) {

			$( '.main-navigation li:hover > a,.main-navigation li.current_page_item a,.main-navigation li.current-menu-item a,.menu-toggle' ).css( 'background-color', to );

			$( '#masthead-wrap,.section_thumbnails h3,.featuretext_middle > h3,.site-info,.sticky h1,.authorAvatar img' ).css( 'border-color', to );

			$( '.main-navigation ul ul a,.main-navigation ul ul a:hover,.main-navigation ul ul ul a:hover,.featuretext_top h3,.section_thumbnails h3,.featuretext_middle > h3,.entry-title,.page-title,.entry-title a,.page-title a,.nav-previous a,.nav-next a,.main-small-navigation li:hover > a,.main-small-navigation li.current_page_item a,.main-small-navigation li.current-menu-item a,.main-small-navigation ul ul a:hover,.entry-content a,.entry-content a:visited,.entry-summary a,.entry-summary a:visited' ).css( 'color', to );

		} );

	} );
		

} )( jQuery );