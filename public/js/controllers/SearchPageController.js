MyApp.controller('SearchPageController', function($scope, $http, $anchorScroll, rate, external_internal_data_merger)
{
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// SCROLL TO TOP ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.scroll_to_top=function(){
		$anchorScroll.yOffset = 55;
		$anchorScroll('scroll_top_point')
	}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// SCROLL TO TOP ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// RETRIEVE MOVIECARD DATA //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.image_url_prefix_movie_card = pass.image_url_prefix_movie_card;
	$scope.constants_image_thumb_nail = pass.constants_image_thumb_nail;
	$scope.user_id = pass.user_id;
	$scope.active_tab='movie';
	$scope.page=1;
	$scope.is_waiting=false;

	rate.get_user_movies('movies')
	.then(function(response){
		console.log(response.data);
		$scope.user_movies = response.data;
	});
	rate.get_user_movies('series')
	.then(function(response){
		console.log(response.data);
		$scope.user_series = response.data;
	});

	$scope.reset_tab = function()
	{
		$scope.fetchHistory();
		$scope.page=null;
		$scope.pagination=null;
		$scope.current_page=null;
		$scope.movies=null;
		$scope.people=null;
		$scope.users=null
		$scope.listes=null
		$(".tooltip").hide();
	}

	$scope.fetchHistory = function()
	{
		console.log(11111111)
		rate.fetch_history()
		.then(function(response){
			console.log(2222222, response)
		})
	}

	$scope.generalinput='';
	$scope.get_page_data = function()
	{
		console.log('-----------')
		var temp=$scope.generalinput.replace(/ /g , "%20");
		if(temp.length == 0){
			console.log(0000000000)
			$scope.reset_tab();
		}else{
    		$scope.is_waiting=true;
			switch($scope.active_tab) {
				case 'movie':
				case 'series':
					rate.search_movies(pass.constants_api_key, pass.lang, temp, $scope.page, $scope.active_tab)
					.then(function(response){
						console.log(12, $scope.active_tab,response.data);
						$scope.inside_get_page_data_movie(response);
					});
					break;
				case 'person':
					rate.search_people(pass.constants_api_key, pass.lang, temp, $scope.page)
					.then(function(response){
						console.log(response.data);
						$scope.inside_get_page_data_person(response);
					});
					break;
				case 'user':
					rate.search_users(temp, $scope.page)
					.then(function(response){
						console.log(response.data);
						$scope.users=response.data.data;
						$scope.pagination=response.data.last_page;
						$scope.current_page=response.data.current_page;
						$scope.from=response.data.from;
						$scope.to=response.data.to;
						$scope.in=response.data.total;
						$(".tooltip").hide();
						$scope.is_waiting=false;
					});
					break;
				case 'list':
					rate.search_listes(temp, $scope.page)
					.then(function(response){
						console.log(response.data);
						$scope.listes=response.data.data;
						$scope.pagination=response.data.last_page;
						$scope.current_page=response.data.current_page;
						$scope.from=response.data.from;
						$scope.to=response.data.to;
						$scope.in=response.data.total;
						$(".tooltip").hide();
						$scope.is_waiting=false;
					});
					break;
				default:
			}
			$(".tooltip").hide();
		}
	}

	$scope.inside_get_page_data_movie = function(response){
		if($scope.active_tab == 'movie') external_internal_data_merger.merge_user_movies_to_external_data(response.data.results, $scope.user_movies);
		else external_internal_data_merger.merge_user_movies_to_external_data(response.data.results, $scope.user_series);
		$scope.movies=response.data.results;
		console.log(0000000000)
		$(".tooltip").hide();
		if(response.data.total_pages<1000) $scope.pagination=response.data.total_pages;
		else $scope.pagination=1000;
		$scope.current_page=response.data.page;
		$scope.from=(response.data.page-1)*20+1;
		$scope.to=(response.data.page-1)*20+response.data.results.length;
		$scope.in=response.data.total_results;
		$scope.is_waiting=false;
	}

	$scope.inside_get_page_data_person = function(response){
		$scope.people=response.data.results;
		$(".tooltip").hide();
		if(response.data.total_pages<1000) $scope.pagination=response.data.total_pages;
		else $scope.pagination=1000;
		$scope.current_page=response.data.page;
		$scope.from=(response.data.page-1)*20+1;
		$scope.to=(response.data.page-1)*20+response.data.results.length;
		$scope.in=response.data.total_results;
		$scope.is_waiting=false;
	}

    $scope.get_first_page_data = function()
    {
    	$scope.page=1;
    	$scope.get_page_data();
	}
//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// RETRIEVE MOVIECARD DATA //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////// SET FOCUS /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.setFocus = function(id_of_input){
		setTimeout(function() {
			angular.element('#'+id_of_input).focus();
		}, 500);
	}
