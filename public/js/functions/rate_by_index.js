MyApp.factory('rate', function($http) {



    get_quick_rate = function(lang) 
    {
        return $http({
			method: 'GET',
			url: pass.constants_domain + '/api/get_quick_rate/'+lang,
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
			url: pass.constants_domain + '/api/laters',
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



    un_later = function(record_id) 
    {
        return $http({
			method: 'DELETE',
			url: pass.constants_domain + '/api/laters/'+record_id,
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
			url: pass.constants_domain + '/api/rateds',
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




    un_rate = function(record_id) 
    {
        return $http({
			method: 'DELETE',
			url: pass.constants_domain + '/api/rateds/'+record_id,
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
			url: pass.constants_domain + '/api/bans',
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



    un_ban = function(record_id) 
    {
        return $http({
			method: 'DELETE',
			url: pass.constants_domain + '/api/bans/'+record_id,
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
			url: pass.constants_domain + '/api/get_last_parties?page='+page,
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
			url: pass.constants_domain + '/api/add_to_parties/'+user_id,
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
			url: pass.constants_domain + '/api/remove_from_parties/'+user_id,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    get_recommendations_page_data = function(tab, data, page) 
    {
    	if(tab != 'pemosu') var route = 'get_top_rateds/'+tab;
    	else var route = 'get_pemosu';
        return $http({
			method: 'POST',
			url: pass.constants_domain + '/api/'+route+'?page='+page,
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



    get_user_movies = function() 
    {
		return $http({
			method: 'GET',
			url: pass.constants_domain + '/api/get_pluck_id'
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    search_movies = function(constants_api_key, lang, temp, page) 
    {
		return $http({
			method: 'GET',
			url: 'https://api.themoviedb.org/3/search/movie?api_key='+constants_api_key+'&language='+lang+'&query='+temp+'&page='+page+'&include_adult=false',
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
			url: pass.constants_domain + '/api/search_users/'+search_text+'?page='+page,
			headers: {
				'Content-Type': 'application/json',
				'Accept' : 'application/json'
			},
		}).then(function successCallback(response) {
			return response;
		}, function errorCallback(response) {
		});
    }



    return {
    	get_quick_rate: get_quick_rate,
    	add_later: add_later,
    	un_later: un_later,
    	add_rate: add_rate,
    	un_rate: un_rate,
    	add_ban: add_ban,
    	un_ban: un_ban,
    	get_last_parties: get_last_parties,
    	add_to_history: add_to_history,
    	remove_from_history: remove_from_history,
    	get_recommendations_page_data: get_recommendations_page_data,
    	get_user_movies: get_user_movies,
    	search_movies: search_movies,
    	search_people: search_people,
    	search_users: search_users,
    };
})