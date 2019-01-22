MyApp.controller('PersonPageController', function($scope, $http, rate, external_internal_data_merger)
{
//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// RETRIEVE MOVIECARD DATA //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.get_page_data = function()
	{
		$http({
			method: 'GET',
			url: 'https://api.themoviedb.org/3/person/'+pass.personid+'?api_key='+pass.api_key+'&language='+pass.lang+'&append_to_response=movie_credits,tv_credits'
		}).then(function successCallback(response) {
			if(pass.is_auth==1){
				external_internal_data_merger.merge_user_movies_to_external_data(response.data.movie_credits.cast, $scope.user_movies);
				external_internal_data_merger.merge_user_movies_to_external_data(response.data.movie_credits.crew, $scope.user_movies)
			}
			console.log(response.data);
			$scope.person=response.data;
			if($scope.person.birthday){
				$scope.age='('+getAge($scope.person.birthday, $scope.person.deathday)+')';
			}else{
				$scope.age='';
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

	if(pass.is_auth==1){
		rate.get_user_movies('movies')
		.then(function(response){
			console.log(response.data);
			$scope.user_movies = response.data;
			$scope.get_page_data();
		});
	}else{
		$scope.get_page_data();
	}

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


	if(pass.is_auth==1){
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
	}


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
});