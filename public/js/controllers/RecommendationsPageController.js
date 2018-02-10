MyApp.controller('RecommendationsPageController', function($scope, $http, $timeout, $anchorScroll, rate)
{		
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// SCROLL TO TOP ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.scroll_to_top=function(){
		$anchorScroll.yOffset = 55;
		$anchorScroll('scroll_top_point')
	}	
	$scope.scroll_to_filter=function(){
		$anchorScroll.yOffset = 10;
		$anchorScroll('filter')
	}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// SCROLL TO TOP ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// ANGULAR SLIDER AND FILTER /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.slider={};
	$scope.slider = {
		minValue: parseInt(pass.constants_angular_slider_min_value),
		maxValue: parseInt(pass.constants_angular_slider_max_value),
		options: {
			floor: parseInt(pass.constants_angular_slider_min_value),
			ceil: parseInt(pass.constants_angular_slider_max_value)
		}
	};
    $scope.drawslider=function(){
    	$scope.refreshSlider();
    }
	$scope.refreshSlider = function () {
	    $timeout(function () {
	        $scope.$broadcast('rzSliderForceRender');
	    });
	};

	$scope.languages=_.sortBy(languages, 'o');
	$scope.languages.pop();
	$scope.genres=_.sortBy(genres, 'o');
	console.log($scope.genres, genres)
	$scope.genres.pop();
//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// ANGULAR SLIDER AND FILTER /////////////////////////////
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




//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// RETRIEVE MOVIECARD DATA //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.constants_image_thumb_nail = pass.constants_image_thumb_nail;
   	var f_users = [pass.user_id];
	$scope.user_id = pass.user_id;
    $scope.f_lang_model = [];
    $scope.f_genre_model = [];
	$scope.active_tab= pass.level < 700 ? 'top_rated' : 'pemosu';

    $scope.get_page_data = function()
    {
    	var f_lang = [];
        var temp = _.pairs($scope.f_lang_model);
        for (var i = 0; i < temp.length; i++) {
        	if(temp[i][1]) f_lang.push( temp[i][0] );
        }
        var f_genre = [];
        temp = _.pairs($scope.f_genre_model);
        for (var i = 0; i < temp.length; i++) {
        	if(temp[i][1]) f_genre.push( temp[i][0].split("_")[1] );
        }
		var data = {
			"f_users": f_users,
			"f_lang": f_lang,
			"f_genre": f_genre,
			"f_min": $scope.slider.minValue,
			"f_max": $scope.slider.maxValue
		}

		rate.get_recommendations_page_data($scope.active_tab, data, $scope.page)
		.then(function(response){
			console.log(response)
			$scope.movies=response.data.data;
			$scope.pagination=response.data.last_page;
			$scope.current_page=response.data.current_page;
			$scope.from=response.data.from;
			$scope.to=response.data.to;
			$scope.in=response.data.total;
			$(".tooltip").hide();
		});
	}

    $scope.get_first_page_data = function()
    {
    	$scope.page=1;
    	$scope.get_page_data();
	}
	$scope.get_first_page_data();
	$scope.slider.options.onEnd = $scope.get_first_page_data;

	$scope.reset_add_person_input = function()
	{
		$scope.search_text='';
		$scope.search_users();
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
////////////////////////////////// ADD USERS TO WATCH TOGETHER ///////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
	$scope.page_search = 1;
	$scope.party_members = [];
	
	$scope.get_last_parties = function()
	{
		rate.get_last_parties($scope.page_search)
		.then(function(response){
			console.log(response);
			$scope.users=response.data.data;
			$scope.pagination_search=response.data.last_page;
			$scope.current_page_search=response.data.current_page;
			$scope.is_search=false;
		});
	}
	$scope.get_last_parties();
	
	$scope.search_users = function()
	{
		$scope.page_search=1;
		if($scope.search_text.length>0){
			rate.search_users($scope.search_text, $scope.page_search)
			.then(function(response){
				console.log(response.data);
				$scope.users=response.data.data;
				$scope.pagination_search=response.data.last_page;
				$scope.current_page_search=response.data.current_page;
				$scope.is_search=true;
			});
		}else{
			$scope.get_last_parties();
		}
	}

	$scope.add_to_history = function(user_id)
	{
		rate.add_to_history(user_id)
		.then(function(response){
			console.log(response.data);
		});
	}

	$scope.add_to_party = function(user)
	{
		if(user.user_id==pass.user_id) return;
		$scope.party_members=_.uniq( _.union($scope.party_members, [user]),'user_id' );
		f_users=_.union(_.pluck($scope.party_members, 'user_id'), [pass.user_id]);
		$scope.get_page_data();
		$scope.add_to_history(user.user_id);
	}
	
	if(pass.with_user_id != ''){
		$scope.add_to_party({'user_id':parseInt(pass.with_user_id), 'name':pass.with_user_name});
	}

	$scope.remove_from_party = function(user_id)
	{
		$scope.party_members = _.filter($scope.party_members, function(item) {
		    return item.user_id !== user_id
		});
		f_users=_.union(_.pluck($scope.party_members, 'user_id'), [pass.user_id]);
		$scope.get_page_data();
	}

	$scope.remove_from_history = function(user_id){
		rate.remove_from_history(user_id)
		.then(function(response){
			console.log(response.data);
			$scope.get_last_parties();
		});
	}
//////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// ADD USERS TO WATCH TOGETHER ///////////////////////////
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
					if($scope.current_level == 101) $scope.get_watched_movie_number(102);		//TUTORIAL QUICK RATE
					else if($scope.current_level==400) $scope.get_watched_movie_number(401);		//TUTORIAL CHECK 50 MOVIES
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
				if($scope.current_level==301) $scope.get_watched_movie_number(302);		//TUTORIAL RECOMMENDATIONS
				else if($scope.current_level==400) $scope.get_watched_movie_number(401);		//TUTORIAL CHECK 50 MOVIES
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
});