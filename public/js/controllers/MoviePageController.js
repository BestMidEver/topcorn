MyApp.controller('MoviePageController', function($scope, $http, $sce, $anchorScroll, rate, external_internal_data_merger)
{
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// SCROLL TO TOP ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.scroll_to_top=function(){
		$anchorScroll.yOffset = 58;
		$anchorScroll('accordion');
	}	
	$scope.scroll_to_cast=function(){
		$anchorScroll.yOffset = 10;
		$anchorScroll('cast')
	}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// SCROLL TO TOP ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// RETRIEVE LISTCARD DATA ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$http({
		method: 'GET',
		url: '/api/get_movie_lists/'+pass.movieid,
		headers: {
			'Content-Type': 'application/json',
			'Accept' : 'application/json'
		}
	}).then(function successCallback(response) {
		console.log(response.data)
		$scope.listes=response.data;
	}, function errorCallback(response) {
	});
//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// RETRIEVE LISTCARD DATA ///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////


	if(pass.is_auth == 1){
		$http({
			method: 'GET',
			url: '/api/get_user_movie_record/'+pass.movieid
		}).then(function successCallback(response) {
			console.log('bu', response)
			if(response.data.hasOwnProperty('ban_id')){
				$scope.user_movie_record = response.data;
			}else{
				$scope.user_movie_record = {
					ban_id: null,
					later_id: null,
					movie_id: pass.movieid,
					rate_code: null,
					rated_id: null
				}
			}
			console.log($scope.user_movie_record)
		}, function errorCallback(response) {
		});
	}

	$scope.temp={};
	$http({
		method: 'GET',
		url: 'https://api.themoviedb.org/3/movie/'+pass.movieid+'?api_key='+pass.api_key+'&language='+pass.lang+'&append_to_response=credits%2Cvideos%2Creviews%2Crecommendations%2Csimilar'
	}).then(function successCallback(response) {
		desireddata=response.data;
		console.log('desired_data',desireddata);
		if(desireddata.belongs_to_collection != null){
			$http({
				method: 'GET',
				url: 'https://api.themoviedb.org/3/collection/'+desireddata.belongs_to_collection.id+'?api_key='+pass.api_key+'&language='+pass.lang
			}).then(function successCallback(response) {
				$scope.collection=_.sortBy(response.data.parts, 'release_date');
				console.log('collection', $scope.collection);
			}, function errorCallback(response) {
			});
		}
		$http({
			method: 'GET',
			url: 'https://api.themoviedb.org/3/movie/'+pass.movieid+'?api_key='+pass.api_key+'&language='+pass.secondary_lang+'&append_to_response=videos%2Creviews'
		}).then(function successCallback(response) {
			secondarydata=response.data;
			console.log('secondary_data',secondarydata);
			$scope.merge_movie_data(desireddata, secondarydata);
			$scope.prepeare_movie_data(desireddata);
		}, function errorCallback(response) {
			console.log('1')
			window.location.replace("/not-found");
		});
	}, function errorCallback(response) {
			console.log('1')
		window.location.replace("/not-found");
	});

	$scope.merge_movie_data = function(desireddata, secondarydata){
		if(!desireddata.backdrop_path)	desireddata.backdrop_path=secondarydata.backdrop_path;
		if(!desireddata.overview) desireddata.overview=secondarydata.overview;
		if(!desireddata.poster_path)	desireddata.poster_path=secondarydata.poster_path;
		if(pass.secondary_lang!=pass.lang)	desireddata.reviews.results=_.union(desireddata.reviews.results, secondarydata.reviews.results);
		if(!desireddata.tagline)	desireddata.tagline=secondarydata.tagline;
		if(pass.secondary_lang!=pass.lang)	desireddata.videos.results=_.union(desireddata.videos.results, secondarydata.videos.results);
		if(desireddata.runtime < 1) desireddata.runtime=secondarydata.runtime;
		if(desireddata.budget < 1) desireddata.budget=secondarydata.budget;
		if(desireddata.revenue < 1) desireddata.revenue=secondarydata.revenue;
		if(desireddata.homepage == "") desireddata.homepage=secondarydata.homepage;
	}
	$scope.prepeare_movie_data = function(movie){
		$scope.movie=movie;
		if(!$scope.movie.backdrop_path)	$scope.movie.backdrop_path=$scope.movie.poster_path;
		if($scope.movie.videos.results.length>0){
			$scope.trailerurl=$sce.trustAsResourceUrl('https://www.youtube.com/embed/'+$scope.movie.videos.results[0].key);
			console.log($scope.trailerurl + ':D')
		}
		$scope.directors=_.where($scope.movie.credits.crew, {department:'Directing',job:"Director"});
		$scope.writers=_.filter($scope.movie.credits.crew, function(crew){
			return crew.job == 'Writer' || crew.job == 'Screenplay' || crew.job == 'Novel' || crew.job == 'Author';
		});
		_.each($scope.writers, function(writer){
			temp=_.where(jobs,{i:writer.job});
			if(temp.length > 0)writer.job=temp[0].o;
		});
		if($scope.movie.title != secondarydata.title && $scope.movie.original_title != secondarydata.title) $scope.secondary_title=secondarydata.title;
		$scope.secondary_language=_.where(languages,{i:pass.secondary_lang})[0].o;
		$scope.fancyruntime={"hour":parseInt($scope.movie.runtime/60),"minute":$scope.movie.runtime%60};
		$scope.fancybudget=$scope.movie.budget.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		$scope.fancyrevenue=$scope.movie.revenue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		_.each($scope.movie.reviews.results, function(review){
			review.content=review.content.replace(/(<([^>]+)>)/ig , "").replace(/\r\n/g , "<br>");
			if(review.content.length>500){
				review.url=review.content.replace(/<br>/g , " ").substring(0, 500)+'...';
				review.id='long';
			}else{
				review.url=review.content;
				review.id='short';
			}
		});
		temp=_.where(languages,{i:$scope.movie.original_language});
		if(temp.length > 0)$scope.movie.original_language=temp[0].o;
		console.log(countries)
		_.each($scope.movie.production_countries, function(t){
			temp=_.where(countries,{i:t.iso_3166_1});
			if(temp.length > 0)t.name=temp[0].o;
		})
		rate.get_user_movies('movies')
		.then(function(response){
			console.log(response.data);
			$scope.user_movies = response.data;
			$scope.set_recommendations();
		});
	}

	$scope.current_trailer = 0;
	$scope.previous_trailer = function(){
		$scope.current_trailer--;
		$scope.trailerurl=$sce.trustAsResourceUrl('https://www.youtube.com/embed/'+$scope.movie.videos.results[$scope.current_trailer].key);
	}
	$scope.next_trailer = function(){
		$scope.current_trailer++;
		$scope.trailerurl=$sce.trustAsResourceUrl('https://www.youtube.com/embed/'+$scope.movie.videos.results[$scope.current_trailer].key);
	}

	$scope.page_variables={};
	$scope.page_variables.active_tab_3 = 0;
	$scope.set_recommendations = function(){
		if($scope.page_variables.active_tab_3 == 0){
			external_internal_data_merger.merge_user_movies_to_external_data($scope.movie.recommendations.results, $scope.user_movies);
			$scope.similar_movies=$scope.movie.recommendations.results;
		}else{
			external_internal_data_merger.merge_user_movies_to_external_data($scope.movie.similar.results, $scope.user_movies);
			$scope.similar_movies=$scope.movie.similar.results;
		}
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


	if(pass.is_auth==1){
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SAME PART(MOVIES) //////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
		$scope.this_votemodal=function()
		{
			$('#this_movie_modal').modal('show');
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

		$scope.this_later=function()
		{
			if($scope.user_movie_record.later_id == null){
				rate.add_later($scope.user_movie_record.movie_id)
				.then(function(response){
					console.log(response);
					if(response.status == 201){
						$scope.user_movie_record.later_id=response.data.data.later_id;
					}
				});
			}else{
				rate.un_later($scope.user_movie_record.later_id)
				.then(function(response){
					console.log(response);
					if(response.status == 204){
						$scope.user_movie_record.later_id=null;
					}
				});
			}
		};
		
		$scope.this_rate=function(rate_code)
		{
			$('#this_movie_modal').modal('hide');
			if(rate_code != null){
				rate.add_rate($scope.user_movie_record.movie_id, rate_code)
				.then(function(response){
					console.log(response);
					if(response.status == 201){
						$scope.user_movie_record.rated_id=response.data.data.rated_id;
						$scope.user_movie_record.rate_code=response.data.data.rate;
						if(pass.tt_navbar < 100) $scope.get_watched_movie_number();
					}
				});
			}else if(rate_code == null){
				rate.un_rate($scope.user_movie_record.rated_id)
				.then(function(response){
					console.log(response);
					if(response.status == 204){
						$scope.user_movie_record.rated_id=null;
						$scope.user_movie_record.rate_code=null;
						if(pass.tt_navbar < 100) $scope.get_watched_movie_number();
					}
				});
			}
		};

		$scope.this_ban=function()
		{
			if($scope.user_movie_record.ban_id == null){
				rate.add_ban($scope.user_movie_record.movie_id)
				.then(function(response){
					console.log(response);
					if(response.status == 201){
						$scope.user_movie_record.ban_id=response.data.data.ban_id;
					}
				});
			}else{
				rate.un_ban($scope.user_movie_record.ban_id)
				.then(function(response){
					console.log(response);
					if(response.status == 204){
						$scope.user_movie_record.ban_id=null;
					}
				});
			}
		};

		$scope.votemodal=function(index, movie)
		{
			$scope.modalmovie=movie;
			$scope.modalmovie.index=index;
			$('#myModal').modal('show');
		};

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
					}
					if(pass.watched_movie_number<50) $scope.get_watched_movie_number();
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
					}
					if(pass.watched_movie_number<50) $scope.get_watched_movie_number();
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
	//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SAME PART(MOVIES) //////////////////////////////////
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