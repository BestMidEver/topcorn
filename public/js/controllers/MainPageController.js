MyApp.controller('MainPageController', function($scope, $http, $anchorScroll, rate, $sce)
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

	console.log(pass.people)
	$scope.people3 = pass.users.data;
	$scope.pagination_3=pass.users.last_page;
	$scope.current_page_3=pass.users.current_page;
	$scope.from_3=pass.users.from;
	$scope.to_3=pass.users.to;
	$scope.in_3=pass.users.total;


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


	$scope.constants_image_thumb_nail = pass.constants_image_thumb_nail;
	$scope.page_variables={};
	$scope.page_1=0;
	$scope.page_2=0;

	$scope.get_page_data = function(mode)
	{
		$scope.is_waiting=true;
		switch(mode) {
			case 1:
				rate.get_now_playing(pass.api_key, pass.lang, pass.lang=='en'?'us':(pass.lang=='tr'?'tr':'hu'), $scope.page_1)
				.then(function(response){
					//console.log(response);
					$scope.similar_movies1=response.data.results;
					if(response.data.total_pages<1000) $scope.pagination_1=response.data.total_pages;
					else $scope.pagination_1=1000;
					$scope.current_page_1=response.data.page;
					$scope.from_1=(response.data.page-1)*20+1;
					$scope.to_1=(response.data.page-1)*20+response.data.results.length;
					$scope.in_1=response.data.total_results;
					$scope.is_1=false;
				});
				break;
			case 2:
				rate.get_now_on_air(pass.api_key, pass.lang, $scope.page_2)
				.then(function(response){
					//console.log(response);
					$scope.similar_movies2=response.data.results;
					if(response.data.total_pages<1000) $scope.pagination_2=response.data.total_pages;
					else $scope.pagination_2=1000;
					$scope.current_page_2=response.data.page;
					$scope.from_2=(response.data.page-1)*20+1;
					$scope.to_2=(response.data.page-1)*20+response.data.results.length;
					$scope.in_2=response.data.total_results;
					$scope.is_2=false;
				});
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
				});
				break;
			case 4:
				rate.get_popular_users(0, $scope.page_4)
				.then(function(response){
					console.log(response);
					$scope.users4 = response.data.data;
					$scope.pagination_4=response.data.last_page;
					$scope.current_page_4=response.data.current_page;
					$scope.from_4=response.data.from;
					$scope.to_4=response.data.to;
					$scope.in_4=response.data.total;
				});
				break;
			case 5:
				rate.get_popular_reviews(0, $scope.page_5)
				.then(function(response){
					console.log(response);
					$scope.reviews5 = response.data.data;
					$scope.prepeare_reviews($scope.reviews5);
					$scope.pagination_5=response.data.last_page;
					$scope.current_page_5=response.data.current_page;
					$scope.from_5=response.data.from;
					$scope.to_5=response.data.to;
					$scope.in_5=response.data.total;
				});
				break;
			default:
		}
		$(".tooltip").hide();
	}

    $scope.get_first_page_data = function(mode)
    {
    	$scope['page_'+mode]=1;
    	$scope.get_page_data(mode);
	}

	$scope.get_first_page_data(1);
	$scope.get_first_page_data(2);
	$scope.get_first_page_data(3);

	$scope.paginate_1 = function(page)
	{
		$scope.page_1 = page;
		$scope.get_page_data(1);
		$scope.scroll_to_top();
	}

	$scope.paginate_2 = function(page)
	{
		$scope.page_2 = page;
		$scope.get_page_data(2);
		$scope.scroll_to_top();
	}

	$scope.paginate_3 = function(page)
	{
		$scope.page_3 = page;
		$scope.get_page_data(3);
		$scope.scroll_to_top();
	}

	$scope.paginate_4 = function(page)
	{
		$scope.page_4 = page;
		$scope.get_page_data(4);
		$scope.scroll_to_top();
	}

	$scope.paginate_5 = function(page)
	{
		$scope.page_5 = page;
		$scope.get_page_data(5);
		$scope.scroll_to_top();
	}

//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// RETRIEVE MOVIECARD DATA //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// RETRIEVE MOVIECARD DATA //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




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
			//console.log(response.data)
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
					if(pass.watched_movie_number<50) $scope.get_watched_movie_number();
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
					if(pass.watched_movie_number<50) $scope.get_watched_movie_number();
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
});