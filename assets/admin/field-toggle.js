(function ($) {
	'use strict';

	function isOn($input) {
		if (!$input.length) {
			return true;
		}
		if ($input.is(':checkbox')) {
			return $input.is(':checked');
		}
		var v = String($input.val() || '').toLowerCase();
		return v === 'on' || v === '1' || v === 'yes' || v === 'true' || v === 'si' || v === 'sí';
	}

	function toggleGroup($input) {
		var targetClass = $input.attr('data-toggle-target') || '';
		if (!targetClass) {
			return;
		}

		var $wrap = $('.' + targetClass).closest('.cmb-row');
		if (!$wrap.length) {
			$wrap = $('.' + targetClass);
		}

		if (isOn($input)) {
			$wrap.show();
		} else {
			$wrap.hide();
		}
	}

	function bind() {
		$('[data-homesea-toggle-group]').each(function () {
			var $el = $(this);
			toggleGroup($el);
			$el.off('change.homeseaToggle').on('change.homeseaToggle', function () {
				toggleGroup($el);
			});
		});
	}

	$(bind);
	$(document).on('cmb2_add_row cmb2_remove_row cmb2_shift_rows_complete', bind);
})(jQuery);
