MyApp.controller('AccountInterfacePageController', function($scope, $http, rate)
{
	$scope.lang=pass.lang;
	$scope.secondary_lang=pass.secondary_lang;
	$scope.is_save_disabled = true;

	$scope.check_save_disabled = function(){
		console.log($scope.lang, $scope.secondary_lang)
		if(
			(pass.lang != $scope.lang
			|| pass.secondary_lang != $scope.secondary_lang)
		){
			$scope.is_save_disabled = false;
		}else{
			$scope.is_save_disabled = true;
		}
	}
	window.onbeforeunload = function() {
		if(!$scope.is_save_disabled) return ""; //eğer değişiklik yapılmadıysa sayfayı değiştirebilsin.
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
			switch(location.hash){
				case '#tooltip-quickvote':
					$("[data-toggle=popover]").popover('hide');
					$('#quickvote').popover('show');
					break;
				case '#tooltip-search':
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 1)
					.then(function(response){
						console.log(response);
						$('#search').popover('show');
					});
					break;
				case '#tooltip-recommendations':
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 2)
					.then(function(response){
						console.log(response);
						$('#recommendations').popover('show');
					});
					break;
				case '#tooltip-profile':
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 3)
					.then(function(response){
						console.log(response);
						$('#profile').popover('show');
					});
					break;
				case '#tooltip-percentage':
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 4)
					.then(function(response){
						console.log(response);
						$('#percentage').popover('show');
					});
					break;
				case '#navbar-tooltips-done':
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 50)
					.then(function(response){
						console.log(response);
					});
					break;
				case '#cancel-tooltips':
					$("[data-toggle=popover]").popover('hide');
					rate.tt_manipulate('navbar', 100)
					.then(function(response){
						console.log(response);
					});
					break;
				case '#close-tooltip':
					$("[data-toggle=popover]").popover('hide');
					break;
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