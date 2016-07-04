(function ( $ ) {
	$( document ).ready(function() {
		/* promobar */
		$( '.prmbr_block' ).wrapInner( '<div class="travel-advisor-container"></div>' );
		/*post template plugin*/
		if ( $( 'body' ).hasClass( 'page-template-gallery-template' ) ||
				$( 'body' ).hasClass( 'page-template-portfolio' ) ||
				$( 'body' ).hasClass( 'single-gallery' ) ||
				$( 'body' ).hasClass( 'single-portfolio' ) ) {
			$( '.main-container' ).wrapInner( '<div class="travel-advisor-container"></div>' );
			$( '#primary' ).attr( 'id', 'travel-advisor-post-content' );
		}
		$( '.page-template-page-template-gallery-template #travel-advisor-post-content' ).addClass( 'travel-advisor-gallery-template' );
		/* multilevel-top-menu */
		/* slide for multilevel lists */
		$( '#travel-advisor-header-nav li' ).mouseenter(function() {
			/*we get rest space from current sub menu to right side of window */
			var windowWidth = $( window ).width();
			var parentWidth = $( this ).width();
			var offset = $( this ).offset();
			var parentLeftOffset = offset.left;
			var restSpace = windowWidth - parentLeftOffset - parentWidth;
			 /* displaying next sub menu right or left of the previous sub menu */
			if( restSpace < 250 && ( $( this ).parent().hasClass( 'sub-menu' ) ||
					$( this  ).parent().hasClass( 'children' ) ) ) {
				$( this ).children( 'ul' ).css({ marginLeft: '-100px', marginTop: '54px' });
			}
			if ( windowWidth <= 1199 ) {
				if ( restSpace < 218&& ( $( this ).parent().hasClass( 'sub-menu' ) || 
						$( this  ).parent().hasClass( 'children' ) ) ) {
					$( this ).children( 'ul' ).css({ marginLeft: '-50px', marginTop: '34px' });
				}
			}
			if ( windowWidth <= 765 ) {
				if ( restSpace < 90&& ( $( this ).parent().hasClass( 'sub-menu' ) || 
						$( this  ).parent().hasClass( 'children' ) ) ) {
					$( this ).children( 'ul' ).css({ marginLeft: '-117px', marginTop: '35px' });
				}
			}
		} );
		/* carousel script */
		$( '#carousel' ).owlCarousel( {
			navigation: true,
			slideSpeed: 300,
			paginationSpeed: 400,
			singleItem: true,
			autoPlay: false,
			navigationText: ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
		} ); /* end carousel script in houm */
		$( 'div[id^=owl-carousel]' ).owlCarousel( {
			navigation: true,
			slideSpeed: 300,
			paginationSpeed: 400,
			singleItem: true,
			navigationText: ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
		} );
		/* mobile_menu_button */
		$( '.travel-advisor-mobile-menu-button' ).click(function() {
			$( '.menu' ).toggle( 'slow' );
		} );
		/* .menu-item-has-children > a:after */
		$( '.travel-advisor-mobile-menu-button li a:after' ).click(function() {
			$( 'a:after' ).toggle( 'slow' );
		} );
		/* select */
		$( 'select' ).addClass( 'styled' );
		$( '.styled' ).selectbox();
		/*selecter dropdown*/	
		if( $( '.selecter' ).length > 0 ) {
			$( '#order .selecter, #per_page .selecter' ).change(function() {
				$( this ).parent().submit();
			} );
		}
		/*zoom*/
		$( '.format-image a img' ).wrap( '<div class="img-zoom"></div>' );
		$( '.format-image a img' ).after( '<div class="img-lupa"></div>' );
		$( '.format-image .fcbk_share img' ).unwrap( '<div class="img-zoom"></div>' );
	} );
	$(function () {
		$('#travel-advisor-header-menu li:has(ul)').doubleTapToGo();
	} );
} ) ( jQuery );

/*scrollTop*/
var t;
function up() {
	var top = Math.max( document.body.scrollTop, document.documentElement.scrollTop );
	if( top > 0 ) {
		window.scrollBy( 0 , -15 );
		t = setTimeout( 'up()' , 1 );
	} else {
		clearTimeout( t );
	}
	return false;
}

/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/
(function( $, window, document, undefined ) {
	$.fn.doubleTapToGo = function( params ) {
		if( !( 'ontouchstart' in window ) &&
			!navigator.msMaxTouchPoints &&
			!navigator.userAgent.toLowerCase().match( /windows phone os 7/i ) ) return false;
		this.each( function() {
			var curItem = false;
			$( this ).on( 'click', function( e ) {
				var item = $( this );
				if( item[ 0 ] != curItem[ 0 ] ) {
					e.preventDefault();
					curItem = item;
				}
			} );
			$( document ).on( 'click touchstart MSPointerDown', function( e ) {
				var resetItem = true,
					parents	  = $( e.target ).parents();
				for( var i = 0; i < parents.length; i++ )
					if( parents[ i ] == curItem[ 0 ] )
						resetItem = false;
				if( resetItem )
					curItem = false;
			} );
		 } );
		return this;
	};
} ) ( jQuery, window, document );