(function ($) {
	'use strict';

	var icons = (window.homeseaIconSelect && window.homeseaIconSelect.icons) || {};

	function labelHtml(key) {
		var icon = icons[key];
		if (!icon) {
			return $('<span/>').text(key || '');
		}
		return $('<span class="homesea-icon-select-label"/>')
			.append($('<img/>', { src: icon.url, alt: '', width: 24, height: 24 }))
			.append(document.createTextNode(' ' + icon.label));
	}

	function clearUi($select) {
		$select.siblings('.homesea-icon-select-wrap').remove();
		$select.removeClass('homesea-icon-select--native');
		$select.removeData('homeseaEnhanced');
	}

	function enhance($select) {
		if (!$select.length || $select.closest('.empty-row').length) {
			return;
		}

		clearUi($select);
		$select.data('homeseaEnhanced', true);
		$select.addClass('homesea-icon-select--native');

		var $wrap = $('<div class="homesea-icon-select-wrap"/>');
		var $btn = $('<button type="button" class="homesea-icon-select-btn" aria-haspopup="listbox" aria-expanded="false"/>');
		var $list = $('<ul class="homesea-icon-select-list" role="listbox" hidden/>');

		$select.find('option').each(function () {
			var value = this.value;
			if (!value) {
				return;
			}
			$list.append(
				$('<li role="option"/>').attr('data-value', value).append(labelHtml(value))
			);
		});

		function syncButton() {
			var current = $select.val();
			$btn.empty().append(labelHtml(current));
			$list.find('li').removeClass('is-active').filter('[data-value="' + current + '"]').addClass('is-active');
		}

		function close() {
			$list.attr('hidden', true);
			$btn.attr('aria-expanded', 'false');
		}

		function open() {
			$list.removeAttr('hidden');
			$btn.attr('aria-expanded', 'true');
		}

		$btn.on('click', function (e) {
			e.preventDefault();
			e.stopPropagation();
			if ($list[0].hasAttribute('hidden')) {
				open();
			} else {
				close();
			}
		});

		$list.on('click', 'li', function (e) {
			e.preventDefault();
			e.stopPropagation();
			$select.val(String($(this).data('value'))).trigger('change');
			syncButton();
			close();
		});

		$wrap.append($btn).append($list);
		$wrap.insertAfter($select);
		syncButton();
	}

	function enhanceAll(context) {
		$(context || document)
			.find('select.homesea-icon-select')
			.each(function () {
				enhance($(this));
			});
	}

	$(function () {
		enhanceAll(document);

		$(document).on('click.homeseaIconSelect', function (e) {
			if ($(e.target).closest('.homesea-icon-select-wrap').length) {
				return;
			}
			$('.homesea-icon-select-list').attr('hidden', true);
			$('.homesea-icon-select-btn').attr('aria-expanded', 'false');
		});
	});

	$(document).on('cmb2_add_row cmb2_shift_rows_complete', function (evt, row) {
		enhanceAll(row || document);
	});
})(jQuery);
