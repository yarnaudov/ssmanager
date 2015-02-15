var repo;

var git = function(){
	
	this.repo;
	
	this.repositories_container = '#repositories';
	this.details_container = '#repository-details';
	this.log_container = '#git-revision-log';
	
	this.init = function(){
		
		var self = this;
				
		// load git projects
		this.loadRepositories();
		
		$(this.details_container).html('').removeClass('loading');
		
		// load project details
		$(this.repositories_container).on('click', 'a',  function(e){
			$(self.repositories_container).find('a').removeClass('list-group-item-info');
			$(this).addClass('list-group-item-info');
			self.repo = $(this).data('repo');
			self.loadRepositoryDetails();
		});	
		
		// pull from remote branch
		$(this.details_container).on('click', '#pull-branch', function(){							
			var branch = $(this).prev().val();
			self.pull(branch);		
		});
		
		// switch to branch
		$(this.details_container).on('click', '#switch-branch', function(){					
			var branch = $(this).prev().val();
			self.switch(branch);
		
		});
	
		// fetch remote branches
		$(this.details_container).on('click', '#fetch-branches', function(){			
			self.fetch(this);			
		});
		
		// show commit details
		$(this.details_container).on('click', '.commit-details', function(e){
			e.preventDefault();	
			var commit = $(this).html();		
			self.loadCommitDetails(commit);				
		});
		
		// create new repository
		$('a[data-target="#create-new-repo-modal"]').on('click', function(){			
			self.create();
		});
	}
	
	this.create = function(){
				
		var self = this;
		
		$('#create-new-repo-modal .form').show();
		$('#create-new-repo-modal .message').hide();
		
		$('#create-new-repo-modal').find('.btn-create-repo').on('click', function(){
			
			var url = $('#url').val();
			var name = $('#name').prev().html() + $('#name').val();
			
			$('#create-new-repo-modal .modal-body').addClass('loading')
					.find('.form').hide()
					.parent()
					.find('.message').hide();
			
			$.post(PHP_SELF + 'index.php?module=git&action=create', {url: url, name: name}, function(data){
				
				$('#create-new-repo-modal .modal-body').removeClass('loading').find('.message').html(data).show();			
				self.loadProjects();
				
			});
			
		});
		
	}
	
	this.pull = function(branch){
		
		var self = this;
		
		$('#pull-branch-modal').find('.pull-branch').html(branch);
		$('#pull-branch-modal').find('.active-branch').html($('#active-branch').html());
										
		$('#pull-branch-modal .text').show();
		$('#pull-branch-modal .message').hide();
		$('#pull-branch-modal').modal({show: true});
		
		$('#pull-branch-modal').find('.btn-pull').off('click').on('click', function(){
			
			$('#pull-branch-modal .modal-body').addClass('loading')
				.find('.text').hide()
				.parent()
				.find('.message').hide();
			
			$.post(site_url + 'git/pull', {repo: self.repo, branch: branch}, function(data){
				$('#pull-branch-modal .modal-body').removeClass('loading').find('.message').html(data).show();
			});
		
		});
		
	}
	
	this.switch = function(branch){
		
		var self = this;
		
		$('#switch-branch-modal').find('.switch-branch').html(branch);
		$('#switch-branch-modal').find('.active-branch').html($('#active-branch').html());
										
		$('#switch-branch-modal .text').show();
		$('#switch-branch-modal .message').hide();
		$('#switch-branch-modal').modal({show: true});
		
		$('#switch-branch-modal').find('.btn-switch').off('click').on('click', function(){
			
			$('#switch-branch-modal .modal-body').addClass('loading')
				.find('.text').hide()
				.parent()
				.find('.message').hide();
			
			$.post(site_url + 'git/switch', {repo: self.repo, branch: branch}, function(data){
				$('#switch-branch-modal .modal-body').removeClass('loading').find('.message').html(data).show();
				self.loadProjectDetails();
			});
		
		});
		
	}
	
	this.fetch = function(btn){
		
		var self = this;
		
		$(btn).button('loading');
		
		$.post(site_url + 'git/fetch', {repo: this.repo}, function(data){
			$(btn).button('reset');
			$(this.repositories_container).find('a[data-repo="' + self.repo + '"]').trigger('click');
		});
		
	}
	
	this.loadRepositories = function(){
	
		var self = this;
		$(this.repositories_container).addClass('loading');
		
		$.get(site_url + 'git/repositories', function(data){	
			$.each(data, function(index, project) {
				$(self.repositories_container).prepend('<a href="#" class="list-group-item" data-repo="' + project[0] + '" >' + project[1] + '</a>');
			});
			$(self.repositories_container).removeClass('loading');
			
		}, 'json');
		
	}
	
	this.loadRepositoryDetails = function(){
			
		var self = this;
			
		$(this.details_container).html('').addClass('loading');
		
		$.post(site_url + 'git/repository_details', {repo: this.repo}, function(data){

			$(self.repositories_container).removeAttr('disabled');		
			$(self.details_container).removeClass('loading');
			
			$(self.details_container).html(data);
			$(window).trigger('load');
		
		});
			
	}
	
	this.loadCommitDetails = function(commit){
		
		$('#commit-details-modal').modal({show: true});

		$('#commit-details-modal .modal-body').html('');
		
		$.post(site_url + 'git/showCommit', {repo: this.repo, commit: commit}, function(data){
			$('#commit-details-modal .modal-body').removeClass('loading').html(data);
		});
		
	}
	
}
var gitObj = new git();

$(function(){
		
	// automaticaly resize details conteiner
	$(window).on('resize load', function() {
	
		$(gitObj.repositories_container).css('max-height', $(window).height() - 280);
	
		var output_height = $(window).height() - $('header').height() - 124;		
		$(gitObj.details_container).css('height', output_height);
		
		$(gitObj.log_container).css('height', $(gitObj.details_container).height() - $(gitObj.details_container).find('.info').height() - 35);
		
	});
	
	// find console tab and attach object reference to the dom
	$.data($('a[href=#git]').get(0), 'myobj', gitObj);
	
});