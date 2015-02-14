var App = function(){
	
	this.init = function(){
		
		var self = this;
		
		// make test ajax call to check user login
		$.get(site_url);
		
		// reset all modals forms on close
		$('.modal').on('hide.bs.modal', function(e){
		
			var form = $(e.currentTarget).find('form');
			if(form.length === 1){
				form[0].reset();
				self._clearErrors(form);
			}

		});
		
		$('.modal').on('shown.bs.modal', function(e){
			$(e.currentTarget).find('input').first().focus();
		});
		
		$('.modal form input').on('keypress', function(e){
			if((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)){
				$(this).parents('form').first().find('.btn-primary').trigger('click');
			}
		});
		
		$('#log-in-modal').find('.btn-primary').click(function(){
			self.login($(this).parents('form'));
		});
		
		$('.add-user').click(function(e){
			e.preventDefault();	
			$('#add-user-modal').modal('show');
		});
		
		$('.edit-user').click(function(e){
			e.preventDefault();
			
			$.get(site_url + 'main/user/' + $(this).data('username'), function(data){
				$('#edit-user-modal').modal('show');
				$('#edit-user-modal').find('.user-form').replaceWith(data);
			});
			
		});
		
		$('#add-user-modal, #edit-user-modal').find('.cancel').click(function(){
			$('#manage-users-modal').modal('show');
		});
		
		$('#change-password-modal').find('.btn-primary').click(function(){
			self.changePassword($(this).parents('form'));
		});
		
		$('#add-user-modal, #edit-user-modal').find('.btn-primary').click(function(){
			self.saveUser($(this).parents('form'));
		});
		
	}
	
	this.login = function(form){
		
		var self = this;
		
		$.post(form.attr('action'), form.serializeObject(), function(data){
			if(typeof data.errors !== 'undefined'){
				self._showErrors(form, data.errors);
			}
			else{
				$('#username').html(data.user.username);
				$('#log-in-modal').modal('hide');
				var myObj = $.data($('.nav.modules .active a').get(0), 'myobj');
				myObj.init();
			}
		}, 'json');
		
	}
	
	this.changePassword = function(form){
		
		var self = this;
		
		$.post(form.attr('action'), form.serializeObject(), function(data){
			if(typeof data.errors !== 'undefined'){
				self._showErrors(form, data.errors);
			}
			else{
				$('#change-password-modal').modal('hide');
				if(typeof data.message !== 'undefined'){
					self._showMessage(data.message);
				}
			}
		}, 'json');
		
	}
	
	this.saveUser = function(form){
		
		var self = this;
		
		$.post(form.attr('action'), form.serializeObject(), function(data){
			if(typeof data.errors !== 'undefined'){
				self._showErrors(form, data.errors);
			}
			else{
				$('#add-user-modal, #edit-user-modal').find('.cancel').trigger('click');
			}
		}, 'json');
		
	}
	
	this._showErrors = function(container, errors){
		
		this._clearErrors(container);
		
		$.each(errors, function(field, error){
			if($(container).find('input[name="' + field + '"]').length === 0){
				$(container).find('.message').append(
						'<div class="alert alert-danger alert-dismissible fade in" role="alert">'+
							'<button class="close" data-dismiss="alert" type="button">'+
								'<span aria-hidden="true">×</span>'+
								'<span class="sr-only">Close</span>'+
							'</button>'+
							error +
						'</div>');
			}
			else{
				$(container).find('input[name="' + field + '"]').parents('.form-group').addClass('has-error');
				$(container).find('input[name="' + field + '"]').after('<p class="text-danger">' + error + '</p>');
			}
		});
		
	}
	
	this._clearErrors = function(container){
		$(container).find('.message').html('');
		$(container).find('.form-group').removeClass('has-error').find('.text-danger').remove();
	}
	
	this._showMessage = function(message){
		$('#message-modal').find('.modal-body').html(message);
		$('#message-modal').modal('show');
	}
	
}
var AppObj = new App;

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function getCookie(c_name){

	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");
	if (c_start == -1){
		c_start = c_value.indexOf(c_name + "=");
	}
	if (c_start == -1){
		c_value = null;
	}
	else{
		c_start = c_value.indexOf("=", c_start) + 1;
		var c_end = c_value.indexOf(";", c_start);
		if (c_end == -1){
			c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start,c_end));
	}
	return c_value;
	
}

$(function(){
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		try{
			var myObj = $.data($(e.target).get(0), 'myobj'); 
			if(myObj.inited !== true){
				myObj.init();
				myObj.inited = true;
			}
		}
		catch(e){}
	});
	setTimeout(function(){
		$('a[data-toggle="tab"]').first().tab('show');
	}, 50);
	
	window.language = $('html').attr('lang');
	window.base_url = $('base').attr('href');
	window.site_url = window.base_url + window.language + '/';
	
	$(document).ajaxError(function(evt, xhr, settings) {
		if(xhr.status === 401){
			$('#log-in-modal').modal();
		}
	});
	
	AppObj.init();
	
});