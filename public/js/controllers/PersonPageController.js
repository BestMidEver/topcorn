MyApp.controller('PersonPageController', function($scope, $http, rate, external_internal_data_merger)
{
//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// RETRIEVE MOVIECARD DATA //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.get_page_data = function()
	{
		$http({
			method: 'GET',
			url: 'https://api.themoviedb.org/3/person/'+pass.personid+'?api_key='+pass.api_key+'&language='+pass.lang+'&append_to_response=movie_credits'
		}).then(function successCallback(response) {
			external_internal_data_merger.merge_user_movies_to_external_data(response.data.movie_credits.cast, $scope.user_movies);
			external_internal_data_merger.merge_user_movies_to_external_data(response.data.movie_credits.crew, $scope.user_movies);
			console.log(response.data);
			$scope.person=response.data;
			if($scope.person.birthday){
				$scope.age=getAge($scope.person.birthday, $scope.person.deathday);
			}
			$scope.row_cast=$scope.person.movie_credits.cast;
			_.each($scope.person.movie_credits.crew,function(person){
				temp=_.where(jobs,{i:person.department});
				if(temp.length > 0)	person.job=temp[0].o;
				else	person.job=person.department;
			})
			$scope.row_crew=$scope.person.movie_credits.crew;
			$scope.jobs=_.uniq($scope.person.movie_credits.crew,'department');
			$scope.movies=_.uniq(_.union($scope.row_cast, $scope.row_crew),'id');
			$scope.movies=_.sortBy($scope.movies, 'vote_count').reverse();
			$scope.cover=$scope.movies[0].backdrop_path;
		}, function errorCallback(response) {
			window.location.replace("/not-found");
		});
	}

	rate.get_user_movies()
	.then(function(response){
		console.log(response.data);
		$scope.user_movies = response.data;
		$scope.get_page_data();
	});

	$scope.filter = function(mod,name){
		switch(mod) {
			case 'vote_average':
				$scope.movies=_.sortBy($scope.movies, 'vote_average').reverse();
				break;
			case 'vote_count':
				$scope.movies=_.sortBy($scope.movies, 'vote_count').reverse();
				break;
			case 'release_date':
				$scope.movies=_.sortBy($scope.movies, 'release_date').reverse();
				break;
			case 'title':
				$scope.movies=_.sortBy($scope.movies, 'title');
				break;
			case 'cast':
				$scope.movies=$scope.row_cast;
				console.log($scope.row_cast)
				$scope.filter($scope.active_tab);
				break;
			case 'all':
				$scope.movies=_.uniq(_.union($scope.row_cast, $scope.row_crew),'id');
				$scope.filter($scope.active_tab);
				break;
			default:
				$scope.movies=_.unique(_.where($scope.row_crew,{department:mod}),'id');
				$scope.cast_or_crew=name;
				$scope.filter($scope.active_tab);
		}
		$(".tooltip").hide();
	}
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
		if($scope.current_level == 100) $scope.level_up(101);
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
					if($scope.current_level == 101) $scope.get_watched_movie_number(102);
					else if($scope.current_level==400) $scope.get_watched_movie_number(401);
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
///////////////////////////////////////// SAME PART //////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	/*$scope.paginate = function(page)
	{
		$scope.page = page;
		$scope.get_page_data();
		$scope.scroll_to_top();
	}*/

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
				}else{
					$('#myModal').modal('show');
				}
				if($scope.current_level==400) $scope.get_watched_movie_number(401);    //TUTORIAL CHECK 50 MOVIES
			});
		}else if(rate_code == null){
			rate.un_rate($scope.movies[index].rated_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope.movies[index].rated_id=null;
					$scope.movies[index].rate_code=null;
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




//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// TUTORIAL ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	if(pass.tt_navbar < 50){
		switch(pass.tt_navbar){
			case 0:
				location.hash="tooltip-quickvote";
				break;
			case 1:
				location.hash="tooltip-search";
				break;
			case 2:
				location.hash="tooltip-recommendations";
				break;
			case 3:
				location.hash="tooltip-profile";
				break;
			case 4:
				location.hash="tooltip-percentage";
				break;
		}

		window.addEventListener("hashchange", function(){ 
			console.log(location.hash)
			if(location.hash.indexOf('tooltip-quickvote')>-1){
				$("[data-toggle=popover]").popover('hide');
				$('#quickvote').popover('show');
			}else if(location.hash.indexOf('tooltip-search')>-1){
				console.log("muhaha")
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 1)
				.then(function(response){
					console.log(response);
					$('#search').popover('show');
				});
			}else if(location.hash.indexOf('tooltip-recommendations')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 2)
				.then(function(response){
					console.log(response);
					$('#recommendations').popover('show');
				});
			}else if(location.hash.indexOf('tooltip-profile')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 3)
				.then(function(response){
					console.log(response);
					$('#profile').popover('show');
				});
			}else if(location.hash.indexOf('tooltip-percentage')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 4)
				.then(function(response){
					console.log(response);
					$('#percentage').popover('show');
				});
			}else if(location.hash.indexOf('navbar-tooltips-done')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 50)
				.then(function(response){
					console.log(response);
				});
			}else if(location.hash.indexOf('cancel-tooltips')>-1){
				$("[data-toggle=popover]").popover('hide');
				rate.tt_manipulate('navbar', 100)
				.then(function(response){
					console.log(response);
				});
			}else if(location.hash.indexOf('close-tooltip')>-1){
				$("[data-toggle=popover]").popover('hide');
			}
		}, false);

	}

	if(pass.watched_movie_number < 50){
		$scope.get_watched_movie_number = function(){
			rate.get_watched_movie_number()
			.then(function(response){
				console.log(response);
				$scope.watched_movie_number=response.data;
				$scope.calculate_percentage();
			});
		}

		$scope.watched_movie_number = pass.watched_movie_number;
		$scope.calculate_percentage = function(){
			$scope.percentage = pass.lang=='tr' ? '%'+$scope.watched_movie_number*2 : $scope.watched_movie_number*2+'%';
		}
		$scope.calculate_percentage();
	}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// TUTORIAL ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
});