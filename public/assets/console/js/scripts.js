var wd;
var editors = [];

function str_pad(input, length, string) {
    string = string || '0'; input = input + '';
    return input.length >= length ? input : new Array(length - input.length + 1).join(string) + input;
}

	
var command = function(){
		
	this.output_container = '#console-output';
	this.history_dropdown = '#console-commands-history';
	this.command_input = '#console-command';
	this.exec_command_button = '#console-exec-command';
	this.editor_modal = '#console-editor-modal';
	
	this.cmd;
	this.cmd_history = [];
	this.open_files = [];
	this.current_cmd = -1;
	
	this.init = function(){
		
		var self = this;
		
		// read history from storage
		if(typeof(Storage) !== "undefined") {
			this.cmd_history = JSON.parse(localStorage.getItem("cmd_history"));
			if(!this.cmd_history){ this.cmd_history = []; }
			this.open_files = JSON.parse(localStorage.getItem("open_files"));
			if(!this.open_files){ this.open_files = [];	}
		}
		
		// fill history dropdown
		$.each(this.cmd_history, function(index, cmd){
			$(self.history_dropdown).prepend('<li><a href="' + cmd + '" >' + cmd + '</a></li>');
		});
		
		// fill editor popup		
		$.each(this.open_files, function(index, file){
			var cmd = 'cat ' + file;			
			setTimeout(function(){
				self.exec(cmd);
			}, (500*index));
		});
		
		// history dropdown selection		
		$(this.history_dropdown).on('click', 'a', function(e){			
			e.preventDefault();
			$(self.command_input).val($(this).html()).focus();
		});
		
		// command input show history and exec command
		$(this.command_input).on('keydown keyup', function(e){
				
			if(e.type === "keydown" && e.keyCode === 67 && e.ctrlKey === true){
				$(this).val('');
			}			
			else if(e.type === "keydown" && e.keyCode == 9){
				return false;
			}
			else if(e.type === "keyup"){
				if(e.keyCode === 13){
					$(self.exec_command_button).trigger('click');
				}
				else if(e.keyCode === 9){
					self._autocomplete();
				}
				else if(e.keyCode === 38){
					$(this).val(self.historyNext());
				}
				else if(e.keyCode === 40){								
					$(this).val(self.historyPrev());
				}
			}
			
		});
		
		// exec command
		$(this.exec_command_button).on('click', function(){
					
			var cmd = $(self.command_input).val();					
			$(self.command_input).val('');
					
			self.exec(cmd);

		});
		
		// auto scroll output container
		$(this.output_container).on('change', function(){
			$(this).scrollTop(this.scrollHeight);
		});
				
		// edit file from output
		$(this.output_container).on('dblclick', '.file', function(){   
			var cmd = 'edit ' + $(this).parents('p').data('wd') + '/' + $(this).html();
			self.exec(cmd);
		});
		
		// list directory/link from output
		$(this.output_container).on('dblclick', '.dir,.link', function(){	
			if($(this).hasClass('link')){
				var html = $(this).html().split(' -&gt; ');
				var cmd = 'cd "' + html[1] + '";ls -l';
			}
			else{
				var cmd = 'cd ' + $(this).parents('p').data('wd') + '/' + $(this).html() + ';ls -l';
			}
			self.exec(cmd);
		});
				
	}
	
	this.exec = function(cmd){
		
		if(cmd === ""){return;}
		
		this.cmd = cmd;
		
		if(cmd.match(/^edit/)){
			cmd = cmd.replace('edit', 'cat');
		}		
		
		$(this.exec_command_button).attr('disabled', true);
		$(this.command_input).attr('disabled', true).addClass('loading');
		
		var self = this;

		$.ajax({
			url: site_url + 'console/exec',
			type: 'post',
			data: {cmd: cmd}
		})
		.done(function(data){
			self._output(data);
			self._history(self.cmd);
		})
		.always(function () {
			$(self.exec_command_button).attr('disabled', false);
			$(self.command_input).attr('disabled', false).removeClass('loading');
		});
				
	}
	
	this._output = function(data){
		
		wd = getCookie('wd');
		$('#wd').html(wd);
		
		var date = new Date();
		var time = str_pad(date.getHours(), 2, 0) + ':' + str_pad(date.getMinutes(), 2, 0) + ':' + str_pad(date.getSeconds(), 2, 0);
								
		$(this.output_container).append('<div><p>' + time + '</p><p>' + this.cmd + '</p></div>');
		
		if(this.cmd.match(/^edit/)){
			this._fileEditor(data);
		}
		else if(this.cmd.match(/^cat/)){
			this._fileEditor(data, false);
		}
		else if(data !== ""){
			$(this.output_container).append('<div><p>' + time + '</p><p data-wd="' + wd + '" >' + data + '</p></div>');
		}
		
		$(this.output_container).append('<div class="end_command" ><p>' + time + '</p><p>end command</p></div>');

		$(this.output_container).trigger('change');

	}
	
	this._history = function(cmd){
		
		var self = this;				
		$.each(this.cmd_history, function( index, cmd_history ) {
			if(cmd_history == cmd){
				self.cmd_history.splice(index, 1);
				$(self.history_dropdown).find('li a[href="'+cmd+'"]').parent().remove();
			}
		});
		
		this.cmd_history.unshift(cmd);		
		$(this.history_dropdown).append('<li><a href="'+cmd+'" >'+cmd+'</a></li>');
				
		if(typeof(Storage) !== "undefined") {
			localStorage.setItem("cmd_history", JSON.stringify(this.cmd_history));
		}
		
		this.current_cmd = -1;
				
	}
	
	this._getHistory = function(index){
		
		if(this.cmd_history[index]){
			return this.cmd_history[index];
		}
		
		return false;
	}
	
	this.historyNext = function(){
	
		var cmd = this._getHistory(this.current_cmd+1);
		if(cmd !== false){
			this.current_cmd++;
			return cmd;
		}
		
		this.current_cmd = this.cmd_history.length;
		return '';
		
	}
	
	this.historyPrev = function(){	
	
		var cmd = this._getHistory(this.current_cmd-1);
		if(cmd !== false){
			this.current_cmd--;
			return cmd;
		}
		
		this.current_cmd = -1;
		return '';
		
	}
	
	this._fileEditor = function(data, show_editor){
		
		if(typeof show_editor === 'undefined'){ show_editor = true; }
		
		var file = this.cmd.replace(/edit |cat /, '');
		file = file.replace(/"/g, '');
		var filename = file.split('/');
		filename = filename[filename.length-1];
				
		// check if file is already open
		if($(this.editor_modal).find('.modal-body .nav').find('li[data-file="' + file + '"]').length == 0){
			
			var editor_id = 'editor' + $(this.editor_modal).find('.modal-body .tab-content').find('.editor').length;
			
			$(this.editor_modal).find('.modal-body .nav').append('<li data-file="' + file + '" ><a href="#' + editor_id + '" title="' + file + '" role="tab" data-toggle="tab" >' + filename + '<button type="button" class="close" ><span aria-hidden="true">&times;</span></button></a></li>');
			$(this.editor_modal).find('.modal-body .tab-content').append('<div id="' + editor_id + '" class="tab-pane editor" ></div>');
			$(this.editor_modal).find('.modal-body .tab-content #' + editor_id).text(data).html();
	
			var editor = ace.edit(editor_id);
			editor.setTheme('ace/theme/monokai');
			editor.commands.addCommand({
				name: 'save',
				bindKey: {
					win: 'Ctrl-S',
					mac: 'Command-S',
					sender: 'editor|cli'
				},
				exec: function(env, args, request) {
					$('#'+editor_id).parents('.modal').find('.saveFileBtn').trigger('click');
				}
			});
					
			var mode = filename.split('.');
			mode = mode[mode.length-1];
			if(mode === 'js'){ mode = 'javascript'; }                        
			editor.getSession().setMode('ace/mode/'+mode);
			
			editors[editor_id] = editor;

			if($.inArray(file, this.open_files) === -1){
				this.open_files.push(file);
			}
						
			if(typeof(Storage) !== "undefined") {
				localStorage.setItem("open_files", JSON.stringify(this.open_files));
			}

		}
		
		$(this.editor_modal).find('.modal-body .nav li').removeClass('active');
		$(this.editor_modal).find('.modal-body .tab-content .editor').removeClass('active');
		$(this.editor_modal).find('.modal-body .nav').find('li[data-file="' + file + '"] a').trigger('click');
		
		if(show_editor === true){
			$(this.editor_modal).modal('show');
		}
		
		$('#console-opened-files').removeAttr('disabled');
		
	}
	
	this._autocomplete = function(){
		
		var self = this;
		
		var cmd = $(this.command_input).val();
		var cmd_arr = cmd.split(' ').pop().split('/');
		var match = cmd_arr.pop();
		var dir = cmd_arr.join('/');
		
		var re = new RegExp("^" + match + "(.*)$");
		
		if(this.prev_cmd === cmd){
			this.exec('ls' + (dir !== '' ? ' ' + dir : ''));
		}
		else{
			this.prev_cmd = cmd;
			$.post(site_url + 'console/exec', {cmd: 'ls' + (dir !== '' ? ' ' + dir : '')}, function(data){

				var matches = [];

				var items = data.split('\n');
				$.each(items, function(index, item){
					if(item.match(re)){
						matches.push(item);
					}
				});

				if(matches.length === 1){
					$(self.command_input).val(cmd.replace(new RegExp(match + "$"), matches[0]));
				}

			});
		}

	}
	
}
var commandObj = new command();

$(function(){
	
	// automaticaly resize output conteiner
	$(window).on('resize load', function() {
	
		var output_height = $(window).height() - $('.header').height() - $('.modules').height() - 195;		
		$(commandObj.output_container).css('height', output_height);

		$(commandObj.editor_modal).find('.modal-body .tab-content').height($(window).height()-170);

	});
	
	// save file
	$(document).on('click', '.saveFileBtn', function(){
		
		var message = $(commandObj.editor_modal).find('.message');
		var active = $(commandObj.editor_modal).find(' .modal-body .nav .active');	
		
		var file = $(active).data('file');			
		var editor_id = $(active).find('a').attr('href').replace('#', '');
		var data = editors[editor_id].getValue();

		$(message).html('');
		
		$.post(site_url + 'console/savefile', {file: file, data: data}, function(data){

			if(data === 'no-permission'){
				$(message).html('<span class="alert alert-danger" >You do not have permission to write in this file</span>');
			}	
			else if(data > 0){
				$(message).html('<span class="alert alert-success" >File successfully saved!</span>');					
			}
			else{
				$(message).html('<span class="alert alert-danger" >File could not be saved!</span>');						
			}
			
			setTimeout(function(){
				$(message).html('');
			}, 2000);
			
		});
		
	});

	// close file tab
	$(commandObj.editor_modal).find('.nav').on('click', '.close', function(){
		
		var tab = $(this).parents('li');
		var editor_id = $(this).parents('a').attr('href').replace('#', '');
		var file = $(this).parents('a').attr('title');
		
		var was_active = tab.hasClass('active');
		tab.remove();
		
		if(was_active){
			if($(commandObj.editor_modal).find('.nav li').length === 0){
				$(commandObj.editor_modal).modal('hide');
			}
			else{
				$(commandObj.editor_modal).find('.nav a:first').tab('show');
			}
		}
				
		$('#' + editor_id).remove();
		
		// remove from open files
		$.each(commandObj.open_files, function(index, open_file){
			if(open_file === file){
				commandObj.open_files.splice(index, 1);
			}
		});
		
		if(typeof(Storage) !== "undefined") {
			localStorage.setItem("open_files", JSON.stringify(commandObj.open_files));
		}
			
		if($(commandObj.editor_modal).find('.nav li').length === 0){
			$('#console-opened-files').attr('disabled', true);
		}
		
	});
	
	// find console tab and attach object reference to the dom
	$.data($('a[href=#console]').get(0), 'myobj', commandObj);
	
});
