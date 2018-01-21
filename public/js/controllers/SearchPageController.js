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
	$scope.user_id = pass.user_id;
	$scope.model={};
	$scope.active_tab='movie';
	$scope.page=1;

	rate.get_user_movies()
	.then(function(response){
		console.log(response.data);
		$scope.user_movies = response.data.data;
	});

	$scope.reset_tab = function()
	{
		$scope.page=null;
		$scope.pagination=null;
		$scope.current_page=null;
		$scope.movies=null;
		$scope.people=null;
		$scope.users=null
		$scope.model={};
	}

	$scope.get_page_data = function()
	{
		if($scope.model[$scope.active_tab].length == 0){
			$scope.reset_tab();
		}else{
			var temp=$scope.model[$scope.active_tab].replace(/ /g , "%20");
			switch($scope.active_tab) {
				case 'movie':
				$http({
					method: 'GET',
					url: 'https://api.themoviedb.org/3/search/movie?api_key='+pass.constants_api_key+'&language='+pass.lang+'&query='+temp+'&page='+$scope.page+'&include_adult=false'
				}).then(function successCallback(response) {
					console.log(response.data);
					external_internal_data_merger.merge_user_movies_to_external_data(response.data.results, $scope.user_movies);
					$scope.movies=response.data.results;
					if(response.data.total_pages<1000) $scope.pagination=response.data.total_pages;
					else $scope.pagination=1000;
					$scope.current_page=response.data.page;
				}, function errorCallback(response) {
				});
				break;
				case 'person':
					$http({
						method: 'GET',
						url: 'https://api.themoviedb.org/3/search/person?api_key='+pass.constants_api_key+'&language='+pass.lang+'&query='+temp+'&page='+$scope.page+'&include_adult=false'
					}).then(function successCallback(response) {
						console.log(response.data);
						$scope.people=response.data.results;
						$scope.pagination=response.data.total_pages;
						$scope.current_page=response.data.page;
					}, function errorCallback(response) {
					});
				break;
				case 'user':
					rate.search_users(temp, $scope.page_search)
					.then(function(response){
						console.log(response.data);
						$scope.users=response.data.data;
						$scope.pagination_search=response.data.last_page;
						$scope.current_page_search=response.data.current_page;
					});
				break;
				default:
			}
			$(".tooltip").hide();
		}
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
////////////////////////////////// INPUT FOCUS ON TAB CHANGE /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.setFocus = function(id_of_input){
		console.log(id_of_input)
		setTimeout(function() {
			angular.element('#'+id_of_input).focus();
		}, 500);
	}
//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// INPUT FOCUS ON TAB CHANGE /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// QUICK RATE /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.quickvote=function()
	{
		$scope.get_quick_rate();
	};

	$scope.get_quick_rate=function()
	{
		rate.get_quick_rate(pass.lang)
		.then(function(response){
			console.log(response.data)
			if(response.data.length>0){
				$scope.modalmovies=response.data;
				$scope.next_quick_rate();
				$('#myModal').modal('show');
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
					$scope.modify_movies($scope.previous_quick_rate_movie);
					$scope.next_quick_rate();
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
	$scope.modify_user_movies=function(movie){
		if(_.where($scope.user_movies, {movie_id:movie.movie_id}).length>0){
			temp=_.where($scope.user_movies, {movie_id:movie.movie_id})[0];
			temp.ban_id=movie.ban_id;
			temp.later_id=movie.later_id;
			temp.rated_id=movie.rated_id;
			temp.rate_code=movie.rate_code;
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
					});
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
					});
				}
			});
		}
	};
	
	$scope.rate=function(index, rate_code)
	{
		console.log(index, rate_code)
		if(rate_code != null){
			rate.add_rate($scope.movies[index].id, rate_code)
			.then(function(response){
				console.log(response);
				if(response.status == 201){
					$scope.movies[index].rated_id=response.data.data.rated_id;
					$scope.movies[index].rate_code=response.data.data.rate;
					$('#myModal').modal('hide');
					$scope.modify_user_movies({
						'movie_id':response.data.data.movie_id,
						'rated_id':response.data.data.rated_id,
						'rate_code':response.data.data.rate,
						'later_id':null,
						'ban_id':null
					})
				}
			});
		}else if(rate_code == null){
			var temp = $scope.movies[index];
			rate.un_rate($scope.movies[index].rated_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope.movies[index].rated_id=null;
					$scope.movies[index].rate_code=null;
					$('#myModal').modal('hide');
					$scope.modify_user_movies({
						'movie_id':temp.id,
						'rated_id':null,
						'rate_code':null,
						'later_id':temp.later_id,
						'ban_id':temp.ban_id
					});
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
					});
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
					});
				}
			});
		}
	};
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SAME PART(SEARCH) //////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
});