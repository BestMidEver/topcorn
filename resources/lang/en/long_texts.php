<?php

return [
    'donation' => 'topcorn.io is a project that has survived with the support of the people who loves cinema. Help us to provide you better results and more useful experience.',
    'hint_secondary_language' => 'If there is information that can not be found in the \'Primary Language\', they are going to be filled in with this language. You will also see the reviews which are written in this language and the trailers in this language too.',
    'hint_hover_title' => 'When you hover your mouse cursor over the movie links, you can see the title of the movie in the original language of the movie or in your secondary language. This setting does not affect the search page.',
    'hint_image_quality' => 'You can choose the image quality according to your internet connection. This setting does not affect trailers.',
    'hint_full_screen' => 'This setting reduces the spaces from left and right.',
    'hint_open_new_tab' => 'This setting opens movies, people and users in a new tab.',
    'hint_theme' => 'You can change the background color of the website according to your preference.',
    'hint_pagination' => 'How many movies do you want to see per page in recommendations?',
    'hint_show_crew' => 'Activate this to see the casts of the movies too.',
    'hint_advanced_filter' => 'It gives you advanced information and options on recommendations page.',
    'hint_cover_photo' => 'Choose a movie to use it\'s cover photo as your cover photo.',
    'hint_profile_pic' => 'Choose an actor/actress from your cover movie.',
    'hint_when_air_date' => 'This works when you add a series to your watch later list.',
    'hint_when_watch_together' => 'This works when someone uses Watch Together feature with your profile.',
    'hint_when_recommendation' => 'If someone uses Watch Together with you, you can send movies and series to them via Topcorn.io',
    'home' => array(
      'h1' => 'No time to waste on bad movies!',
      't11' => 'topcorn.io understands your movie taste and recommends movies based on it. Let\'s get started!',
      't12' => 'With topcorn.io it\'s now easy to make the right choice from any kind of movies.',

      'h2' => 'Let\'s get to know each other!',
      't21' => 'The more movies you have, the better we know you. And of course the movie list we will prepare for you will be more accurate.',
      't22' => 'Quick Vote can accelerate this process, you can be buried in the movies right away.',

      'h3' => 'Special films for you, they wait for you!',
      't31' => 'topcorn.io has been specially developed for conscious moviegoers.',
      't32' => 'To know you better, vote the movies that you have watched and leave the rest to topcorn.io.',

      'h4' => 'Completely free!',
      't41' => 'What are you waiting for?',
    ),
    'notifications' => array(
      'air_date' => "<a ng-href=\"series/{{notification.data[0].movie_id}}\" class=\"text-dark\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"{{notification.data[0].original_title}} {{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}}\">{{notification.data[0].title}}</a> new episode air date is defined. Date: {{notification.data[0].next_episode_air_date.substring(0, 10)}} ({{notification.data[0].day_difference_next}} {{notification.data[0].day_difference_next>1?'days':'day'}} later)",
      'airing_today' => "<a ng-href=\"series/{{notification.data[0].movie_id}}\" class=\"text-dark\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"{{notification.data[0].original_title}} {{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}}\">{{notification.data[0].title}}</a> is airing today. <small>Created at: {{notification.data[0].created_at}}</small>",
      'like' => "{{notification.total}} {{notification.total>1?'users':'user'}} liked your <a ng-href=\"{{notification.data[0].review_mode==1?'movie':'series'}}/{{notification.data[0].movie_id}}\" class=\"text-dark\" ng-if=\"notification.data[0].notification_mode==0\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"{{notification.data[0].original_title}} {{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}}\">{{notification.data[0].title}} review</a><a ng-href=\"list/{{notification.data[0].list_id}}\" class=\"text-dark\" ng-if=\"notification.data[0].notification_mode==1\">{{notification.data[0].title}} list</a>. {{notification.total>1?'Users':'User'}}: <span ng-repeat=\"item in notification.data\"><span ng-hide=\"&dollar;index==0\">, </span><a ng-href=\"profile/{{item.user_id}}\" class=\"text-dark\">{{item.user_name}}</a></span>",
      'sent_movie' => "{{notification.total}} {{notification.total>1?'users':'user'}} recommended <a ng-href=\"{{notification.data[0].notification_mode==4?'movie':'series'}}/{{notification.data[0].movie_id}}\" class=\"text-dark\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"{{notification.data[0].original_title}} {{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}}\">{{notification.data[0].title}}</a>. {{notification.total>1?'Users':'User'}}: <span ng-repeat=\"item in notification.data\"><span ng-hide=\"&dollar;index==0\">, </span>{{item.user_name}}</span>",
      'watch_together' => "<a ng-href=\"profile/{{notification.data[0].user_id}}\" class=\"text-dark\">{{notification.data[0].user_name}}</a> \"watch together\" with you. You can use share button to recommend movies and series to this user.",
    )
];