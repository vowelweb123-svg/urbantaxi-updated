( function( api ) {

	// Extends our custom "urbantaxi" section.
	api.sectionConstructor['urbantaxi'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );