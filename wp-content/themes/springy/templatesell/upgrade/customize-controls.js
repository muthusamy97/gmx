( function( api ) {

	// Extends our custom "upgrade" section.
	api.sectionConstructor['springy_plus'] = api.Section.extend({

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
