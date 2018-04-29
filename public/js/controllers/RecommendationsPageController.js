MyApp.controller('RecommendationsPageController', function($scope, $http, $timeout, $anchorScroll, rate)
{		
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// SCROLL TO TOP ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.scroll_to_top=function(){
		$anchorScroll.yOffset = 55;
		$anchorScroll('scroll_top_point')
	}		
	$scope.scroll_to_toppest=function(){
		$anchorScroll.yOffset = 10;
		$anchorScroll('scroll_toppest_point')
	}	
	$scope.scroll_to_filter=function(){
		//$anchorScroll.yOffset = 10;
		//$anchorScroll('filter')
	}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// SCROLL TO TOP ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// ANGULAR SLIDER AND FILTER /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
		$scope.slider={};
		$scope.slider = {
			minValue: parseInt(pass.constants_angular_slider_min_value),
			maxValue: parseInt(pass.constants_angular_slider_max_value),
			options: {
				floor: parseInt(pass.constants_angular_slider_min_value),
				ceil: parseInt(pass.constants_angular_slider_max_value)
			}
		};
		$scope.slider_vote_count={};
		$scope.slider_vote_count = {
			value: parseInt(pass.constants_angular_slider_min_vote_count),
			options: {
		        floor: 25,
		        ceil: 5000,
		        step: 25
			}
		};
	    $scope.drawslider=function(){
	    	$scope.refreshSlider();
	    }
		$scope.refreshSlider = function () {
		    $timeout(function () {
		        $scope.$broadcast('rzSliderForceRender');
		    });
		};

		$scope.languages = _.sortBy(languages, 'o');
		$scope.languages.pop();
		$scope.genres = _.sortBy(genres, 'o');
		console.log($scope.genres, genres)
		$scope.genres.pop();
		$scope.sort_by_2 = 'vote_average';
		$scope.sort_by_4 = 'point';

		$('#collapseFilter').on('show.bs.collapse', function () {
		   angular.element( document.querySelector( '#filter_button' ) ).addClass('btn-outline-secondary-hover');
		});
		$('#collapseFilter').on('hide.bs.collapse', function () {
		  angular.element( document.querySelector( '#filter_button' ) ).removeClass('btn-outline-secondary-hover');
		});

		$('#collapseAdd').on('show.bs.collapse', function () {
		   angular.element( document.querySelector( '#addperson_button' ) ).addClass('btn-outline-secondary-hover');
		   angular.element( document.querySelector( '#addmovie_button' ) ).addClass('btn-outline-secondary-hover');
		});
		$('#collapseAdd').on('hide.bs.collapse', function () {
		  angular.element( document.querySelector( '#addperson_button' ) ).removeClass('btn-outline-secondary-hover');
		  angular.element( document.querySelector( '#addmovie_button' ) ).removeClass('btn-outline-secondary-hover');
		});
//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// ANGULAR SLIDER AND FILTER /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




	if(pass.is_auth==1){
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
	}




//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// RETRIEVE MOVIECARD DATA //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.constants_image_thumb_nail = pass.constants_image_thumb_nail;
   	var f_users = [pass.user_id];
	$scope.user_id = pass.user_id;
    $scope.f_lang_model = [];
    $scope.f_genre_model = [];
    $scope.f_add_watched = false;
	$scope.active_tab= pass.watched_movie_number < 50 ? 'top_rated' : 'pemosu';
	$scope.is_waiting=false;

    $scope.get_page_data = function()
    {
    	$scope.movies=[];
    	$scope.pagination=0;
    	$scope.is_waiting=true;
    	var f_lang = [];
        var temp = _.pairs($scope.f_lang_model);
        for (var i = 0; i < temp.length; i++) {
        	if(temp[i][1]) f_lang.push( temp[i][0] );
        }
        var f_genre = [];
        temp = _.pairs($scope.f_genre_model);
        for (var i = 0; i < temp.length; i++) {
        	if(temp[i][1]) f_genre.push( temp[i][0].split("_")[1] );
        }

		if($scope.active_tab != 'mood_pick'){
			var data = {
				"f_users": f_users,
				"f_lang": f_lang,
				"f_genre": f_genre,
				"f_min": $scope.slider.minValue,
				"f_max": $scope.slider.maxValue,
				"f_sort": $scope.active_tab == 'top_rated' ? $scope.sort_by_2 : $scope.sort_by_4,
				"f_vote": $scope.slider_vote_count.value,
				"f_add_watched": $scope.f_add_watched
			}	
		}else{
			console.log($scope.f_mode_movies)
			if($scope.f_mode_movies == []) return;
			var data = {
				"f_users": f_users,
				"f_lang": f_lang,
				"f_genre": f_genre,
				"f_min": $scope.slider.minValue,
				"f_max": $scope.slider.maxValue,
				"f_sort": $scope.sort_by_4,
				"f_vote": $scope.slider_vote_count.value,
				"f_mode_movies": $scope.f_mode_movies,
				"f_add_watched": $scope.f_add_watched
			}
		}

		rate.get_recommendations_page_data($scope.active_tab, data, $scope.page)
		.then(function(response){
			console.log(response.data[1])
			console.log(response.data[0])
			$scope.movies=response.data[0].data;
			$scope.pagination=response.data[0].last_page;
			$scope.current_page=response.data[0].current_page;
			$scope.from=response.data[0].from;
			$scope.to=response.data[0].to;
			$scope.in=response.data[0].total;
			$(".tooltip").hide();
			$scope.is_waiting=false;
		});
	}

    $scope.get_first_page_data = function()
    {
    	$scope.page=1;
    	$scope.get_page_data();
	}
	$scope.get_first_page_data();
	$scope.slider.options.onEnd = $scope.get_first_page_data;
	$scope.slider_vote_count.options.onEnd = $scope.get_first_page_data;

	$scope.reset_add_person_input = function()
	{
		$scope.search_text='';
		$scope.search_users();
	}

	$scope.change_sort_by = function(mode)
	{
		if($scope.active_tab == 'top_rated'){
			$scope.sort_by_2 = mode;
		}else{
			$scope.sort_by_4 = mode;
		}
		$scope.get_first_page_data();
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
////////////////////////////////////// ADD MOVIES TO MOOD ////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
		$scope.page_mode=1;

		$scope.paginate_mode = function(page)
		{
			$scope.page_mode = page;
			$scope.get_search_movies();
			$scope.scroll_to_toppest();
		}
		
		$scope.search_mode_text='';
		$scope.get_search_movies = function()
		{
			var temp = $scope.search_mode_text.replace(/ /g , "%20");
			if(temp.length > 0){
				rate.search_movies(pass.constants_api_key, pass.lang, temp, $scope.page_mode)
				.then(function(response){
					console.log(response.data);
					$scope.search_movies=response.data.results;
					$(".tooltip").hide();
					if(response.data.total_pages<1000) $scope.pagination_mode=response.data.total_pages;
					else $scope.pagination_mode=1000;
					$scope.current_page_mode=response.data.page;
					$scope.from_mode=(response.data.page-1)*20+1;
					$scope.to_mode=(response.data.page-1)*20+response.data.results.length;
					$scope.in_mode=response.data.total_results;
					$scope.is_mode_search=true;
					$(".tooltip").hide();
				});
			}else{
				$scope.get_watched_movies();
			}
		}

		$scope.mode_active_tab='get_rateds/5';
		$scope.get_watched_movies = function()
		{
			rate.get_profile_data($scope.mode_active_tab, pass.user_id, $scope.page_mode)
			.then(function(response){
				console.log(response.data)
				$scope.search_movies=response.data.data;
				$scope.pagination_mode=response.data.last_page;
				$scope.current_page_mode=response.data.current_page;
				$scope.from_mode=response.data.from;
				$scope.to_mode=response.data.to;
				$scope.in_mode=response.data.total;
				$scope.is_mode_search=false;
				$(".tooltip").hide();
			});
		}
		$scope.get_watched_movies();

		$scope.search_get_first = function()
		{
			$scope.page_search = 1;
			$scope.page_mode = 1;
			if($scope.active_tab!='mood_pick'){
				$scope.search_users();
			}else{
				$scope.get_search_movies();
			}
		}

		$scope.change_mode_active_tab = function(mode)
		{
			$scope.mode_active_tab='get_rateds/'+mode;
		}

		$scope.mode_movies = [];
		$scope.f_mode_movies = [];
		$scope.add_to_mode = function(movie)
		{
			$scope.mode_movies = _.uniq( _.union($scope.mode_movies, [movie]),'id' );
			$scope.f_mode_movies = _.pluck($scope.mode_movies, 'id');
			$scope.get_first_page_data();
		}

		$scope.remove_from_mode = function(movie)
		{
			$scope.mode_movies = _.filter($scope.mode_movies, function(item) {
			    return item.id !== movie
			});
			$scope.f_mode_movies = _.pluck($scope.mode_movies, 'id');
			$scope.get_first_page_data();
		}
//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// ADD MOVIES TO MOOD ////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




	if(pass.is_auth==1){
//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// ADD USERS TO WATCH TOGETHER ///////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
		$scope.party_members = [];
		
		$scope.get_last_parties = function()
		{
			rate.get_last_parties($scope.page_search)
			.then(function(response){
				console.log(response);
				$scope.users=response.data.data;
				$scope.pagination_search=response.data.last_page;
				$scope.current_page_search=response.data.current_page;
				$scope.from_search=response.data.from;
				$scope.to_search=response.data.to;
				$scope.in_search=response.data.total;
				$scope.is_search=false;
			});
		}
		
		$scope.search_users = function()
		{
			if($scope.search_text.length>0){
				rate.search_users($scope.search_text, $scope.page_search)
				.then(function(response){
					console.log(response.data);
					$scope.users=response.data.data;
					$scope.pagination_search=response.data.last_page;
					$scope.current_page_search=response.data.current_page;
					$scope.from_search=response.data.from;
					$scope.to_search=response.data.to;
					$scope.in_search=response.data.total;
					$scope.is_search=true;
				});
			}else{
				$scope.get_last_parties();
			}
		}

		$scope.add_to_history = function(user_id)
		{
			rate.add_to_history(user_id)
			.then(function(response){
				console.log(response.data);
			});
		}

		$scope.add_to_party = function(user)
		{
			if(user.user_id==pass.user_id) return;
			$scope.party_members=_.uniq( _.union($scope.party_members, [user]),'user_id' );
			f_users=_.union(_.pluck($scope.party_members, 'user_id'), [pass.user_id]);
			$scope.get_first_page_data();
			$scope.add_to_history(user.user_id);
		}
		
		if(pass.with_user_id != ''){
			$scope.add_to_party({'user_id':parseInt(pass.with_user_id), 'name':pass.with_user_name});
		}
		$timeout(function () {
			$scope.get_last_parties();
		});

		$scope.remove_from_party = function(user_id)
		{
			$scope.party_members = _.filter($scope.party_members, function(item) {
			    return item.user_id !== user_id
			});
			f_users=_.union(_.pluck($scope.party_members, 'user_id'), [pass.user_id]);
			$scope.get_first_page_data();
		}

		$scope.remove_from_history = function(user_id){
			rate.remove_from_history(user_id)
			.then(function(response){
				console.log(response.data);
				$scope.get_last_parties();
			});
		}

		$scope.paginate_search = function(page)
		{
			$scope.page_search = page;
			$scope.search_users();
			$scope.scroll_to_toppest();
		}
//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// ADD USERS TO WATCH TOGETHER ///////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	}




	if(pass.is_auth==1){
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
	}




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// SAME PART //////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
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
				return 'btn-outline-secondary addlarter';
		}
	}

	$scope.later=function(index)
	{
		console.log(index)
		if($scope.movies[index].later_id == null){
			rate.add_later($scope.movies[index].id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.movies[index].later_id=response.data.data.later_id;
				}
			});
		}else{
			rate.un_later($scope.movies[index].later_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204 || response.status == 404){
					$scope.movies[index].later_id=null;
				}
			});
		}
	};
	
	$scope.rate=function(index, rate_code)
	{
		console.log(index, rate_code)
		$('#myModal').modal('hide');
		if(rate_code != null){
			rate.add_rate($scope.movies[index].id, rate_code)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.movies[index].rated_id=response.data.data.rated_id;
					$scope.movies[index].rate_code=response.data.data.rate;
					if(pass.tt_navbar < 100) $scope.get_watched_movie_number();
				}else{
					$('#myModal').modal('show');
				}
			});
		}else if(rate_code == null){
			rate.un_rate($scope.movies[index].rated_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope.movies[index].rated_id=null;
					$scope.movies[index].rate_code=null;
					if(pass.tt_navbar < 100) $scope.get_watched_movie_number();
				}else{
					$('#myModal').modal('show');
				}
			});
		}
	};

	$scope.ban=function(index)
	{
		console.log(index)
		if($scope.movies[index].ban_id == null){
			rate.add_ban($scope.movies[index].id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.movies[index].ban_id=response.data.data.ban_id;
				}
			});
		}else{
			rate.un_ban($scope.movies[index].ban_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204 || response.status == 404){
					$scope.movies[index].ban_id=null;
				}
			});
		}
	};
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// SAME PART //////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
});