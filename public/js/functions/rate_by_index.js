MyApp.factory('rate', function($http) {



    get_quick_rate = function(lang) 
    {
        return $http({
			method: 'GET',
			url: '/api/get_quick_rate/'+lang,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    };



    get_watched_movie_number = function() 
    {
        return $http({
			method: 'GET',
			url: '/api/get_watched_movie_number/',
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    };



    add_later = function(movie_id) 
    {
        return $http({
			method: 'POST',
			url: '/api/laters',
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
			data: {"movie_id":movie_id}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    };



    series_add_later = function(series_id) 
    {
        return $http({
			method: 'POST',
			url: '/api/series_laters',
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
			data: {"series_id":series_id}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    };



    un_later = function(record_id) 
    {
        return $http({
			method: 'DELETE',
			url: '/api/laters/'+record_id,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    series_un_later = function(record_id) 
    {
        return $http({
			method: 'DELETE',
			url: '/api/series_laters/'+record_id,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    add_rate = function(movie_id, rate_code) 
    {
        return $http({
			method: 'POST',
			url: '/api/rateds',
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
			data: {
				"movie_id":movie_id,
				"rate":rate_code
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    series_add_rate = function(series_id, rate_code) 
    {
        return $http({
			method: 'POST',
			url: '/api/series_rateds',
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
			data: {
				"series_id":series_id,
				"rate":rate_code
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }




    un_rate = function(record_id) 
    {
        return $http({
			method: 'DELETE',
			url: '/api/rateds/'+record_id,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }




    series_un_rate = function(record_id) 
    {
        return $http({
			method: 'DELETE',
			url: '/api/series_rateds/'+record_id,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    add_ban = function(movie_id) 
    {
        return $http({
			method: 'POST',
			url: '/api/bans',
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
			data: {"movie_id":movie_id}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    series_add_ban = function(series_id) 
    {
        return $http({
			method: 'POST',
			url: '/api/series_bans',
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
			data: {"series_id":series_id}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    un_ban = function(record_id) 
    {
        return $http({
			method: 'DELETE',
			url: '/api/bans/'+record_id,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    series_un_ban = function(record_id) 
    {
        return $http({
			method: 'DELETE',
			url: '/api/series_bans/'+record_id,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    series_add_last_seen = function(series_id, last_seen_season, last_seen_episode, air_date, next_season, next_episode) 
    {
        return $http({
			method: 'POST',
			url: '/api/series_seens',
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
			data: {
				"series_id":series_id,
				"last_seen_season":last_seen_season,
				"last_seen_episode":last_seen_episode,
				"air_date":air_date,
				"next_season":next_season,
				"next_episode":next_episode
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    series_un_last_seen = function(record_id) 
    {
        return $http({
			method: 'DELETE',
			url: '/api/series_seens/'+record_id,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    get_last_parties = function(page) 
    {
        return $http({
			method: 'GET',
			url: '/api/get_last_parties?page='+page,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    add_to_history = function(user_id) 
    {
        return $http({
			method: 'GET',
			url: '/api/add_to_parties/'+user_id,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    remove_from_history = function(user_id) 
    {
        return $http({
			method: 'GET',
			url: '/api/remove_from_parties/'+user_id,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    get_recommendations_page_data = function(tab, data, page, mode) 
    {
    	if(tab != 'pemosu' && tab != 'mood_pick'){
    		if(mode=='movies') route = 'get_top_rateds';
    		else route = 'get_series_top_rateds';
    	}else if(tab != 'mood_pick'){
    		if(mode=='movies') route = 'get_pemosu';
    		else route = 'get_series_pemosu';
    	}else{
    		if(mode=='movies') route = 'get_momosu';
    		else route = 'get_series_momosu'
        }
        return $http({
			method: 'POST',
			url: '/api/'+route+'?page='+page,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
			data: data
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    get_user_movies = function(mode) 
    {
		return $http({
			method: 'GET',
			url: '/api/get_pluck_id/'+mode
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    search_movies = function(constants_api_key, lang, temp, page, mode) 
    {
    	temp_2 = mode=='movies'?'movie':'tv';
		return $http({
			method: 'GET',
			url: 'https://api.themoviedb.org/3/search/'+temp_2+'?api_key='+constants_api_key+'&language='+lang+'&query='+temp+'&page='+page+'&include_adult=false',
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    search_series = function(constants_api_key, lang, temp, page) 
    {
		return $http({
			method: 'GET',
			url: 'https://api.themoviedb.org/3/search/tv?api_key='+constants_api_key+'&language='+lang+'&query='+temp+'&page='+page+'&include_adult=false',
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    search_people = function(constants_api_key, lang, temp, page) 
    {
		return $http({
			method: 'GET',
			url: 'https://api.themoviedb.org/3/search/person?api_key='+constants_api_key+'&language='+lang+'&query='+temp+'&page='+page+'&include_adult=false',
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    search_users = function(search_text, page) 
    {
        return $http({
			method: 'GET',
			url: '/api/search_users/'+search_text+'?page='+page,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    search_listes = function(search_text, page) 
    {
        return $http({
			method: 'GET',
			url: '/api/search_lists/'+search_text+'?page='+page,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }




    tt_manipulate = function(column, level) 
    {
        return $http({
			method: 'POST',
			url: '/api/tooltip',
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
			data: {
				"column":column,
				"level":level
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    };



    suck_movie = function(movie_id) 
    {
        return $http({
			method: 'GET',
			url: '/api/suck_movie/'+movie_id,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    get_list_data = function(list_mode, profile_user_id) 
    {
        return $http({
			method: 'GET',
			url: '/api/get_lists/'+list_mode+'/'+profile_user_id,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    get_profile_data = function(active_tab, profile_user_id, page, mode) 
    {
    	temp = active_tab.split('get_');
    	active_tab = (mode=='series'?'get_series_':'get_')+temp[1];
    	console.log(active_tab, temp,mode)
        return $http({
			method: 'GET',
			url: '/api/'+active_tab+'/'+profile_user_id+'/'+pass.lang+'?page='+page,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			}
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }




    return {
    	get_quick_rate: get_quick_rate,
    	get_watched_movie_number: get_watched_movie_number,
    	add_later: add_later,
    	series_add_later: series_add_later,
    	un_later: un_later,
    	series_un_later: series_un_later,
    	add_rate: add_rate,
    	series_add_rate: series_add_rate,
    	un_rate: un_rate,
    	series_un_rate: series_un_rate,
    	add_ban: add_ban,
    	series_add_ban: series_add_ban,
    	un_ban: un_ban,
    	series_un_ban: series_un_ban,
    	series_add_last_seen: series_add_last_seen,
    	series_un_last_seen: series_un_last_seen,
    	get_last_parties: get_last_parties,
    	add_to_history: add_to_history,
    	remove_from_history: remove_from_history,
    	get_recommendations_page_data: get_recommendations_page_data,
    	get_user_movies: get_user_movies,
    	search_movies: search_movies, 
    	search_series: search_series, 
    	search_people: search_people,
    	search_users: search_users,
    	search_listes: search_listes,
    	suck_movie: suck_movie,
    	get_list_data: get_list_data,//Kullanıcının listelerini getirir.
    	get_profile_data: get_profile_data,//Kullanıcının izlediği/oyladığı filmleri getirir.
    	tt_manipulate: tt_manipulate,
    };
})