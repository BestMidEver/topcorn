MyApp.controller('DonationPageController', function($scope, $http, rate)
{
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
//////////////////////////////////////// TUTORIAL ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	if(pass.level < 700){
		window.addEventListener("hashchange", function(){ 
			//$scope.$apply();
			console.log(location.hash)
			switch(location.hash){
				case '#riza':
					$('#bir').popover('hide')
					break;
				case '#gabar':
					$('#bir').popover('show')
					break;
				default:
					window.location.replace("/not-found");
			}
		}, false);














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
		}else if(pass.level == 300 && window.location.href.indexOf("topcorn.io/recommendations") > -1){
			rate.level_manipulate(301)
			.then(function(response){
				console.log(response);
				$scope.current_level = response.data;
				$scope.show_tutorial();
			});
		}else if(pass.level == 500 && window.location.href.indexOf("topcorn.io/account") > -1){
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
				else if(lvl==302 && response.data>1) $scope.level_up(lvl);
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
			}else if($scope.current_level==300 && window.location.href.indexOf("topcorn.io/recommendations") > -1){
				rate.level_manipulate(301)
				.then(function(response){
					console.log(response);
					$scope.current_level = response.data;
				});
			}else if($scope.current_level==400 && window.location.href.indexOf("topcorn.io/account") > -1){
				rate.level_manipulate(401)
				.then(function(response){
					console.log(response);
					$scope.current_level = response.data;
				});
			}
		}

		$scope.level_up = function(lvl){
			if(lvl <= $scope.current_level){
				$scope.show_previous_tutorial='';
			}else{
				if(lvl == 1 || lvl == 700)$('#tutorial').modal('hide');
				rate.level_manipulate(lvl)
				.then(function(response){
					console.log(response);
					$scope.current_level = response.data;
					$scope.level_check();
					if($scope.current_level!=1 && $scope.current_level!=100 && $scope.current_level!=200 
						&& $scope.current_level!=300 && $scope.current_level!=400 && $scope.current_level!=500 
						&& $scope.current_level!=600 && $scope.current_level!=700){
						$scope.show_tutorial();
					}
				});
			}
		}

		$scope.show_previous = function(which){
			$scope.show_previous_tutorial=which;
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// TUTORIAL ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
});