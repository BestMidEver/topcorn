MyApp.controller('AccountInterfacePageController', function($scope, $http, rate)
{
	$scope.lang=pass.lang;
	$scope.secondary_lang=pass.secondary_lang;
	$scope.hover_title_language=pass.hover_title_language;
	$scope.image_quality=pass.image_quality;
	$scope.margin_x_setting=pass.margin_x_setting;
	$scope.theme=pass.theme;
	$scope.pagination=pass.pagination;
	$scope.open_new_tab=pass.open_new_tab;
	$scope.show_crew=pass.show_crew;
	$scope.advanced_filter=pass.advanced_filter;
	$scope.is_save_disabled = true;

	$scope.check_save_disabled = function(){
		console.log($scope.lang)
		if(
			(pass.lang != $scope.lang
			|| pass.secondary_lang != $scope.secondary_lang
			|| pass.hover_title_language != $scope.hover_title_language
			|| pass.image_quality != $scope.image_quality
			|| pass.margin_x_setting != $scope.margin_x_setting
			|| pass.theme != $scope.theme
			|| pass.pagination != $scope.pagination
			|| pass.show_crew != $scope.show_crew
			|| pass.advanced_filter != $scope.advanced_filter
			|| pass.open_new_tab != $scope.open_new_tab)
		){
			$scope.is_save_disabled = false;
		}else{
			$scope.is_save_disabled = true;
		}
	}
	window.onbeforeunload = function() {
		if(!$scope.is_save_disabled) return ""; //eğer değişiklik yapılmadıysa sayfayı değiştirebilsin.
	}

	$('#the_form').submit(function() {
		window.onbeforeunload = null;
		return true;
	});



//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// QUICK RATE /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.quickvote=function()
	{
		$scope.get_quick_rate();
		$('#myModal').modal('show');
	};

	$scope.get_quick_rate=function()
	{
		rate.get_quick_rate(pass.lang)
		.then(function(response){
			console.log(response.data)
			if(response.data.length>0){
				$scope.modalmovies=response.data;
				$scope.next_quick_rate();
				$("body").tooltip({ selector: '[data-toggle=tooltip]' });
			}else{
				$('#myModal').modal('hide');
			}
		});
	};

	$scope.next_quick_rate=function()
	{
		if($scope.modalmovies.length>0){
			$scope.modalmovie = $scope.modalmovies[0];
			$scope.modalmovie.is_quick_rate=true;
		}else{
			$scope.get_quick_rate();
		}
	};

	$scope.previous_quick_rate_movie=null;
	$scope.previous_quick_rate=function()
	{
		$scope.modalmovies.unshift($scope.previous_quick_rate_movie);
		$scope.modalmovie = $scope.previous_quick_rate_movie;
		$scope.previous_quick_rate_movie=null;
	};

	$scope.quick_later=function()
	{
		if($scope.modalmovie.later_id == null){
			rate.add_later($scope.modalmovie.id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.modalmovie.later_id=response.data.data.later_id;
					$scope.modify_movies($scope.modalmovie);
				}
			});
		}else{
			rate.un_later($scope.modalmovie.later_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope.modalmovie.later_id=null;
					$scope.modify_movies($scope.modalmovie);
				}
			});
		}
	};

	$scope.quick_rate=function(rate_code)
	{
		console.log(rate_code)
		if(rate_code != null){
			rate.add_rate($scope.modalmovie.id, rate_code)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.modalmovie.rated_id=response.data.data.rated_id;
					$scope.modalmovie.rate_code=response.data.data.rate;
					$scope.previous_quick_rate_movie=$scope.modalmovies.shift();
					$(".tooltip").hide();
					$scope.modify_movies($scope.previous_quick_rate_movie);
					$scope.next_quick_rate();
					if(pass.tt_navbar < 100) $scope.get_watched_movie_number();
				}
			});
		}else if(rate_code == null){
			rate.un_rate($scope.modalmovie.rated_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope.modalmovie.rated_id=null;
					$scope.modalmovie.rate_code=null;
					$scope.previous_quick_rate_movie=$scope.modalmovies.shift();
					$(".tooltip").hide();
					$scope.modify_movies($scope.previous_quick_rate_movie);
					$scope.next_quick_rate();
					if(pass.tt_navbar < 100) $scope.get_watched_movie_number();
				}
			});
		}
	};

	$scope.quick_ban=function()
	{
		if($scope.modalmovie.ban_id == null){
			rate.add_ban($scope.modalmovie.id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.modalmovie.ban_id=response.data.data.ban_id;
					$scope.modify_movies($scope.modalmovie);
				}
			});
		}else{
			rate.un_ban($scope.modalmovie.ban_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope.modalmovie.ban_id=null;
					$scope.modify_movies($scope.modalmovie);
				}
			});
		}
	};

	$scope.modify_movies=function(movie){
		if(_.where($scope.movies, {id:movie.id}).length>0){
			temp=_.where($scope.movies, {id:movie.id})[0];
			temp.ban_id=movie.ban_id;
			temp.later_id=movie.later_id;
			temp.rated_id=movie.rated_id;
			temp.rate_code=movie.rate_code;
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// QUICK RATE /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// TUTORIAL ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.watched_movie_number = pass.watched_movie_number;

	if(pass.tt_navbar < 100 || pass.tt_movie < 50){
		if(pass.tt_navbar<50){
			if(pass.tt_navbar==0)location.hash="tooltip-navbar-quickvote";
			else if(pass.tt_navbar==1)location.hash="tooltip-navbar-search";
			else if(pass.tt_navbar==2)location.hash="tooltip-navbar-recommendations";
			else if(pass.tt_navbar==3)location.hash="tooltip-navbar-profile";
			else if(pass.tt_navbar==4)location.hash="tooltip-navbar-percentage";
		}else if(location.href.indexOf('topcorn.io/movie/')>-1){
			if(pass.tt_movie<50){
				if(pass.tt_movie==0)location.hash="tooltip-movie-share";
				else if(pass.tt_movie==1)location.hash="tooltip-movie-search";
				else if(pass.tt_movie==2)location.hash="tooltip-movie-cast";
				else if(pass.tt_movie==3)location.hash="tooltip-movie-review";
			}
		}else if(pass.tt_navbar<100){
			if(pass.watched_movie_number>49)location.hash="tooltip-footer-like";
			else if(pass.watched_movie_number>199)location.hash="tooltip-footer-donate";
		}

		window.addEventListener("hashchange", function(){ 
			console.log(location.hash)
			if(location.hash.indexOf('tooltip-navbar-quickvote')>-1){
				$("[data-toggle=popover]").popover('hide');
				$('#quickvote').popover('show');
			}else if(location.hash.indexOf('tooltip-navbar-search')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 1)
				.then(function(response){
					console.log(response);
					$('#search').popover('show');
				});
			}else if(location.hash.indexOf('tooltip-navbar-recommendations')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 2)
				.then(function(response){
					console.log(response);
					$('#recommendations').popover('show');
				});
			}else if(location.hash.indexOf('tooltip-navbar-profile')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 3)
				.then(function(response){
					console.log(response);
					$('#profile').popover('show');
				});
			}else if(location.hash.indexOf('tooltip-navbar-percentage')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 4)
				.then(function(response){
					console.log(response);
					if(pass.watched_movie_number<50) $('#percentage').popover('show');
					else location.hash="#navbar-tooltips-done";
				});
			}else if(location.hash.indexOf('navbar-tooltips-done')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 50)
				.then(function(response){
					if(location.href.indexOf('topcorn.io/movie')>-1) location.hash='#tooltip-movie-share';
				});
			}else if(location.hash.indexOf('tooltip-footer-like')>-1){
				$("[data-toggle=popover]").popover('hide');
				setTimeout(function() {
					$('#like').popover('show');
				}, 2500);
			}else if(location.hash.indexOf('tooltip-footer-donate')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 70)
				.then(function(response){
					setTimeout(function() {
						$('#donate').popover('show');
					}, 2500);
				});
			}else if(location.hash.indexOf('navbar-tooltips-all-done')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 100)
				.then(function(response){
					console.log(response);
				});
			}else if(location.hash.indexOf('cancel-tooltips')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 50)
				.then(function(response){
					console.log(response);
				});
				///////////////////MOVIE///////////////////////
			}else if(location.hash.indexOf('tooltip-movie-share')>-1){
				$("[data-toggle=popover]").popover('hide');
				setTimeout(function() {
					$('#share').popover('show');
				}, 2500);
			}else if(location.hash.indexOf('tooltip-movie-search')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('movie', 1)
				.then(function(response){
					setTimeout(function() {
						$('#google').popover('show');
					}, 2500);
				});
			}else if(location.hash.indexOf('tooltip-movie-cast')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('movie', 2)
				.then(function(response){
					setTimeout(function() {
						$('#cast').popover('show');
					}, 2500);
				});
			}else if(location.hash.indexOf('tooltip-movie-review')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('movie', 3)
				.then(function(response){
					setTimeout(function() {
						$('#review').popover('show');
					}, 2500);
				});
			}else if(location.hash.indexOf('movie-tooltips-done')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('movie', 50)
				.then(function(response){
					console.log(response);
				});
			}else if(location.hash.indexOf('cancel-movie-tooltips')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('movie', 60)
				.then(function(response){
					console.log(response);
				});
				///////////////////MOVIE///////////////////////
			}else if(location.hash.indexOf('close-tooltip')>-1){
				$("[data-toggle=popover]").popover('hide');
			}
		}, false);
	}

	if(pass.tt_navbar < 100){
		console.log(pass)
		$scope.get_watched_movie_number = function(){
			rate.get_watched_movie_number()
			.then(function(response){
				console.log(response);
				$scope.watched_movie_number=response.data;
				if($scope.watched_movie_number<50) $scope.calculate_percentage();
				$scope.cry_for_help();
			});
		}

		$scope.cry_for_help = function(){
			if($scope.watched_movie_number>49 && pass.tt_navbar < 70) location.hash="tooltip-footer-like";
			else if($scope.watched_movie_number>199 && pass.tt_navbar < 100) location.hash="tooltip-footer-donate";
		}
		if(pass.tt_navbar>49)$scope.cry_for_help();

		$scope.calculate_percentage = function(){
			$scope.percentage = pass.lang=='tr' ? '%'+$scope.watched_movie_number*2 : $scope.watched_movie_number*2+'%';
		}
		$scope.calculate_percentage();
	}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// TUTORIAL ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
});