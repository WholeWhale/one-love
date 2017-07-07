/* globals global */
jQuery(function($){
	var searchRequest;

	$('.school-autocomplete').easyAutocomplete({
		requestDelay: 500,
		getValue: 'name',
		url: function (val) {
			return global.search_api + '?value=' + val;
		},
		list: {
			onSelectItemEvent: function () {
				var data = $('.school-autocomplete').getSelectedItemData();

				$('.school-autocomplete-hidden').val(data.id);
			}
		}
	});
});
