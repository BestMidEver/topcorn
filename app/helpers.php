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