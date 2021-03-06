MyApp.controller('MainPageController', function($scope, $http, $anchorScroll, rate, $sce, external_internal_data_merger)
{
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// SCROLL TO TOP ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.scroll_to_top=function(id){
		$anchorScroll.yOffset = 70;
		setTimeout(function() {
			$anchorScroll(id);
		}, 10);
		
	}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// SCROLL TO TOP ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	if(pass.is_auth == 1){
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
	}

	$scope.prepeare_reviews = function(reviews){
		_.each(reviews, function(review){
			review.content=review.content.replace(/(<([^>]+)>)/ig , "").replace(/\n/g , "<br>");//replace(/\r\n/g , "<br>");
			if(review.content.length>500 || (review.content.match(/<br>/g)||[]).length>1){
				review.url=$sce.trustAsHtml(review.content.replace(/<br>/g , " ").substring(0, 500)+'...');
				review.id='long';
			}else{
				review.url=$sce.trustAsHtml(review.content);
				review.id='short';
			}
			review.content=$sce.trustAsHtml(review.content);
		});
	}

	$scope.similar_movies1 = pass.movies.data;
	$scope.pagination_1=pass.movies.last_page;
	$scope.current_page_1=pass.movies.current_page;
	$scope.from_1=pass.movies.from;
	$scope.to_1=pass.movies.to;
	$scope.in_1=pass.movies.total;

	$scope.similar_movies2 = pass.series.data;
	$scope.pagination_2=pass.series.last_page;
	$scope.current_page_2=pass.series.current_page;
	$scope.from_2=pass.series.from;
	$scope.to_2=pass.series.to;
	$scope.in_2=pass.series.total;

	$scope.people3 = pass.people.data;
	$scope.pagination_3=pass.people.last_page;
	$scope.current_page_3=pass.people.current_page;
	$scope.from_3=pass.people.from;
	$scope.to_3=pass.people.to;
	$scope.in_3=pass.people.total;


	$scope.users4 = pass.users.data;
	$scope.pagination_4=pass.users.last_page;
	$scope.current_page_4=pass.users.current_page;
	$scope.from_4=pass.users.from;
	$scope.to_4=pass.users.to;
	$scope.in_4=pass.users.total;


	$scope.reviews5 = pass.reviews.data;
	$scope.prepeare_reviews($scope.reviews5);
	$scope.pagination_5=pass.reviews.last_page;
	$scope.current_page_5=pass.reviews.current_page;
	$scope.from_5=pass.reviews.from;
	$scope.to_5=pass.reviews.to;
	$scope.in_5=pass.reviews.total;

	console.log(pass)
	$scope.listes6 = pass.listes.data;
	$scope.pagination_6=pass.listes.last_page;
	$scope.current_page_6=pass.listes.current_page;
	$scope.from_6=pass.listes.from;
	$scope.to_6=pass.listes.to;
	$scope.in_6=pass.listes.total;



	$scope.constants_image_thumb_nail = pass.constants_image_thumb_nail;
	$scope.page_variables={
		expanded: -1,
		f_following1: pass.is_following1>0?'following':'all',
		f_sort1: 'newest',
		f_following2: pass.is_following2>0?'following':'all',
		f_sort2: 'newest',
		f_watch_later2: pass.f_watch_later
	};

	$scope.page_1=0;
	$scope.page_2=0;

	$scope.get_page_data = function(mode)
	{
		$scope.is_waiting=true;
		switch(mode) {
			case 1:
				if($scope.page_variables.active_tab_1 == 'now playing'){
					rate.get_now_playing(pass.api_key, pass.lang, pass.lang=='en'?'us':(pass.lang=='tr'?'tr':'hu'), $scope.page_1)
					.then(function(response){
						console.log(response);
						external_internal_data_merger.merge_user_movies_to_external_data(response.data.results, $scope.user_movies);
						$scope.similar_movies1=response.data.results;
						if(response.data.total_pages<1000) $scope.pagination_1=response.data.total_pages;
						else $scope.pagination_1=1000;
						$scope.current_page_1=response.data.page;
						$scope.from_1=(response.data.page-1)*20+1;
						$scope.to_1=(response.data.page-1)*20+response.data.results.length;
						$scope.in_1=response.data.total_results;
						$scope.is_1=false;
						$(".tooltip").hide();
					});
				}else{
					rate.get_legendary_garbage_movies($scope.page_variables.active_tab_1, $scope.page_variables.f_following1, $scope.page_variables.f_sort1, $scope.page_1)
					.then(function(response){
						console.log(response);
						$scope.similar_movies1 = response.data.data;
						$scope.pagination_1=response.data.last_page;
						$scope.current_page_1=response.data.current_page;
						$scope.from_1=response.data.from;
						$scope.to_1=response.data.to;
						$scope.in_1=response.data.total;
						$(".tooltip").hide();
					});
				}
				break;
			case 2:
				if($scope.page_variables.active_tab_2 == 'on air'){
					rate.get_airing_series($scope.page_variables.f_watch_later2, $scope.page_2)
					.then(function(response){
						console.log(response);
						$scope.similar_movies2 = response.data.data;
						$scope.pagination_2=response.data.last_page;
						$scope.current_page_2=response.data.current_page;
						$scope.from_2=response.data.from;
						$scope.to_2=response.data.to;
						$scope.in_2=response.data.total;
						$(".tooltip").hide();
					});
				}else{
					rate.get_legendary_garbage_series($scope.page_variables.active_tab_2, $scope.page_variables.f_following2, $scope.page_variables.f_sort2, $scope.page_2)
					.then(function(response){
						console.log(response);
						$scope.similar_movies2 = response.data.data;
						$scope.pagination_2=response.data.last_page;
						$scope.current_page_2=response.data.current_page;
						$scope.from_2=response.data.from;
						$scope.to_2=response.data.to;
						$scope.in_2=response.data.total;
						$(".tooltip").hide();
					});
				}
				break;
			case 3:
				rate.get_popular_people($scope.page_variables.active_tab_3, $scope.page_3)
				.then(function(response){
					console.log(response);
					$scope.people3 = response.data.data;
					$scope.pagination_3=response.data.last_page;
					$scope.current_page_3=response.data.current_page;
					$scope.from_3=response.data.from;
					$scope.to_3=response.data.to;
					$scope.in_3=response.data.total;
					$(".tooltip").hide();
				});
				break;
			case 4:
				rate.get_popular_users($scope.page_variables.active_tab_4, $scope.page_variables.f_following4, $scope.page_4)
				.then(function(response){
					console.log(response);
					$scope.users4 = response.data.data;
					$scope.pagination_4=response.data.last_page;
					$scope.current_page_4=response.data.current_page;
					$scope.from_4=response.data.from;
					$scope.to_4=response.data.to;
					$scope.in_4=response.data.total;
					$(".tooltip").hide();
				});
				break;
			case 5:
				rate.get_popular_reviews($scope.page_variables.active_tab_5, $scope.page_variables.f_following5, $scope.page_5)
				.then(function(response){
					console.log(response);
					$scope.reviews5 = response.data.data;
					$scope.prepeare_reviews($scope.reviews5);
					$scope.pagination_5=response.data.last_page;
					$scope.current_page_5=response.data.current_page;
					$scope.from_5=response.data.from;
					$scope.to_5=response.data.to;
					$scope.in_5=response.data.total;
					$(".tooltip").hide();
				});
				break;
			case 6:
				rate.get_popular_lists($scope.page_variables.active_tab_6, $scope.page_variables.f_following6, $scope.page_6)
				.then(function(response){
					console.log(response);
					$scope.listes6 = response.data.data;
					$scope.pagination_6=response.data.last_page;
					$scope.current_page_6=response.data.current_page;
					$scope.from_6=response.data.from;
					$scope.to_6=response.data.to;
					$scope.in_6=response.data.total;
					$(".tooltip").hide();
				});
				break;
			default:
		}
	}

    $scope.get_first_page_data = function(mode)
    {
    	$scope['page_'+mode]=1;
    	$scope.get_page_data(mode);
	}

	$scope.paginate_1 = function(page)
	{
		$scope.page_1 = page;
		$scope.get_page_data(1);
		$scope.scroll_to_top('scroll_to_top1');
	}

	$scope.paginate_2 = function(page)
	{
		$scope.page_2 = page;
		$scope.get_page_data(2);
		$scope.scroll_to_top('scroll_to_top2');
	}

	$scope.paginate_3 = function(page)
	{
		$scope.page_3 = page;
		$scope.get_page_data(3);
		$scope.scroll_to_top('scroll_to_top3');
	}

	$scope.paginate_4 = function(page)
	{
		$scope.page_4 = page;
		$scope.get_page_data(4);
		$scope.scroll_to_top('scroll_to_top4');
	}

	$scope.paginate_5 = function(page)
	{
		$scope.page_5 = page;
		$scope.get_page_data(5);
		$scope.scroll_to_top('scroll_to_top5');
	}

	$scope.paginate_6 = function(page)
	{
		$scope.page_6 = page;
		$scope.get_page_data(6);
		$scope.scroll_to_top('scroll_to_top6');
	}

	$scope.toggle_collapse = function(id, mode)
	{
		$(".tooltip").hide();
		if(mode == 'expand'){
			$('#'+id).collapse('show');
		}else{
			$('#'+id).collapse('hide');
		}
	}

	$scope.like_review=function(index){
		console.log(index)
		if($scope.reviews5[index].is_liked == 0){
			rate.add_review_like($scope.reviews5[index].review_id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.reviews5[index].is_liked = 1;
					$scope.reviews5[index].count ++;
				}
			});
		}else{
			rate.un_review_like($scope.reviews5[index].review_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204 || response.status == 404){
					$scope.reviews5[index].is_liked = 0;
					$scope.reviews5[index].count --;
				}
			});
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// RETRIEVE MOVIECARD DATA //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// RETRIEVE MOVIECARD DATA //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////



