<?php

function timeAgo($time) {
    switch ($time[1]) {
        case 'second':
            return $time[0].' '.__("general.time_second");
            break;
        case 'seconds':
            return $time[0].' '.__("general.time_seconds");
            break;
        case 'minute':
            return $time[0].' '.__("general.time_minute");
            break;
        case 'minutes':
            return $time[0].' '.__("general.time_minutes");
            break;
        case 'hour':
            return $time[0].' '.__("general.time_hour");
            break;
        case 'hours':
            return $time[0].' '.__("general.time_hours");
            break;
        case 'day':
            return $time[0].' '.__('general.time_day');
            break;
        case 'days':
            return $time[0].' '.__('general.time_days');
            break;
        case 'week':
            return $time[0].' '.__("general.time_week");
            break;
        case 'weeks':
            return $time[0].' '.__("general.time_weeks");
            break;
        case 'month':
            return $time[0].' '.__("general.time_month");
            break;
        case 'months':
            return $time[0].' '.__("general.time_months");
            break;
        case 'year':
            return $time[0].' '.__("general.time_year");
            break;
        case 'years':
            return $time[0].' '.__("general.time_years");
            break;
    }
}

function amazon_variables() {
    $category = array("KindleStore", "VideoGames", "Toys", "Music", "MP3Downloads", "Kitchen", "Jewelry", "Industrial", "Collectibles", "DVD", "Books", "Baby", "Apparel");
    $node = array("133140011", "468642", "165793011", "301668", "163856011", "284507", "3367581", "16310091", "5088769011", "130", "283155", "165796011", "1036592");
    $random_int = rand(0, 12);
    $amzn_assoc_default_category = $category[$random_int];
    $amzn_assoc_default_browse_node = $node[$random_int];

    return array($amzn_assoc_default_category, $amzn_assoc_default_browse_node);
}