(function($) {

	$.fn.dataTable.moment = function ( format, locale ) {
		var types = $.fn.dataTableExt.aTypes;

		// Add type detection
		types.unshift( function ( d ) {
			// Null and empty values are acceptable
			if ( d === '' || d === null ) {
				return 'moment-'+format;
			}

			return moment( d.replace ? d.replace(/<.*?>/g, '') : d, format, locale, true ).isValid() ?
			'moment-'+format :
				null;
		} );

		function parseFormatToUnix(value, format, locale) {
			return value === '' || value === null ?
				-Infinity :
				parseInt( moment( value.replace ? value.replace(/<.*?>/g, '') : value, format, locale, true ).format( 'x' ), 10 );
		}

		// Add ascending sorting method
		$.fn.dataTableExt.oSort[ 'moment-'+format+'-asc' ] = function ( x, y ) {

			var parsedX = parseFormatToUnix(x, format, locale);
			var parsedY = parseFormatToUnix(y, format, locale);

			return parsedX - parsedY;
		};

		// Add descending sorting method
		$.fn.dataTableExt.oSort[ 'moment-'+format+'-desc' ] = function ( x, y ) {
			var parsedX = parseFormatToUnix(x, format, locale);
			var parsedY = parseFormatToUnix(y, format, locale);

			return parsedY - parsedX;
		};
	};

}(jQuery));

//https://datatables.net/plug-ins/sorting/datetime-moment
//js code 