if(pass.is_auth == 1){
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
		$scope.active_tab = movie.title!=undefined?'movie':'series';
		$scope.modalmovie = movie;
		$scope.modalmovie.index = index;
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

	$scope.later=function(index, mode)
	{
		console.log(index)
		if(mode == 'movie'){
			f1 = 'add_later';
			f2 = 'un_later';
			f3 = 'modify_user_movies';
			v0 = 'similar_movies1';
			v1 = 'later_id';
			v2 = 'movie_id';
		}else{
			f1 = 'series_add_later';
			f2 = 'series_un_later';
			f3 = 'modify_user_series';
			v0 = 'similar_movies2';
			v1 = 'id';
			v2 = 'series_id';
		}
		if($scope[v0][index].later_id == null){
			rate[f1]($scope[v0][index].id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope[v0][index].later_id=response.data.data[v1];
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
			var temp = $scope[v0][index];
			rate[f2]($scope[v0][index].later_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204 || response.status == 404){
					$scope[v0][index].later_id=null;
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
			v0 = 'similar_movies1';
			v1 = 'rated_id';
			v2 = 'movie_id';
		}else{
			f1 = 'series_add_rate';
			f2 = 'series_un_rate';
			f3 = 'modify_user_series';
			v0 = 'similar_movies2';
			v1 = 'id';
			v2 = 'series_id';
		}
		$('#myModal').modal('hide');
		if(rate_code != null){
			rate[f1]($scope[v0][index].id, rate_code)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope[v0][index].rated_id=response.data.data[v1];
					$scope[v0][index].rate_code=response.data.data.rate;
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
			var temp = $scope[v0][index];
			rate[f2]($scope[v0][index].rated_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope[v0][index].rated_id=null;
					$scope[v0][index].rate_code=null;
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

	$scope.ban=function(index, mode)
	{
		console.log(index)
		if(mode == 'movie'){
			f1 = 'add_ban';
			f2 = 'un_ban';
			f3 = 'modify_user_movies';
			v0 = 'similar_movies1';
			v1 = 'ban_id';
			v2 = 'movie_id';
		}else{
			f1 = 'series_add_ban';
			f2 = 'series_un_ban';
			f3 = 'modify_user_series';
			v0 = 'similar_movies2';
			v1 = 'id';
			v2 = 'series_id';
		}
		if($scope[v0][index].ban_id == null){
			rate[f1]($scope[v0][index].id)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope[v0][index].ban_id=response.data.data[v1];
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
			var temp = $scope[v0][index];
			rate[f2]($scope[v0][index].ban_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204 || response.status == 404){
					$scope[v0][index].ban_id=null;
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
}
});