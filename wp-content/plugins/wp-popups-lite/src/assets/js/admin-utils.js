;
var wpp = {

	cachedFields: {},
	savedState: false,
	orders:  {
		fields: [],
		choices: {}
	},

	// This file contains a collection of utility functions.
	/**
	 * Start the engine.
	 *
	 * @since 2.0.0
	 */
	init: function() {
		window.wp.hooks.addAction( 'wppopupsAdminBuilderReady', 'wppopups-pro', wpp.ready, 20);
	},

	/**
	 * Document ready.
	 *
	 * @since 2.0.0
	 */
	ready: function() {

		// Load initial form saved state.
		wpp.savedState = wpp.getFormState( '#wppopups-builder-popup' );

	},

	/**
	 * Get form state.
	 *
	 * @since 2.0.0
	 * @param object el
	 */
	getFormState: function( el ) {

		// Serialize tested the most performant string we can use for
		// comparisons.
		return jQuery( el ).serialize();
	},


	/**
	 * Update query string in URL.
	 *
	 * @since 2.0.0
	 */
	updateQueryString: function(key, value, url) {

		if ( ! url) {
			url = window.location.href;
		}
		var re = new RegExp( "([?&])" + key + "=.*?(&|#|$)(.*)", "gi" ),
			hash;

		if (re.test( url )) {
			if (typeof value !== 'undefined' && value !== null) {
				return url.replace( re, '$1' + key + "=" + value + '$2$3' );
			} else {
				hash = url.split( '#' );
				url  = hash[0].replace( re, '$1$3' ).replace( /(&|\?)$/, '' );
				if (typeof hash[1] !== 'undefined' && hash[1] !== null) {
					url += '#' + hash[1];
				}
				return url;
			}
		} else {
			if (typeof value !== 'undefined' && value !== null) {
				var separator = url.indexOf( '?' ) !== -1 ? '&' : '?';
				hash          = url.split( '#' );
				url           = hash[0] + separator + key + '=' + value;
				if (typeof hash[1] !== 'undefined' && hash[1] !== null) {
					url += '#' + hash[1];
				}
				return url;
			} else {
				return url;
			}
		}
	},

	/**
	 * Get query string in a URL.
	 *
	 * @since 2.0.0
	 */
	getQueryString: function(name) {

		var match = new RegExp( '[?&]' + name + '=([^&]*)' ).exec( window.location.search );
		return match && decodeURIComponent( match[1].replace( /\+/g, ' ' ) );
	},

	/**
	 * Is number?
	 *
	 * @since 2.0.0
	 */
	isNumber: function(n) {
		return ! isNaN( parseFloat( n ) ) && isFinite( n );
	},

	/**
	 * Empty check similar to PHP.
	 *
	 * @link http://locutus.io/php/empty/
	 * @since 2.0.0
	 */
	empty: function(mixedVar) {

		var undef;
		var key;
		var i;
		var len;
		var emptyValues = [undef, null, false, 0, '', '0'];

		for ( i = 0, len = emptyValues.length; i < len; i++ ) {
			if (mixedVar === emptyValues[i]) {
				return true;
			}
		}

		if ( typeof mixedVar === 'object' ) {
			for ( key in mixedVar ) {
				if ( mixedVar.hasOwnProperty( key ) ) {
					return false;
				}
			}
			return true;
		}

		return false;
	},

	/**
	 * Debug output helper.
	 *
	 * @since 2.0.0
	 * @param msg
	 */
	debug: function( msg ) {

		if ( wpp.isDebug() ) {
			if ( typeof msg === 'object' || msg.constructor === Array ) {
				console.log( 'WP Popups Debug:' );
				console.log( msg )
			} else {
				console.log( 'WP Popups Debug: ' + msg );
			}
		}
	},

	/**
	 * Is debug mode.
	 *
	 * @since 2.0.0
	 */
	isDebug: function() {

		return ( ( window.location.hash && '#wppopupsdebug' === window.location.hash ) || wppopups_builder.debug );
	},

	/**
	 * Focus the input/textarea and put the caret at the end of the text.
	 *
	 * @since 2.0.0
	 */
	focusCaretToEnd: function( el ) {
		el.focus();
		var $thisVal = el.val();
		el.val( '' ).val( $thisVal );
	},

};
wpp.init();
