var bcpAdminFormChanged = [];
window.onbeforeunload = function(){
	// If there are at lease one unsaved form - show message for confirnation for page leave
	if(bcpAdminFormChanged.length)
		return 'Some changes were not-saved. Are you sure you want to leave?';
};
jQuery(document).ready(function(){
//	jQuery('#bcpAdminOptionsTabs').tabs({
//             beforeActivate: function( event, ui ) {
//                if(typeof(bcpChangeTab)==typeof(Function)){
//                    return bcpChangeTab(event,ui) 
//                }
//             }
//        }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
        
        
        
    jQuery( "#bcpAdminOptionsTabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	
	jQuery('#bcpAdminOptionsForm').submit(function(){
		jQuery(this).sendFormBcp({
			msgElID: 'bcpAdminMainOptsMsg'
		,	onSuccess: function(res) {
				if(!res.error) {
					changeModeOptionBcp( jQuery('#bcpAdminOptionsForm [name="opt_values[mode]"]').val() );
				}
			}
		});
		return false;
	});
	jQuery('#bcpAdminOptionsSaveMsg').submit(function(){
		return false;
	});
	jQuery('.bcpSetTemplateOptionButton').click(function(){
		toeShowTemplatePopupBcp();
		return false;
	});
	jQuery('.bcpGoToTemplateTabOptionButton').click(function(){
		// Go to tempalte options tab
		var index = jQuery('#bcpAdminOptionsTabs a[href="#bcpTemplateOptions"]').parents('li').index();
		jQuery('#bcpAdminOptionsTabs').tabs('option', 'active', index);
		
		toeShowTemplatePopupBcp();
		return false;
	});
	function toeShowTemplatePopupBcp() {
		var width = jQuery(document).width() * 0.9
		,	height = jQuery(document).height() * 0.9;
		tb_show(toeLangBcp('Preset Templates'), '#TB_inline?width=710&height=520&inlineId=bcpAdminTemplatesSelection', false);
		var popupWidth = jQuery('#TB_ajaxContent').width()
		,	docWidth = jQuery(document).width();
		// Here I tried to fix usual wordpress popup displace to right side
		jQuery('#TB_window').css({'left': Math.round((docWidth - popupWidth)/2)+ 'px', 'margin-left': '0'});
	}
	jQuery('#bcpAdminOptionsForm [name="opt_values[mode]"]').change(function(){
		changeModeOptionBcp( jQuery(this).val(), true );
	});
	changeModeOptionBcp( toeOptionBcp('mode') );
	selectTemplateImageBcp( toeOptionBcp('template') );
	// Remove class is to remove this class from wrapper object
	//jQuery('.bcpAdminTemplateOptRow').not('.bcpAvoidJqueryUiStyle').buttonset().removeClass('ui-buttonset');
	
	jQuery('#bcpAdminTemplateOptionsForm').submit(function(){
		jQuery(this).sendFormBcp({
			msgElID: 'bcpAdminTemplateOptionsMsg'
		});
		return false;
	});
	jQuery('#bcpAdminTemplateOptionsForm [name="opt_values[bg_type]"]').change(function(){
		changeBgTypeOptionBcp();
	});
	changeBgTypeOptionBcp();
	
	 jQuery('.bcpOptTip').live('mouseover',function(event){
        if(!jQuery('#bcpOptDescription').attr('toeFixTip')) {
			var pageY = event.pageY - jQuery(window).scrollTop();
			var pageX = event.pageX;
			var tipMsg = jQuery(this).attr('tip');
			var moveToLeft = jQuery(this).hasClass('toeTipToLeft');	// Move message to left of the tip link
			if(typeof(tipMsg) == 'undefined' || tipMsg == '') {
				tipMsg = jQuery(this).attr('title');
			}
			toeOptShowDescriptionBcp( tipMsg, pageX, pageY, moveToLeft );
			jQuery('#bcpOptDescription').attr('toeFixTip', 1);
		}
        return false;
    });
    jQuery('.bcpOptTip').live('mouseout',function(){
		toeOptTimeoutHideDescriptionBcp();
        return false;
    });
	jQuery('#bcpOptDescription').live('mouseover',function(e){
		jQuery(this).attr('toeFixTip', 1);
		return false;
    });
	jQuery('#bcpOptDescription').live('mouseout',function(e){
		toeOptTimeoutHideDescriptionBcp();
		return false;
    });
	
	jQuery('#bcpColorBgSetDefault').click(function(){
		jQuery.sendFormBcp({
			data: {page: 'options', action: 'setTplDefault', code: 'bg_color', reqType: 'ajax'}
		,	msgElID: 'bcpAdminOptColorDefaultMsg'
		,	onSuccess: function(res) {
				if(!res.error) {
					if(res.data.newOptValue) {
						jQuery('#bcpAdminTemplateOptionsForm [name="opt_values[bg_color]"]')
							.val( res.data.newOptValue )
							.css('background-color', res.data.newOptValue);
					}
				}
				// Trigger event for case if we use this as external event
				jQuery('#bcpColorBgSetDefault').trigger('cpsOptSaved');
			}
		});
		return false;
	});
	jQuery('#bcpImgBgSetDefault').click(function(){
		jQuery.sendFormBcp({
			data: {page: 'options', action: 'setTplDefault', code: 'bg_image', reqType: 'ajax'}
		,	msgElID: 'bcpAdminOptImgBgDefaultMsg'
		,	onSuccess: function(res) {
				if(!res.error) {
					if(res.data.newOptValue) {
						jQuery('#bcpOptBgImgPrev').attr('src', res.data.newOptValue);
					}
				}
				// Trigger event for case if we use this as external event
				jQuery('#bcpImgBgSetDefault').trigger('cpsOptSaved');
			}
		});
		return false;
	});
	jQuery('#bcpImgBgRemove').click(function(){
		if(confirm(toeLangBcp('Are you sure?'))) {
			jQuery.sendFormBcp({
				data: {page: 'options', action: 'removeBgImg', reqType: 'ajax'}
			,	msgElID: 'bcpAdminOptImgBgDefaultMsg'
			,	onSuccess: function(res) {
					if(!res.error) {
						jQuery('#bcpOptBgImgPrev').attr('src', '');
					}
				}
			});
		}
		return false;
	});
	jQuery('#bcpLogoSetDefault').click(function(){
		jQuery.sendFormBcp({
			data: {page: 'options', action: 'setTplDefault', code: 'logo_image', reqType: 'ajax'}
		,	msgElID: 'bcpAdminOptLogoDefaultMsg'
		,	onSuccess: function(res) {
				if(!res.error) {
					if(res.data.newOptValue) {
						jQuery('#bcpOptLogoImgPrev').attr('src', res.data.newOptValue);
					}
				}
				// Trigger event for case if we use this as external event
				jQuery('#bcpLogoSetDefault').trigger('cpsOptSaved');
			}
		});
		return false;
	});
	jQuery('#bcpLogoRemove').click(function(){
		if(confirm(toeLangBcp('Are you sure?'))) {
			jQuery.sendFormBcp({
				data: {page: 'options', action: 'removeLogoImg', reqType: 'ajax'}
			,	msgElID: 'bcpAdminOptLogoDefaultMsg'
			,	onSuccess: function(res) {
					if(!res.error) {
						jQuery('#bcpOptLogoImgPrev').attr('src', '');
					}
				}
			});
		}
		return false;
	});
	jQuery('#bcpMsgTitleSetDefault').click(function(){
		jQuery.sendFormBcp({
			data: {page: 'options', action: 'setTplDefault', code: 'msg_title_params', reqType: 'ajax'}
		,	msgElID: 'bcpAdminOptMsgTitleDefaultMsg'
		,	onSuccess: function(res) {
				if(!res.error) {
					if(res.data.newOptValue) {
						if(res.data.newOptValue.msg_title_color)
							jQuery('#bcpAdminTemplateOptionsForm [name="opt_values[msg_title_color]"]')
								.val( res.data.newOptValue.msg_title_color )
								.css('background-color', res.data.newOptValue.msg_title_color);
						if(res.data.newOptValue.msg_title_font)
							jQuery('#bcpAdminTemplateOptionsForm [name="opt_values[msg_title_font]"]').val(res.data.newOptValue.msg_title_font);
					}
				}
				// Trigger event for case if we use this as external event
				jQuery('#bcpMsgTitleSetDefault').trigger('cpsOptSaved');
			}
		});
		return false;
	});
	jQuery('#bcpMsgTextSetDefault').click(function(){
		jQuery.sendFormBcp({
			data: {page: 'options', action: 'setTplDefault', code: 'msg_text_params', reqType: 'ajax'}
		,	msgElID: 'bcpAdminOptMsgTextDefaultMsg'
		,	onSuccess: function(res) {
				if(!res.error) {
					if(res.data.newOptValue) {
						if(res.data.newOptValue.msg_text_color)
							jQuery('#bcpAdminTemplateOptionsForm [name="opt_values[msg_text_color]"]')
								.val( res.data.newOptValue.msg_text_color )
								.css('background-color', res.data.newOptValue.msg_text_color);
						if(res.data.newOptValue.msg_text_font)
							jQuery('#bcpAdminTemplateOptionsForm [name="opt_values[msg_text_font]"]').val(res.data.newOptValue.msg_text_font);
					}
				}
				// Trigger event for case if we use this as external event
				jQuery('#bcpMsgTextSetDefault').trigger('cpsOptSaved');
			}
		});
		return false;
	});
	// If some changes was made in those forms and they were not saved - show message for confirnation before page reload
	var formsPreventLeave = ['bcpAdminOptionsForm', 'bcpAdminTemplateOptionsForm', 'bcpSubAdminOptsForm', 'bcpAdminSocOptionsForm'];
	jQuery('#'+ formsPreventLeave.join(', #')).find('input,select').change(function(){
		var formId = jQuery(this).parents('form:first').attr('id');
		changeAdminFormBcp(formId);
	});
	jQuery('#'+ formsPreventLeave.join(', #')).find('input[type=text],textarea').keyup(function(){
		var formId = jQuery(this).parents('form:first').attr('id');
		changeAdminFormBcp(formId);
	});
	jQuery('#'+ formsPreventLeave.join(', #')).submit(function(){
		if(bcpAdminFormChanged.length) {
			var id = jQuery(this).attr('id');
			for(var i in bcpAdminFormChanged) {
				if(bcpAdminFormChanged[i] == id) {
					bcpAdminFormChanged.pop(i);
				}
			}
		}
	});
	
	jQuery('.bcpAdminTemplateOptRow').find('.ui-helper-hidden-accessible').css({left: 'auto', top: 'auto'});
	
	jQuery('#toeModActivationPopupFormBcp').submit(function(){
		  jQuery(this).sendFormBcp({
			  msgElID: 'toeModActivationPopupMsgBcp',
			  onSuccess: function(res){
				  if(res && !res.error) {
					  var goto = jQuery('#toeModActivationPopupFormBcp').find('input[name=goto]').val();
					  if(goto && goto != '') {
						toeRedirect(goto);  
					  } else
						toeReload();
				  }
			  }
		  });
		  return false;
	  });
	  
	 jQuery('.toeRemovePlugActivationNoticeBcp').click(function(){
		  jQuery(this).parents('.info_box:first').animateRemove();
		  return false;
	  });
	  if(window.location && window.location.href && window.location.href.indexOf('plugins.php')) {
		  if(BCP_DATA.allCheckRegPlugs && typeof(BCP_DATA.allCheckRegPlugs) == 'object') {
			  for(var plugName in BCP_DATA.allCheckRegPlugs) {
				  var plugRow = jQuery('#'+ plugName.toLowerCase())
				  ,	updateMsgRow = plugRow.next('.plugin-update-tr');
				  if(plugRow.size() && updateMsgRow.find('.update-message').size()) {
					  updateMsgRow.find('.update-message').find('a').each(function(){
						  if(jQuery(this).html() == 'update now') {
							  jQuery(this).click(function(){
								  toeShowModuleActivationPopupBcp( plugName, 'activateUpdate', jQuery(this).attr('href') );
								  return false;
							  });
						  }
					  });
				  }
			  }
		  }
	  }
});
function toeShowModuleActivationPopupBcp(plugName, action, goto) {
	action = action ? action : 'activatePlugin';
	goto = goto ? goto : '';
	jQuery('#toeModActivationPopupFormBcp').find('input[name=plugName]').val(plugName);
	jQuery('#toeModActivationPopupFormBcp').find('input[name=action]').val(action);
	jQuery('#toeModActivationPopupFormBcp').find('input[name=goto]').val(goto);
	
	tb_show(toeLangBcp('Activate plugin'), '#TB_inline?width=710&height=220&inlineId=toeModActivationPopupShellBcp', false);
	var popupWidth = jQuery('#TB_ajaxContent').width()
	,	docWidth = jQuery(document).width();
	// Here I tried to fix usual wordpress popup displace to right side
	jQuery('#TB_window').css({'left': Math.round((docWidth - popupWidth)/2)+ 'px', 'margin-left': '0'});
}
function changeAdminFormBcp(formId) {
	if(jQuery.inArray(formId, bcpAdminFormChanged) == -1)
		bcpAdminFormChanged.push(formId);
}
function changeModeOptionBcp(option, ignoreChangePanelMode) {
	jQuery('.bcpAdminOptionRow-template, .bcpAdminOptionRow-redirect, .bcpAdminOptionRow-sub_notif_end_maint').hide();
	switch(option) {
		case 'coming_soon':
			jQuery('.bcpAdminOptionRow-template').show( BCP_DATA.animationSpeed );
			break;
		case 'redirect':
			jQuery('.bcpAdminOptionRow-redirect').show( BCP_DATA.animationSpeed );
			break;
		case 'disable':
			jQuery('.bcpAdminOptionRow-sub_notif_end_maint').show( BCP_DATA.animationSpeed );
			break;
	}
	if(!ignoreChangePanelMode) {
		// Determine should we show Comin Soon sign in wordpress admin panel or not
		if(option == 'disable' && !jQuery('#wp-admin-bar-comingsoon').hasClass('bcpHidden'))
			jQuery('#wp-admin-bar-comingsoon').addClass('bcpHidden');
		else if(option != 'disable' && jQuery('#wp-admin-bar-comingsoon').hasClass('bcpHidden'))
			jQuery('#wp-admin-bar-comingsoon').removeClass('bcpHidden');
	}
}
function setTemplateOptionBcp(code) {
	jQuery('.bcpTemplatesList .bcpTemplatePrevShell-'+ code).css('opacity', 0.5);
	jQuery.sendFormBcp({
		data: {page: 'options', action: 'save', opt_values: {template: code}, code: 'template', reqType: 'ajax'}
	,	onSuccess: function(res) {
			jQuery('.bcpTemplatesList .bcpTemplatePrevShell-'+ code).css('opacity', 1);
			if(!res.error) {
				selectTemplateImageBcp(code);
				if(res.data && res.data.new_name) {
					jQuery('.bcpAdminTemplateSelectedName').html(res.data.new_name);
				}
				if(res.data.def_options && !getCookieBcp('bcp_hide_set_defs_tpl_popup')) {
					askToSetTplDefaults(res.data.def_options);
				}
				
				// This is for style_editor module, it come with pro version.
				// I know that it's better to create events functionality, but unfortunately - I hove no time for this right now.
				if(typeof(toeGetTemplateStyleContentBcp) == 'function') {
					toeGetTemplateStyleContentBcp();
				}
			}
		}
	})
	return false;
}
function toeShowDialogCustomized(element, options) {
	options = jQuery.extend({
		resizable: false
	,	width: 500
	,	height: 300
	,	closeOnEscape: true
	,	open: function(event, ui) {
			jQuery('.ui-dialog-titlebar').css({
				'background-color': '#222222'
			,	'background-image': 'none'
			,	'border': 'none'
			,	'margin': '0'
			,	'padding': '0'
			,	'border-radius': '0'
			,	'color': '#CFCFCF'
			,	'height': '27px'
			});
			jQuery('.ui-dialog-titlebar-close').css({
				'background': 'url("../wp-includes/js/thickbox/tb-close.png") no-repeat scroll 0 0 transparent'
			,	'border': '0'
			,	'width': '15px'
			,	'height': '15px'
			,	'padding': '0'
			,	'border-radius': '0'
			,	'margin': '-7px 0 0'
			}).html('');
			jQuery('.ui-dialog').css({
				'border-radius': '3px'
			,	'background-color': '#FFFFFF'
			,	'background-image': 'none'
			,	'padding': '1px'
			,	'z-index': '300000'
			});
			jQuery('.ui-dialog-buttonpane').css({
				'background-color': '#FFFFFF'
			});
			jQuery('.ui-dialog-title').css({
				'color': '#CFCFCF'
			,	'font': '12px sans-serif'
			,	'padding': '6px 10px 0'
			});
			if(options.openCallback && typeof(options.openCallback) == 'function') {
				options.openCallback(event, ui);
			}
		}
	}, options);
	return jQuery(element).dialog(options);
}
function askToSetTplDefaults(def_options) {
	var startHtml = jQuery('#bcpAskDefaultModParams').html();
	toeShowDialogCustomized('#bcpAskDefaultModParams', {
		openCallback: function() {
			jQuery('.bcpTplDefOptionCheckShell').hide().each(function(){
				if(jQuery(this).find('input[type=checkbox]').size()) {
					var data_values = jQuery(this).find('input[type=checkbox]').val().split(',')
					,	showThisOption = false;
					for(var key in def_options) {
						for(var i in data_values) {
							if(data_values[i] == key) {
								showThisOption = true;
								break;
							}
						}
						if(showThisOption)
							break;
					}
					if(showThisOption) {
						var optName = jQuery(this).find('input[type=checkbox]').attr('name');
						if((optName == 'background_color' && (def_options.bg_type == 'color' || def_options.bg_type == 'color_image'))
							|| (optName == 'background_image' && (def_options.bg_type == 'image' || def_options.bg_type == 'color_image'))
							|| (optName != 'background_color' && optName != 'background_image')
						) {
							jQuery(this).show();
						}
					}
				}
			});
			jQuery('.bcpDefTplOptCheckbox').find('input[type=checkbox]').unbind('click').bind('click', function(){
				var parentLoaderElement = jQuery(this).parent('.bcpDefTplOptCheckbox:first')
				,	sendElement = null;
				parentLoaderElement.showLoaderBcp();
				var afterSaveAction = function() {
					if(sendElement) {
						parentLoaderElement.html( '<img src="'+ BCP_DATA.ok_icon+ '" />' );
						sendElement.unbind('cpsOptSaved', afterSaveAction);
					}
				};
				var customSuccess = false;
				switch(jQuery(this).attr('name')) {
					case 'background_color':
						sendElement = jQuery('#bcpColorBgSetDefault');
						break;
					case 'background_image':
						sendElement = jQuery('#bcpImgBgSetDefault');
						break;
					case 'logo':
						sendElement = jQuery('#bcpLogoSetDefault');
						break;
					case 'fonts':
						sendElement = jQuery('#bcpMsgTitleSetDefault, #bcpMsgTextSetDefault');
						break;
					case 'slider_images':
						customSuccess = function(data) {
							toeOptSlidesRedraw(data.slides, data.slidesNames);
						};
					default:
						jQuery.sendFormBcp({
							msgElID: parentLoaderElement
						,	data: {page: 'options', action: 'setTplDefault', reqType: 'ajax', code: jQuery(this).val().split(',')}
						,	onSuccess: function(res) {
								if(!res.error) {
									parentLoaderElement.html( '<img src="'+ BCP_DATA.ok_icon+ '" />' );
								}
								if(customSuccess && typeof(customSuccess) == 'function') {
									customSuccess(res.data);
								}
							}
						});
						break;
				}
				if(sendElement) {
					sendElement
						.unbind('cpsOptSaved', afterSaveAction)
						.bind('cpsOptSaved', afterSaveAction)
						.trigger('click');
				}
			});
		}
	,	buttons: {
			'Don\'t show this message again': function() {
				setCookieBcp('bcp_hide_set_defs_tpl_popup', true, 300);
				jQuery(this).dialog('close');
			}
		,	Close: function() {
				jQuery(this).dialog('close');
			}
		}
	,	close: function( event, ui ) {
			jQuery('#bcpAskDefaultModParams').html( startHtml );
		}
	});
}
function selectTemplateImageBcp(code) {
	jQuery('.bcpTemplatesList .bcpTemplatePrevShell-existing .button')
			.val(toeLangBcp('Apply'))
			.removeClass('bcpTplSelected');
	//jQuery('.bcpAdminTemplateShell').removeClass('bcpAdminTemplateShellSelected');
	if(code) {
		jQuery('.bcpTemplatesList .bcpTemplatePrevShell-'+ code+ ' .button')
			.val(toeLangBcp('Selected'))
			.addClass('bcpTplSelected');
		//jQuery('.bcpAdminTemplateShell-'+ code).addClass('bcpAdminTemplateShellSelected');
	}
}
function changeBgTypeOptionBcp() {
	jQuery('#bcpBgTypeStandart-selection, #bcpBgTypeColor-selection, #bcpBgTypeImage-selection').hide();
	if(jQuery('#bcpAdminTemplateOptionsForm [name="opt_values[bg_type]"]:checked').size())
		jQuery('#'+ jQuery('#bcpAdminTemplateOptionsForm [name="opt_values[bg_type]"]:checked').attr('id')+ '-selection').show( BCP_DATA.animationSpeed );
}
/* Background image manipulation functions */
function toeOptImgCompleteSubmitNewFile(file, res) {
    toeProcessAjaxResponseBcp(res, 'bcpOptImgkMsg');
    if(!res.error) {
        toeOptImgSetImg(res.data.imgPath);
    }
}
function toeOptImgOnSubmitNewFile() {
    jQuery('#bcpOptImgkMsg').showLoaderBcp();
}
function toeOptImgSetImg(src) {
	jQuery('#bcpOptBgImgPrev').attr('src', src);
}
/* Logo image manipulation functions */
function toeOptLogoImgCompleteSubmitNewFile(file, res) {
    toeProcessAjaxResponseBcp(res, 'bcpOptLogoImgkMsg');
    if(!res.error) {
        toeOptLogoImgSetImg(res.data.imgPath);
    }
}
function toeOptLogoImgOnSubmitNewFile() {
    jQuery('#bcpOptLogoImgkMsg').showLoaderBcp();
}
function toeOptLogoImgSetImg(src) {
	jQuery('#bcpOptLogoImgPrev').attr('src', src);
}
