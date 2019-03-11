<?php

return [
    'donation' => 'A topcorn.io egy olyan projekt, ami a filmkedvelők segítségével működik.  Támogass te is minket, hogy jobb eredményeket és hasznos élményt nyújtson.',
    'hint_secondary_language' => 'Ha olyan információ áll rendelkezésre, amely nem található az \'anyanyelvben\', akkor a másodlagos nyelven lesz kitöltve. A másodlagos nyelven írt véleményeket és filmelőzeteseket is látni fogod.',
    'hint_hover_title' => 'Ha az egérmutatót a filmlinkek fölé helyezed, akkor a film eredeti vagy a másodlagos nyelvű címét láthatod. Ez a beállítás nem érinti a keresési oldalt.',
    'hint_image_quality' => 'Kiválaszthatod a képminőséget az internetkapcsolatnak megfelelően. Ez a beállítás nem érinti a filmelőzeteseket.',
    'hint_full_screen' => 'Csökkentheted az oldal jobb és bal szélén lévő helyet.',
    'hint_open_new_tab' => 'A film, az emberek és a felhasználók megnyitása új lapon.',
    'hint_theme' => 'A weboldal háttérszíneit a Te preferenciád szerint módosíthatod.',
    'hint_pagination' => 'Az ajánlások oldalán megjelenő filmek száma.',
    'hint_show_crew' => 'A film oldalán a szereplőkön kívül a stáb összes tagját is mutassa.',
    'hint_advanced_filter' => 'Az ajánlások oldalon még több részletet és opciót kínál számodra.',
    'hint_cover_photo' => 'Válasssz borítóképet a kedvenc filmjeid közül.',   
    'hint_profile_pic' => 'Profilképként beállíthatod a Facebook profilképedet vagy egy színész fotóját.',
    'hint_when_user_interaction' => 'This works when you add a series to your watch later list.',////////////////////
    'hint_when_automatic_notification' => 'This works when someone uses Watch Together feature with your profile.',/////////////////////////
    'hint_when_system_change' => 'If someone uses Watch Together with you, you can send movies and series to them via Topcorn.io',////////////////
    'home' => array(
      'h1' => 'Túl sok a jó film ahhoz, hogy az idődet rossz filmekre pazarold.',
      't11' => 'A topcorn.io megismeri az ízlésedet és ennek megfelelően ajánl újabb filmeket számodra. Lássunk neki!',
      't12' => 'A topcorn.io segítségével most már könnyű választani bármilyen típusú film közül.',

      'h2' => 'Ismerjük meg egymást!',
      't21' => 'Minél több filmet értékelsz, a topcorn.io annál jobban megismer és a neked készült lista is annál személyre szabottabb lesz.',
      't22' => 'A gyors szavazás felgyorsíthatja ezt a folyamatot, és máris elkezdheted a búvárkodást a filmek tengerében.',

      'h3' => 'Különleges filmek várnak rád!',
      't31' => 'A topcorn.io kifejezetten a tudatos filmrajongók számára lett kifejlesztve.',
      't32' => 'Hogy jobban megismerjünk, szavazz a filmekre, amelyeket megnéztél, a többit pedig hagyd topcorn.io-ra.',

      'h4' => 'Teljesen ingyenes!',
      't41' => 'Mire vársz?',

      'description' => 'Learn what to watch tonight, based on your taste. Filter movies with original language, release year, genre and vote count. Completely free',///////////////
    ),
    'notifications' => array(
      'air_date' => "<a ng-href=\"series/{{notification.data[0].movie_id}}\" class=\"text-dark\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"{{notification.data[0].original_title}} {{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}}\">{{notification.data[0].title}}</a> új epizód megjelenési dátuma meghatározott. Dátum: {{notification.data[0].next_episode_air_date.substring(0, 10)}} ({{notification.data[0].day_difference_next}} nap múlva)",
      'airing_today' => "<a ng-href=\"series/{{notification.data[0].movie_id}}\" class=\"text-dark\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"{{notification.data[0].original_title}} {{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}}\">{{notification.data[0].title}}</a> új epizódja megjelenik ma. <small class=\"text-muted scrollmenu\">Értesítés létrehozva: {{notification.data[0].created_at}}</small>",
      'like' => "{{notification.total}} felhasználónak <a ng-href=\"{{notification.data[0].review_mode==1?'movie':'series'}}/{{notification.data[0].movie_id}}\" class=\"text-dark\" ng-if=\"notification.data[0].notification_mode==0\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"{{notification.data[0].original_title}} {{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}}\">{{notification.data[0].title}} véleményed</a><a ng-href=\"list/{{notification.data[0].list_id}}\" class=\"text-dark\" ng-if=\"notification.data[0].notification_mode==1\">{{notification.data[0].title}} listád</a> tetszett. Felhasználó: <span ng-repeat=\"item in notification.data\"><span ng-hide=\"&dollar;index==0\">, </span><a ng-href=\"profile/{{item.user_id}}\" class=\"text-dark\">{{item.user_name}}</a></span>",
      'sent_movie' => "{{notification.total}} felhasználó <a ng-href=\"{{notification.data[0].notification_mode==4?'movie':'series'}}/{{notification.data[0].movie_id}}\" class=\"text-dark\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"{{notification.data[0].original_title}} {{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}}\">{{notification.data[0].title}}</a> ajánlotta neked. Felhasználó: <span ng-repeat=\"item in notification.data\"><span ng-hide=\"&dollar;index==0\">, </span>{{item.user_name}}</span>",
      'watch_together' => "<a ng-href=\"profile/{{notification.data[0].user_id}}\" class=\"text-dark\">{{notification.data[0].user_name}}</a>  használta a \"Nézzük meg együtt!\" veled. A megosztás gombbal ajánlhatsz ennek a felhasználónak filmeket és sorozatokat.",
      'started_following' => "<a ng-href=\"profile/{{notification.data[0].user_id}}\" class=\"text-dark\">{{notification.data[0].user_name}}</a> started following you.",///////////////
    ),
    'person' => array(
      'description' => 'Movies, tv series, images and more...',////////////////////////
    ),
    'profile' => array(
      'description' => 'Favorite movies, tv series that are seen, reviews, custom lists and more...',/////////////////
    )
]; 