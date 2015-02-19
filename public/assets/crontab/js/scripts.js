	
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
				
		$('#addEditCronJobModal .btn-primary').on('click', function(){
			var data = $(this).parents('form').serializeObject();

			if(data.job !== ''){
				self.crontab.jobs[data.job] = data;
			}
			else{
				self.crontab.jobs.push(data);
			}
			delete data.job;
			
			self._saveJobs();
			
		});
		
		$('#crontab-change-email').on('click', function(e){
			e.preventDefault();
			self._saveMail($('[name="email"]').val());
		});
		
		$('#crontab').on('click', '.edit-job', function(e){
			e.preventDefault();
			
			var index = $(this).closest('tr').index();
			if(typeof self.crontab.jobs[index] !== 'undefined'){
				self._editJob(index);
			}
			
		});
		
		$('#crontab').on('click', '.delete-job', function(e) {
			e.preventDefault();
			var index = $(this).closest('tr').index();
			$('#deleteCronJobModal').find('[name="job"]').val(index);			
		});
		
		$('#deleteCronJobModal .btn-primary').on('click', function(e){
			e.preventDefault();
			var data = $(this).parents('form').serializeObject();
			if(typeof self.crontab.jobs[data.job] !== 'undefined'){
				self._deleteJob(data.job);
			}
		});
		
				
	}
	
	this._loadJobs = function() {
		
		var self = this;
		
		$.post(site_url + 'crontab/jobs', function(data){
			
			self.crontab = data;
			
			if(typeof data.mailto !== 'undefined'){
				$('#crontab').find('[name="email"]').val(data.mailto);
			}
			
			$('#cronjobs-table tbody').html('');
			
			if(typeof data.jobs == 'undefined' || data.jobs.length == 0){
				$('#cronjobs-table tbody').append($('#cronjob-empty-row').html());
				self.crontab.jobs = [];
				return;
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
	
	this._saveJobs = function(){
		var self = this;
		$.post(site_url + 'crontab/save', {data: this.crontab}, function(data){
			self._loadJobs();
			$('.modal').modal('hide');
		}, 'json');
	}
	
	this._editJob = function(index){
		
		var job = this.crontab.jobs[index];
				
		$('#addEditCronJobModal').find('[name="job"]').val(index);
		$.each(job, function(key, value){
			$('#addEditCronJobModal').find('[name="' + key + '"]').val(value);
		});
		
	}
	
	this._deleteJob = function(index) {
		this.crontab.jobs.splice(index, 1);
		this._saveJobs();
	}
	
	this._saveMail = function(mailto) {
		this.crontab.mailto = mailto;
		this._saveJobs();
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
