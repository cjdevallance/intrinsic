/**
 * Ghost Captcha
 * Clent-side helper plugin for the PHP GhostCaptcha class
 * For sale on CodeCanyon.net
 * 
 * @package GhostCaptcha
 * @author Patrick Jaoko - http://pjtops.com/app/GhostCaptcha/
 * @copyright Patrick Jaoko ©2012
 * 
 */
;(function( $ ){
"use strict";
/*jslint white: true, browser: true, devel: false, windows: false, debug: false, vars: false, indent: 4 */
/*global jQuery */
var methods, debug;
 
debug = false;
methods = {

	
/**
 * Sets up the forms Ghost Captcha properties, with data received from an ajax request
 * @param  jQuery $form       The selected form node
 * @param Object responseData The JSON object received from the server
 */	
	set: function( $form, responseData ){
		var data, $honeypot;
		data = $form.data('ghostCaptcha');
		
		$honeypot = $(responseData.honeypot);
		if( !data.honeypot ){			
			$form.append($honeypot);
		}
		
		data.honeypot = $honeypot;
		data.captcha = $(responseData.captcha);
		data.imgURLs = responseData.imgURLs;
	},

/**
 * This function is triggered by methods.validate whenever client-side validation fails.
 * It inserts or updates a normal form captcha test.
 * 
 * @param  jQuery $form The target form
 * @return Object data  A variable pointing to $form.data('ghostcaptcha')
 */	
	loadCaptcha: function( $form, data ){
		var $submitBtn, src, newSrc, selected;
		
		if( data.captchaImage === false ){
			if( data.settings.captchaTarget ){
				data.settings.captchaTarget.append(data.captcha);
			}else {
				$submitBtn = $( 'input[type="submit"]:last', $form );
				if( $submitBtn.length === 1 ){
					$submitBtn.before(data.captcha);
				}else {
					$form.append(data.captcha);
				}
			}
			data.captchaImage = $( 'img.ghostCaptcha-image', $form );
			data.captchaInput = $( 'input[name="ghostCaptcha"]', $form );
		}else {
			if( data.imgURLs.length > 1 ){
				src = data.captchaImage.attr('src');
				selected = false;
				while( !selected ){
					newSrc = data.imgURLs[ Math.floor( Math.random() * data.imgURLs.length ) ];
					if( newSrc !== src ){
						data.captchaImage.attr( 'src', newSrc );
						selected = true;
					}
				}				
			}			
		}
		data.captchaInput.val('');
		data.honeypot.val( data.captchaImage.attr('src') ); 
	},

/**
 * The form's submit() event handler. Sniffs out suspected spambots by timing how fast
 * the form is submitted. If the normal captcha test is loaded, makes sure its not empty. 
 * @return Boolean isValid True if human, false for suspected spambots
 */	
	validate: function(){
		var $form, data, time, isValid;
		$form = $(this);
		data = $form.data('ghostCaptcha');		

		if( data.honeypot === false ){
			//Captcha data hasn't yet downloaded. leave verification to the server
			isValid = true;
		}else if( data.captchaImage === false ){ 
			// still in ghost-captcha mode
			time = new Date().getTime() / 1000;
			if( time - data.timerStart < data.settings.timerMin ){
				// form filled too fast, triggers real captcha display
				methods.loadCaptcha( $form, data );
				isValid = false;
			}else {
				isValid = true;
			}
		}else if( data.captchaInput.val().length < 4 ){
			//captcha test loaded, but test input still empty. Load new captcha test image
			methods.loadCaptcha( $form, data );
			isValid = false;
		}else {
			isValid = true;
		}
		
		if( data.settings.onValidate ){
			data.settings.onValidate( isValid, $form.get(0) ); 
			return false;
		}
		return isValid;
	},
	
/**
 * Displays an error message to help debugging invalid plugin configuration settings 
 * @param Mixed errors A string, or array with strings of error messages
 */
	showErrors: function( errors ){
		if( !debug ){ return; }
		var msg = ( $.isArray(errors) )? errors.join("\n") : errors;
		window.alert(msg);
		$.error(msg);		
	}
};
	
/**
 * The main plugin function.
 * @param Object customOptions Custom configuration settings to extend default setting
 * @return Object this The jQuery selection object
 */
$.fn.ghostCaptcha = function( customOptions ){
	var errors = [], defaultSettings = {}, settings, $captchaTarget; 
	
	defaultSettings = {  debug:false, timerMin:2, URL:'GhostCapcha.php', captchaTarget: null, onValidate: null };	
	
	errors = [];	 
	if( customOptions.timerMin ){
		if( isNaN(customOptions.timerMin) ){
			errors.push("The value set for timerMin in ghostCaptcha must be a valid number.");
		}
		customOptions.timerMin = parseInt( customOptions.timerMin, 10 );
	}
	if( customOptions.captchaTarget ){
		$captchaTarget = $( '#' + customOptions.captchaTarget );
		if( customOptions.captchaTarget.length !== 1 ){
			errors.push('No single element with an id of ' + customOptions.captchaTarget + ' was found for the captchaTarget');
		}else {
			customOptions.captchaTarget = $captchaTarget;
		}
	}
	if( customOptions.onValidate && typeof customOptions.onValidate !== 'function' ){
		errors.push("The value set for onValidate in ghostCaptcha must be a JavaScript function.");
	}
	if( errors.length > 0 ){ methods.showErrors(errors); }
		
	settings = $.extend( defaultSettings, customOptions );
	debug = settings.debug;
	
	return this.each( function(){ 
		var $form, data;
		$form = $(this);
		data = {settings: settings, 
				timerStart: (new Date().getTime() / 1000), 
				honeypot: false, 
				captcha: false, 
				captchaImage: false, 
				captchaInput: false, 
				imgURLs: []
				};
		data.id =  Math.floor( Math.random() * data.timerStart / 100 );
		
		if( this.nodeName.toLowerCase() !== 'form' ){
			 methods.showErrors('Ghost Captcha can only be used on <form> elements.');
			 return true;
		}
		
		$form.append( $('<input type="hidden" name="formId" value="' + data.id + '" />') );		
		data.settings.timerMin *= $( ':input', $form ).length;		
		$form.data( 'ghostCaptcha', data ); 
		$form.submit(methods.validate);
		$( ':input', $form ).attr( 'autocomplete', 'off' );
		
		jQuery.ajax({
			url: data.settings.URL,
			type: 'POST',
			cache: false,
			data: { jsSetRequest:true, formId:data.id },
			dataType: 'json',
			error: function(){ 
						methods.showErrors('Ghost Captcha was unable to post data to: "' + data.settings.URL + '".' );
					},
			success: function( data ){ methods.set( $form, data ); }		
		});
		
	});
};

}(jQuery));