//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////// SET FOCUS /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// QUICK RATE /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.first_quick_vote=function()
	{
		$('#quick_vote_movies_or_series').modal('show');
	};

	$scope.quickvote=function()
	{
		$('#quick_vote_movies_or_series').modal('hide');
		$scope.get_quick_rate();
		$('#myModal').modal('show');
	};

	$scope.get_quick_rate=function()
	{
		if($scope.quick_vote_mode == 'movies'){
			f1 = 'get_quick_rate';
		}else{
			f1 = 'get_quick_rate_series';
		}
		rate[f1](pass.lang)
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
	$scope.quick_vote_mode='movies';
	$scope.get_quick_rate();

	$scope.next_quick_rate=function()
	{
		if($scope.modalmovies.length>1){
			$scope.modalmovie = $scope.modalmovies[0];
			$scope.next_modalmovie = $scope.modalmovies[1];
			$scope.modalmovie.is_quick_rate=true;
		}else if($scope.modalmovies.length==1){
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
		if($scope.quick_vote_mode == 'movies'){
			f1 = 'add_later';
			f2 = 'un_later';
			v1 = 'later_id';
		}else{
			f1 = 'series_add_later';
			f2 = 'series_un_later';
			v1 = 'id';
		}
		if($scope.modalmovie.later_id == null){
			rate[f1]($scope.modalmovie.id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.modalmovie.later_id=response.data.data[v1];
					$scope.modify_movies($scope.modalmovie);
				}
			});
		}else{
			rate[f2]($scope.modalmovie.later_id)
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
		if($scope.quick_vote_mode == 'movies'){
			f1 = 'add_rate';
			f2 = 'un_rate';
			v1 = 'rated_id';
		}else{
			f1 = 'series_add_rate';
			f2 = 'series_un_rate';
			v1 = 'id';
		}
		if(rate_code != null){
			rate[f1]($scope.modalmovie.id, rate_code)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.modalmovie.rated_id=response.data.data[v1];
					$scope.modalmovie.rate_code=response.data.data.rate;
					$scope.previous_quick_rate_movie=$scope.modalmovies.shift();
					$(".tooltip").hide();
					$scope.modify_movies($scope.previous_quick_rate_movie);
					$scope.next_quick_rate();
					if(pass.tt_navbar < 100) $scope.get_watched_movie_number();
				}
			});
		}else if(rate_code == null){
			rate[f2]($scope.modalmovie.rated_id)
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
		if($scope.quick_vote_mode == 'movies'){
			f1 = 'add_ban';
			f2 = 'un_ban';
			v1 = 'ban_id';
		}else{
			f1 = 'series_add_ban';
			f2 = 'series_un_ban';
			v1 = 'id';
		}
		if($scope.modalmovie.ban_id == null){
			rate[f1]($scope.modalmovie.id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.modalmovie.ban_id=response.data.data[v1];
					$scope.modify_movies($scope.modalmovie);
				}
			});
		}else{
			rate[f2]($scope.modalmovie.ban_id)
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
///////////////////////////////////// SAME PART(SEARCH) //////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.modify_user_movies=function(movie, which_function){
		if(_.where($scope.user_movies, {movie_id:movie.movie_id}).length>0){
			temp=_.where($scope.user_movies, {movie_id:movie.movie_id})[0];
			if(which_function == 'ban')temp.ban_id=movie.ban_id;
			if(which_function == 'later')temp.later_id=movie.later_id;
			if(which_function == 'rate')temp.rated_id=movie.rated_id;
			if(which_function == 'rate')temp.rate_code=movie.rate_code;
		}else{
			$scope.user_movies.push(movie);
		}
	}

	$scope.modify_user_series=function(movie, which_function){
		if(_.where($scope.user_series, {movie_id:movie.movie_id}).length>0){
			temp=_.where($scope.user_series, {movie_id:movie.movie_id})[0];
			if(which_function == 'ban')temp.ban_id=movie.ban_id;
			if(which_function == 'later')temp.later_id=movie.later_id;
			if(which_function == 'rate')temp.rated_id=movie.rated_id;
			if(which_function == 'rate')temp.rate_code=movie.rate_code;
			console.log(temp, movie)
		}else{
			$scope.user_series.push(movie);
		}
	}

	$scope.paginate = function(page)
	{
		$scope.page = page;
		$scope.get_page_data();
		$scope.scroll_to_top();
	}

	$scope.votemodal=function(index, movie)
	{
		$scope.modalmovie=movie;
		$scope.modalmovie.index=index;
		$('#myModal').modal('show');
	};

	$scope.rate_class = function(is_rated)
	{
		switch(is_rated) {
			case 5:
				return 'btn-success';
			case 4:
				return 'btn-info';
			case 3:
				return 'btn-secondary';
			case 2:
				return 'btn-warning text-white';
			case 1:
				return 'btn-danger';
			default:
				return 'btn-outline-secondary addlater';
		}
	}

	$scope.later=function(index)
	{
		console.log(index)
		if($scope.active_tab == 'movie'){
			f1 = 'add_later';
			f2 = 'un_later';
			f3 = 'modify_user_movies';
			v1 = 'later_id';
			v2 = 'movie_id';
		}else{
			f1 = 'series_add_later';
			f2 = 'series_un_later';
			f3 = 'modify_user_series';
			v1 = 'id';
			v2 = 'series_id';
		}
		if($scope.movies[index].later_id == null){
			rate[f1]($scope.movies[index].id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.movies[index].later_id=response.data.data[v1];
					$scope[f3]({
						'movie_id':response.data.data[v2],
						'rated_id':null,
						'rate_code':null,
						'later_id':response.data.data[v1],
						'ban_id':null
					}, 'later');
				}
			});
		}else{
			var temp = $scope.movies[index];
			rate[f2]($scope.movies[index].later_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204 || response.status == 404){
					$scope.movies[index].later_id=null;
					$scope[f3]({
						'movie_id':temp.id,
						'rated_id':temp.rated_id,
						'rate_code':temp.rate_code,
						'later_id':null,
						'ban_id':temp.ban_id
					}, 'later');
				}
			});
		}
	};
	
	$scope.rate=function(index, rate_code)
	{
		console.log(index, rate_code)
		if($scope.active_tab == 'movie'){
			f1 = 'add_rate';
			f2 = 'un_rate';
			f3 = 'modify_user_movies';
			v1 = 'rated_id';
			v2 = 'movie_id';
		}else{
			f1 = 'series_add_rate';
			f2 = 'series_un_rate';
			f3 = 'modify_user_series';
			v1 = 'id';
			v2 = 'series_id';
		}
		$('#myModal').modal('hide');
		if(rate_code != null){
			rate[f1]($scope.movies[index].id, rate_code)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.movies[index].rated_id=response.data.data[v1];
					$scope.movies[index].rate_code=response.data.data.rate;
					$scope[f3]({
						'movie_id':response.data.data[v2],
						'rated_id':response.data.data[v1],
						'rate_code':response.data.data.rate,
						'later_id':null,
						'ban_id':null
					}, 'rate')
				}
				if(pass.watched_movie_number<50) $scope.get_watched_movie_number();
			});
		}else if(rate_code == null){
			var temp = $scope.movies[index];
			rate[f2]($scope.movies[index].rated_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope.movies[index].rated_id=null;
					$scope.movies[index].rate_code=null;
					$scope[f3]({
						'movie_id':temp.id,
						'rated_id':null,
						'rate_code':null,
						'later_id':temp.later_id,
						'ban_id':temp.ban_id
					}, 'rate');
				}
				if(pass.watched_movie_number<50) $scope.get_watched_movie_number();
			});
		}
	};

	$scope.ban=function(index)
	{
		console.log(index)
		if($scope.active_tab == 'movie'){
			f1 = 'add_ban';
			f2 = 'un_ban';
			f3 = 'modify_user_movies';
			v1 = 'ban_id';
			v2 = 'movie_id';
		}else{
			f1 = 'series_add_ban';
			f2 = 'series_un_ban';
			f3 = 'modify_user_series';
			v1 = 'id';
			v2 = 'series_id';
		}
		if($scope.movies[index].ban_id == null){
			rate[f1]($scope.movies[index].id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.movies[index].ban_id=response.data.data[v1];
					$scope[f3]({
						'movie_id':response.data.data[v2],
						'rated_id':null,
						'rate_code':null,
						'later_id':null,
						'ban_id':response.data.data[v1]
					}, 'ban');
				}
			});
		}else{
			var temp = $scope.movies[index];
			rate[f2]($scope.movies[index].ban_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204 || response.status == 404){
					$scope.movies[index].ban_id=null;
					$scope[f3]({
						'movie_id':temp.id,
						'rated_id':temp.rated_id,
						'rate_code':temp.rate_code,
						'later_id':temp.later_id,
						'ban_id':null
					}, 'ban');
				}
			});
		}
	};
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SAME PART(SEARCH) //////////////////////////////////
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
			}else if(location.href.indexOf('topcorn.xyz/movie/')>-1){
				if(pass.tt_movie<50){
					if(pass.tt_movie==0)location.hash="tooltip-movie-share";
					else if(pass.tt_movie==1)location.hash="tooltip-movie-search";
					else if(pass.tt_movie==2)location.hash="tooltip-movie-cast";
					else if(pass.tt_movie==3)location.hash="tooltip-movie-review";
				}
			}else if(pass.tt_navbar<100){
				if(pass.watched_movie_number>49&&pass.tt_navbar<70)location.hash="tooltip-footer-like";
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
						pass.tt_navbar=1;
						$('#search').popover('show');
					});
				}else if(location.hash.indexOf('tooltip-navbar-recommendations')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 2)
					.then(function(response){
						pass.tt_navbar=2;
						$('#recommendations').popover('show');
					});
				}else if(location.hash.indexOf('tooltip-navbar-profile')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 3)
					.then(function(response){
						pass.tt_navbar=3;
						$('#profile').popover('show');
					});
				}else if(location.hash.indexOf('tooltip-navbar-percentage')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 4)
					.then(function(response){
						pass.tt_navbar=4;
						if(pass.watched_movie_number<50) $('#percentage').popover('show');
						else location.hash="#navbar-tooltips-done";
					});
				}else if(location.hash.indexOf('navbar-tooltips-done')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 50)
					.then(function(response){
						pass.tt_navbar=50;
						if(location.href.indexOf('topcorn.xyz/movie')>-1) location.hash='#tooltip-movie-share';
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
						pass.tt_navbar=70;
						if($scope.watched_movie_number>199){
							setTimeout(function() {
								$('#donate').popover('show');
							}, 2500);
						}
					});
				}else if(location.hash.indexOf('navbar-tooltips-all-done')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 100)
					.then(function(response){
						pass.tt_navbar=100;
					});
				}else if(location.hash.indexOf('cancel-tooltips')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 50)
					.then(function(response){
						pass.tt_navbar=50;
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
						pass.tt_movie=1;
						setTimeout(function() {
							$('#google').popover('show');
						}, 2500);
					});
				}else if(location.hash.indexOf('tooltip-movie-cast')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('movie', 2)
					.then(function(response){
						pass.tt_movie=2;
						setTimeout(function() {
							$('#cast').popover('show');
						}, 2500);
					});
				}else if(location.hash.indexOf('tooltip-movie-review')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('movie', 3)
					.then(function(response){
						pass.tt_movie=3;
						setTimeout(function() {
							$('#review').popover('show');
						}, 2500);
					});
				}else if(location.hash.indexOf('movie-tooltips-done')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('movie', 50)
					.then(function(response){
						pass.tt_movie=50;
					});
				}else if(location.hash.indexOf('cancel-movie-tooltips')>-1){
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('movie', 60)
					.then(function(response){
						pass.tt_movie=60;
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