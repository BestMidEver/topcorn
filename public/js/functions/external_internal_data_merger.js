MyApp.factory('external_internal_data_merger', function($http) {



    merge_user_movies_to_external_data = function(external_data, user_movies) 
    {
		var temp;
		for (var i = 0; i < external_data.length; i++) {
			temp = _.where(user_movies, {movie_id: external_data[i].id});
			if(temp.length>0){
				external_data[i].rated_id=temp[0].rated_id;
				external_data[i].rate_code=temp[0].rate_code;
				external_data[i].later_id=temp[0].later_id;
				external_data[i].ban_id=temp[0].ban_id;
			}else{
				external_data[i].rated_id=null;
				external_data[i].rate_code=null;
				external_data[i].later_id=null;
				external_data[i].ban_id=null;
			}
		}
    };


    return {
    	merge_user_movies_to_external_data: merge_user_movies_to_external_data,
    };
})