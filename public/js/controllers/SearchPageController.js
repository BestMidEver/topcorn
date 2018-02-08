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
	$scope.model={};
	$scope.active_tab='movie';
	$scope.page=1;

	rate.get_user_movies()
	.then(function(response){
		console.log(response.data);
		$scope.user_movies = response.data;
	});

	$scope.reset_tab = function()
	{
		$scope.page=null;
		$scope.pagination=null;
		$scope.current_page=null;
		$scope.movies=null;
		$scope.people=null;
		$scope.users=null
		$scope.model.movie='';
		$scope.model.person='';
		$scope.model.user='';
	}

	$scope.get_page_data = function()
	{
		if($scope.model[$scope.active_tab].length == 0){
			$scope.reset_tab();
		}else{
			var temp=$scope.model[$scope.active_tab].replace(/ /g , "%20");
			switch($scope.active_tab) {
				case 'movie':
					rate.search_movies(pass.constants_api_key, pass.lang, temp, $scope.page)
					.then(function(response){
						console.log(response.data);
						if(!response.data.results.length>0){
							rate.search_people(pass.constants_api_key, pass.lang, temp, $scope.page)
							.then(function(response){
								if(response.data.results.length>0){
									$scope.active_tab='person';
									$scope.setFocus('input_person');
									$scope.model.person=$scope.model.movie;
									$scope.model.movie='';
									$scope.inside_get_page_data_person(response);
								}
							});
						}
						$scope.inside_get_page_data_movie(response);
						if($scope.current_level == 201)$scope.level_up(202);
					});
					break;
				case 'person':
					rate.search_people(pass.constants_api_key, pass.lang, temp, $scope.page)
					.then(function(response){
						console.log(response.data);
						if(!response.data.results.length>0){
							rate.search_movies(pass.constants_api_key, pass.lang, temp, $scope.page)
							.then(function(response){
								if(response.data.results.length>0){
									$scope.active_tab='movie';
									$scope.setFocus('input_movie');
									$scope.model.movie=$scope.model.person;
									$scope.model.person='';
									$scope.inside_get_page_data_movie(response);
								}
							});
						}
						$scope.inside_get_page_data_person(response);
					});
					break;
				case 'user':
					rate.search_users(temp, $scope.page_search)
					.then(function(response){
						console.log(response.data);
						$scope.users=response.data.data;
						$scope.pagination_search=response.data.last_page;
						$scope.current_page_search=response.data.current_page;
						$scope.from=response.data.from;
						$scope.to=response.data.to;
						$scope.in=response.data.total;
					});
					break;
				default:
			}
			$(".tooltip").hide();
		}
	}

	$scope.inside_get_page_data_movie = function(response){
		external_internal_data_merger.merge_user_movies_to_external_data(response.data.results, $scope.user_movies);
		$scope.movies=response.data.results;
		if(response.data.total_pages<1000) $scope.pagination=response.data.total_pages;
		else $scope.pagination=1000;
		$scope.current_page=response.data.page;
		$scope.from=(response.data.page-1)*20+1;
		$scope.to=(response.data.page-1)*20+response.data.results.length;
		$scope.in=response.data.total_results;
	}

	$scope.inside_get_page_data_person = function(response){
		$scope.people=response.data.results;
		if(response.data.total_pages<1000) $scope.pagination=response.data.total_pages;
		else $scope.pagination=1000;
		$scope.current_page=response.data.page;
		$scope.from=(response.data.page-1)*20+1;
		$scope.to=(response.data.page-1)*20+response.data.results.length;
		$scope.in=response.data.total_results;
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
		console.log(id_of_input)
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
	$scope.quickvote=function()
	{
		$scope.get_quick_rate();
		$('#myModal').modal('show');
		if($scope.current_level == 100) $scope.level_up(101);//NEW NEW NEW
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
					if($scope.current_level == 101) $scope.get_watched_movie_number(102);		//NEW NEW
					else if($scope.current_level==400) $scope.get_watched_movie_number(401);		//NEW NEW
					//$('#myModal').modal('hide');
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
					//$('#myModal').modal('hide');
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
		console.log($scope.user_movies);
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
					$scope.modify_user_movies({
						'movie_id':response.data.data.movie_id,
						'rated_id':null,
						'rate_code':null,
						'later_id':response.data.data.later_id,
						'ban_id':null
					}, 'later');
				}
			});
		}else{
			var temp = $scope.movies[index];
			rate.un_later($scope.movies[index].later_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204 || response.status == 404){
					$scope.movies[index].later_id=null;
					$scope.modify_user_movies({
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
		$('#myModal').modal('hide');
		if(rate_code != null){
			rate.add_rate($scope.movies[index].id, rate_code)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.movies[index].rated_id=response.data.data.rated_id;
					$scope.movies[index].rate_code=response.data.data.rate;
					$scope.modify_user_movies({
						'movie_id':response.data.data.movie_id,
						'rated_id':response.data.data.rated_id,
						'rate_code':response.data.data.rate,
						'later_id':null,
						'ban_id':null
					}, 'rate')
				}else{
					$('#myModal').modal('show');
				}
				if($scope.current_level==202) $scope.level_up(203);
				else if($scope.current_level==400) $scope.get_watched_movie_number(401);		//NEW NEW NEW
			});
		}else if(rate_code == null){
			var temp = $scope.movies[index];
			rate.un_rate($scope.movies[index].rated_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope.movies[index].rated_id=null;
					$scope.movies[index].rate_code=null;
					$scope.modify_user_movies({
						'movie_id':temp.id,
						'rated_id':null,
						'rate_code':null,
						'later_id':temp.later_id,
						'ban_id':temp.ban_id
					}, 'rate');
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
					$scope.modify_user_movies({
						'movie_id':response.data.data.movie_id,
						'rated_id':null,
						'rate_code':null,
						'later_id':null,
						'ban_id':response.data.data.ban_id
					}, 'ban');
				}
			});
		}else{
			var temp = $scope.movies[index];
			rate.un_ban($scope.movies[index].ban_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204 || response.status == 404){
					$scope.movies[index].ban_id=null;
					$scope.modify_user_movies({
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
	if(pass.level < 700){
		$scope.show_tutorial = function(){
			setTimeout(function() {
				$('#tutorial').modal('show');
			}, 1000);
		}

		if(pass.level == 0)	$scope.show_tutorial();
		else if(pass.level == 200 && window.location.href.indexOf("topcorn.io/search") > -1){
			rate.level_manipulate(201)
			.then(function(response){
				console.log(response);
				$scope.current_level = response.data;
				$scope.show_tutorial();
			});
		}else if(pass.level == 400) $scope.get_watched_movie_number(401);
		else if(pass.level == 500 && window.location.href.indexOf("topcorn.io/account") > -1){
			rate.level_manipulate(501)
			.then(function(response){
				console.log(response);
				$scope.current_level = response.data;
				$scope.show_tutorial();
			});
		}else if(pass.level == 504 && window.location.href.indexOf("topcorn.io/account") > -1){
			$scope.show_tutorial();
		}else if(pass.level == 504 && window.location.href.indexOf("topcorn.io/profile") > -1){
			rate.level_manipulate(505)
			.then(function(response){
				console.log(response);
				$scope.current_level = response.data;
				$scope.show_tutorial();
			});
		}

		$scope.get_watched_movie_number = function(lvl){
			rate.get_watched_movie_number()
			.then(function(response){
				console.log(response)
				if(lvl==102 && response.data>0) $scope.level_up(lvl);
				else if(lvl==401 && response.data>49) $scope.level_up(lvl);
			});
		}

		$scope.current_level = pass.level;

		$scope.level_check = function(){
			if($scope.current_level==200 && window.location.href.indexOf("topcorn.io/search") > -1){
				rate.level_manipulate(201)
				.then(function(response){
					console.log(response);
					$scope.current_level = response.data;
				});
			}
		}

		$scope.level_up = function(lvl){
			if(lvl == 1 || lvl == 700)$('#tutorial').modal('hide');
			rate.level_manipulate(lvl)
			.then(function(response){
				console.log(response);
				$scope.current_level = response.data;
				$scope.level_check();
				if($scope.current_level!=100 && $scope.current_level!=200 && $scope.current_level!=700){
					$scope.show_tutorial();
				}
			});
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// TUTORIAL ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
});