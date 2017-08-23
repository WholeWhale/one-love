/* globals global */
jQuery(function($){

	setTimeout(function () {

		$('.school-autocomplete').easyAutocomplete({
			requestDelay: 500,
			getValue: 'name',
      adjustWidth: false, 
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

	}, 1000);
});
