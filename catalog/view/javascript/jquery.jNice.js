/*
 * UPDATED: 12.19.07
 *
 ******************************************** */
(function($){
	$.fn.jNice = function(options){
		var self = this;
		var safari = $.browser.safari; /* We need to check for safari to fix the input:text problem */
		var zindexflag = 100;
		

		/* each form */
		this.each(function(){
			
			
			
			/***************************
			  Text Fields 
			 ***************************/
			var setText = function(){
				var $input = $(this);
				$input.addClass("jNiceInput").wrap('<div class="jNiceInputWrapper"><div class="jNiceInputInner"><div></div></div></div>');
				var $wrapper = $input.parents('div.jNiceInputWrapper');
				$wrapper.css("width", $(this).width()+10);
				$input.focus(function(){
					$wrapper.addClass("jNiceInputWrapper_hover");
				}).blur(function(){
					$wrapper.removeClass("jNiceInputWrapper_hover");
				});
			};
			$('input:text:visible, input:password', this).each(setText);
			/* If this is safari we need to add an extra class */
			/*if (safari){$('.jNiceInputWrapper').each(function(){$(this).addClass('jNiceSafari').find('input').css('width', $(this).width()+11);});}
			*/
			/***************************
			  Check Boxes 
			 ***************************/
			$('input:checkbox', this).each(function(){
				$(this).addClass('jNiceHidden').wrap('<span></span>');
				var $wrapper = $(this).parent();
				$wrapper.prepend('<a href="#" class="jNiceCheckbox"></a>');
				
				/* Click Handler */
				$(this).siblings('a.jNiceCheckbox').click(function(){
						var $a = $(this);
						var input = $a.siblings('input')[0];
						if (input.checked===true){
							input.checked = false;
							$a.removeClass('jNiceChecked');							
						}
						else {
							input.checked = true;
							$a.addClass('jNiceChecked');							
						}
						return false;
				});
				/* set the default state */
				if (this.checked){$('a.jNiceCheckbox', $wrapper).addClass('jNiceChecked');}
			});
			
			/***************************
			  Radios 
			 ***************************/
			$('input:radio', this).each(function(){
				$input = $(this);
				$input.addClass('jNiceHidden').wrap('<span class="jRadioWrapper"></span>');
				var $wrapper = $input.parent();
				$wrapper.prepend('<a href="#" class="jNiceRadio" rel="'+ this.name +'"></a>');
				/* Click Handler */
				$('a.jNiceRadio', $wrapper).click(function(){
						var $a = $(this);
						$a.siblings('input')[0].checked = true;
						$a.addClass('jNiceChecked');
						/* uncheck all others of same name */
						$('a[rel="'+ $a.attr('rel') +'"]').not($a).each(function(){
							$(this).removeClass('jNiceChecked').siblings('input')[0].checked=false;
						});
						return false;
				});
				/* set the default state */
				if (this.checked){$('a.jNiceRadio', $wrapper).addClass('jNiceChecked');}
			});
	
			
			
			
			
		
		}); /* End Form each */
		
		/* Hide all open selects */
		var hideSelect = function(){
			$('.jNiceSelectWrapper ul:visible').hide();
		};
		
		/* Check for an external click */
		var checkExternalClick = function(event) {
			if ($(event.target).parents('.jNiceSelectWrapper').length === 0) { hideSelect(); }
		};

		/* Apply document listener */
		$(document).mousedown(checkExternalClick);
		
			
		/* Add a new handler for the reset action */
		var jReset = function(f){
			var sel;
			$('.jNiceSelectWrapper select', f).each(function(){sel = (this.selectedIndex<0) ? 0 : this.selectedIndex; $('ul', $(this).parent()).each(function(){$('a:eq('+ sel +')', this).click();});});
			$('a.jNiceCheckbox, a.jNiceRadio', f).removeClass('jNiceChecked');
			$('input:checkbox, input:radio', f).each(function(){if(this.checked){$('a', $(this).parent()).addClass('jNiceChecked');}});
		};
		this.bind('reset',function(){var action = function(){jReset(this);}; window.setTimeout(action, 10);});
		
	};/* End the Plugin */
	
	
	$.jNice = {
			SelectUpdate : function(element){ SelectUpdate(element); }
	};/* End Utilities */
	/* Automatically apply to any forms with class jNice */
	$(function(){$('form.jNice').jNice();	});

})(jQuery);
				   
