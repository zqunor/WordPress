(function( $ ) {
	"use strict";

	/*** Icon Picker ***/

	$.fn.hybridextendWidgetIconPicker = function() {
		return this.each(function() {

			var $self       = $(this),
				$picker_box = $self.siblings('.hybridext-icon-picker-box'),
				$button     = $self.siblings('.hybridext-icon-picked'),
				$preview    = $button.children('i'),
				$icons      = $picker_box.find('i');

			$button.on( "click", function() {
				$picker_box.toggle();
			});

			$icons.on( "click", function() {
				var iconvalue = $(this).data('value');
				$icons.removeClass('selected');
				var selected = ( ! $(this).hasClass('cmb-icon-none') ) ? 'selected' : '';
				$(this).addClass(selected);
				$preview.removeClass().addClass('fa ' + selected + ' ' + iconvalue );
				$self.val(iconvalue);
				$self.trigger('change');
				$picker_box.toggle();
			});

		});
	};
	$(document).on('click', function(event) {
		// If this is not inside .hybridext-icon-picker-box or .hybridext-icon-picked
		if (!$(event.target).closest('.hybridext-icon-picker-box').length
			&&
			!$(event.target).closest('.hybridext-icon-picked').length ) {
			$('.hybridext-icon-picker-box').hide();
		}
	});

	/*** Image Upload ***/

	$.fn.hybridextendWidgetImageUpload = function() {
		return this.each(function() {
			if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {

				var $button   = $(this),
					$input    = $button.siblings('.hybridext-image'),
					$preview  = $button.children('.hybridext-image-selected-img'),
					$remove   = $button.siblings('.hybridext-image-remove');

				$remove.on( "click", function(e) {
					e.preventDefault();
					$input.val('');
					$input.trigger('change');
					$preview.css('background-image', 'none');
				});

				$button.on( "click", function(e) {
					// e.preventDefault();
					// wp.media.editor.send.attachment = function(props, attachment) {
					// 	$input.val(attachment.id);
					// 	$inputurl.val(attachment.url);
					// 	$preview.css('background-image', 'url('+attachment.url+')');
					// };
					// wp.media.editor.open($button);
					// return false;

					var frame = $button.data('frame');

					// If the media frame already exists, reopen it.
					if ( frame ) {
						frame.open();
						return false;
					}

					// Create the media frame.
					frame = wp.media( {
						title: $button.data('title'), // Set the title of the modal.
						library: {
							// Tell the modal to show only images.
							type: $button.data('library').split(',').map(function(v){ return v.trim() })
						},
						button: {
							text: $button.data('update'), // Set the text of the button.
							close: false // Tell the button not to close the modal
						}
					} );

					// Store the frame
					$button.data('frame', frame);

					// When an image is selected, run a callback.
					frame.on( 'select', function() {
						// Grab the selected attachment.
						var attachment = frame.state().get('selection').first().attributes;
						// Update Image ID
						$input.val(attachment.id);
						$input.trigger('change');
						// Update Image URL
						var imageurl = '';
						if(typeof attachment.sizes !== 'undefined'){
							if(typeof attachment.sizes.thumbnail !== 'undefined')
								imageurl = attachment.sizes.thumbnail.url;
							else
								imageurl = attachment.sizes.full.url;
						} else {
							imageurl = attachment.icon;
						}
						$preview.css('background-image', 'url('+imageurl+')');
						// Close Frame
						frame.close();
					} );

					// Finally, open the modal.
					frame.open();

					return false;
				});

			}
		});
	};

	/*** Setup Widget ***/

	$.fn.hybridextSetupWidget = function() {

		var setupAdd = function( $container, widgetClass, dynamic ){
			// Add Group Item
			$container.find('.hybridext-widget-field-group-add').each( function() {
				var $addGroup   = $(this),
					$itemList   = $addGroup.siblings('.hybridext-widget-field-group-items'),
					groupID     = $addGroup.parent('.hybridext-widget-field-group').data('id'),
					newItemHtml = window.hybridext_widget_helper[widgetClass][groupID];

				$addGroup.on( "click", function() {
					var iterator = parseInt( $(this).data('iterator') );
					iterator++;
					$(this).data('iterator', iterator);
					var newItem = newItemHtml.trim().replace(/975318642/g, iterator);

					var $newItem = $(newItem);
					setupToggle( $newItem );
					setupRemove( $newItem );
					$newItem.find('.hybridext-icon').hybridextendWidgetIconPicker();
					$newItem.find('.hybridext-image-selected').hybridextendWidgetImageUpload();
					$newItem.find('.hybridext-color').wpColorPicker();
					//init( $newItem, widgetClass, true ); //@todo
					$itemList.append($newItem);
					$addGroup.closest('.hybridext-widget-form').find('input').filter(":first").trigger('change');
					// $addGroup.prev('input.hybridext-widget-field-group-placeholder').trigger('change');
				});
			});
			// Collapse/Expand All Groups Items
			$container.find('.hybridext-widget-field-group-top').click( function(){
				$(this).toggleClass('open');
				if( $(this).is('.open') )
					$(this).siblings('.hybridext-widget-field-group-items').find('.hybridext-widget-field-group-item-form').show();
				else
					$(this).siblings('.hybridext-widget-field-group-items').find('.hybridext-widget-field-group-item-form').hide();
			});
		};

		var setupToggle = function( $container ) {
			// Make groups collapsible
			$container.find('.hybridext-widget-field-group-item-top').on( "click", function() {
				$(this).siblings('.hybridext-widget-field-group-item-form').toggle();
			});
		};

		var setupRemove = function( $container ) {
			// Make group items removable
			$container.find('.hybridext-widget-field-group-remove').on( "click", function() {
				// $(this).closest('.hybridext-widget-field-group-items').siblings('input.hybridext-widget-field-group-placeholder').trigger('change');
				$(this).closest('.hybridext-widget-form').find('input').filter(":first").trigger('change');
				$(this).closest('.hybridext-widget-field-group-item').remove();
			});
		};

		return this.each( function(i, el) {
			var $self       = $(el),
				widgetClass = $self.data('class');

			// Skip this if we've already set up the form, or if template widget
			if ( $('body').hasClass('widgets-php') ) {
				if ( $self.data('hybridextend-form-setup') === true ) return true;
				//if ( $self.closest('.widget').attr('id').indexOf("__i__") > -1 ) return true;
				//if ( $self.closest('#widgets-left').length > 0 ) return true;
				if ( !$self.is(':visible') ) return true;
			}

			$self.find('.hybridext-icon').hybridextendWidgetIconPicker();
			$self.find('.hybridext-image-selected').hybridextendWidgetImageUpload();
			$self.find('.hybridext-color').wpColorPicker();

			setupAdd( $self, widgetClass, false );
			setupToggle( $self );
			setupRemove( $self );

			// All done.
			$self.trigger('hybridextendwidgetformsetup').data('hybridextend-form-setup', true);
		});

	};

	/*** Initialize Stuff ***/

	// Initialize existing hybridextend forms
	$('.hybridext-widget-form').hybridextSetupWidget();

	// When we click on a widget top or drag an instance to a widget area
	$('.widgets-holder-wrap').on('click', '.widget:has(.hybridext-widget-form) .widget-top', function(){
		var $$ = $(this).closest('.widget').find('.hybridext-widget-form');
		setTimeout( function(){ $$.hybridextSetupWidget(); }, 200);
	});

}(jQuery));