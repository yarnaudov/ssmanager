	
var crontab = function(){
	
	this.crontab = {}
	
	this.init = function(){
		
		var self = this;
		
		self._loadJobs();
		
		$('#crontab .options').on('change', function(){
			
			var type = $(this).data('type');
						
			if(type == 'common'){
				var settings = $(this).val().split(' ');
				$('#crontab [name="min"]').val(settings[0]);
				$('#crontab [name="hour"]').val(settings[1]);
				$('#crontab [name="day"]').val(settings[2]);
				$('#crontab [name="month"]').val(settings[3]);
				$('#crontab [name="weekday"]').val(settings[4]);
			}
			else{
				$('#crontab [name="' + type + '"]').val($(this).val());
			}
			
		});
				
		$('#addCronJobModal .btn-primary').on('click', function(){
			var data = $(this).parents('form').serializeObject();
			self._saveJob(data);
		});
		
		$('#crontab-change-email').on('click', function(e){
			e.preventDefault();
			self._saveMail($('[name="email"]').val());
		});
		
				
	}
	
	this._loadJobs = function() {
		
		var self = this;
		
		$.post(site_url + 'crontab/jobs', function(data){
			console.log(data);
			self.crontab = data;
			
			if(data.length == 0){
				$('#cronjobs-table tbody').append($('#cronjob-empty-row').html());
				return;
			}
			
			if(typeof data.mailto !== 'undefined'){
				$('#crontab').find('[name="email"]').val(data.mailto);
			}
			
			$.each(data.jobs, function(i, job){
				var jobHtml = $('#cronjob-row').html();		
				jobHtml = jobHtml.replace('{{numb}}', $('#cronjobs-table tbody tr').length + 1);
				$.each(job, function(key, value){
					jobHtml = jobHtml.replace('{{' + key + '}}', value);
				});				
				$('#cronjobs-table tbody').append(jobHtml);
			});
			
		}, 'json');
		
	}
		
	this._saveJob = function(data) {
		
		this.crontab.jobs.push(data);
		
		$.post(site_url + 'crontab/save', {data: this.crontab}, function(data){
			
			console.log(data);
			
		}, 'json');
		
	}
	
	this._saveMail = function(mailto) {
		
		this.crontab.mailto = mailto;
		
		$.post(site_url + 'crontab/save', {data: this.crontab}, function(data){
			
			console.log(data);
			
		}, 'json');
		
	}
		
}
var crontabObj = new crontab();

$(function(){
	
	// automaticaly resize output conteiner
	$(window).on('resize load', function() {
	
		var output_height = $(window).height() - $('.header').height() - $('.modules').height() - 225;		
		//$(databaseObj.output_container).css('height', output_height);

		//$(databaseObj.editor_modal).find('.modal-body .tab-content').height($(window).height()-170);

	});
	
	// find console tab and attach object reference to the dom
	$.data($('a[href=#crontab]').get(0), 'myobj', crontabObj);
	
});
