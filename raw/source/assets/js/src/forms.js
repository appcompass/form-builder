(function ($) {
	$(init);

	function init () {
		select();
		file();

		if (navigator.appVersion.toLowerCase().indexOf('msie 8') > -1) {
			checkbox();
			radio();
		}

		if (navigator.appVersion.toLowerCase().indexOf('msie') > -1) {
			placeholder();
		}
	}

	function select () {
		$('.select').find('select').each(function () {
			$(this).parent().find('span').text($(this).find(':selected').text());
		});

		$('.select').find('select').on('change', function () {
			$(this).parent().find('span').text($(this).find(':selected').text());
		});
	}

	function checkbox () {
		$('.checkbox').each(function () {
			var $this = $(this);

			if ($this.find('input').is(':checked')) {
				$this.find('label').addClass('checked')
			}
		}).on('change', 'input', function () {
			var $this = $(this);
			
			if ($this.is(':checked')) {
				$this.parent().find('label').addClass('checked');
			} else {
				$this.parent().find('label').removeClass('checked');
			}
		});
	}

	function radio () {
		var elems = document.getElementsByTagName('*');
		var radios = new Array();

		for (var e in elems) {
			if (elems[e].className && elems[e].className.indexOf('radio') > -1) {
				var radio = elems[e].getElementsByTagName('input')[0],
					label = elems[e].getElementsByTagName('label')[0];

				radios.push(elems[e]);

				if (radio.checked) {
					_add_class(label, 'checked');
				}

				radio.addEventListener(
					'change',
					(function (radio, label) {
						return function () {
							var group_name = radio.getAttribute('name');

							for (var r in radios) {
								var radio_child = radios[r].getElementsByTagName('input')[0];
								var label_child = radios[r].getElementsByTagName('label')[0];

								if (radio_child.getAttribute('name') === group_name) {
									_remove_class(label_child, 'checked');
								}

								if (radio_child.checked) {
									_add_class(label_child, 'checked');
								} else {
									_remove_class(label_child, 'checked');
								}
							}
						};
					})(radio, label),
					false
				);
			}
		}
	}

	function placeholder () {
		$('[placeholder]').each(function () {
			var $this = $(this);
			var value = $.trim($this.val());
			var placeholder = $.trim($this.attr('placeholder'));

			if (value === '') {
				$this.val(placeholder);
			}
		}).on('focus', function () {
			var $this = $(this);
			var value = $.trim($this.val());
			var placeholder = $.trim($this.attr('placeholder'));

			if (value === placeholder) {
				$this.val('');
			}
		}).on('blur', function () {
			var $this = $(this);
			var value = $.trim($this.val());
			var placeholder = $.trim($this.attr('placeholder'));

			if (value === placeholder || value === '') {
				$this.val(placeholder);
			}
		});
	}

	function file () {
		$('.file').find('input[type="file"]').on('change', function () {
			var filePath = $(this).val(),
			valArray = filePath.split('\\'),
			fileName = valArray[valArray.length-1];
			
			$(this).parent().parent().find('span').text(fileName);
		});

		$('.file').find('input[type="file"]').on('focusin', function() {
			$(this).parent().parent().find('span').addClass('focused');
		});

		$('.file').find('input[type="file"]').on('focusout', function() {
			$(this).parent().parent().find('span').removeClass('focused');
		});

	}


})($);