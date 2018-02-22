MyApp.controller('MoviePageController', function($scope, $http, $sce, $anchorScroll, rate)
{
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// SCROLL TO TOP ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.scroll_to_top=function(){
		$anchorScroll.yOffset = 10;
		$anchorScroll('accordion');
	}	
	$scope.scroll_to_cast=function(){
		$anchorScroll.yOffset = 10;
		$anchorScroll('cast')
	}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// SCROLL TO TOP ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////



	if(pass.is_auth == 1){
		$http({
			method: 'GET',
			url: '/api/get_user_movie_record/'+pass.movieid
		}).then(function successCallback(response) {
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
		url: 'https://api.themoviedb.org/3/movie/'+pass.movieid+'?api_key='+pass.api_key+'&language='+pass.lang+'&append_to_response=credits%2Cvideos%2Creviews'
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
			window.location.replace("/not-found");
		});
	}, function errorCallback(response) {
		window.location.replace("/not-found");
	});

	$http({
		method: 'GET',
		url: 'https://api.themoviedb.org/3/movie/popular?api_key='+pass.api_key+'&language=tr&page=7'
	}).then(function successCallback(response) {
		$scope.movies=response.data.results;
	}, function errorCallback(response) {
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
				return 'btn-outline-secondary addlarter';
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
				}else{
					$('#this_movie_modal').modal('show');
				}
				if($scope.current_level==400) $scope.get_watched_movie_number(401); //TUTORIAL CHECK 50 MOVIES
			});
		}else if(rate_code == null){
			rate.un_rate($scope.user_movie_record.rated_id)
			.then(function(response){
				console.log(response);
				if(response.status == 204){
					$scope.user_movie_record.rated_id=null;
					$scope.user_movie_record.rate_code=null;
				}else{
					$('#this_movie_modal').modal('show');
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
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// SAME PART(MOVIES) //////////////////////////////////
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