<?php

function timeAgo($time) {
    switch ($time[1]) {
    	case 'second':
    		return $time[0].' saniye ';
    		break;
    	case 'seconds':
    		return $time[0].' saniye ';
    		break;
    	case 'minute':
    		return $time[0].' dakika ';
    		break;
    	case 'minutes':
    		return $time[0].' dakika ';
    		break;
    	case 'hour':
    		return $time[0].' saat ';
    		break;
    	case 'hours':
    		return $time[0].' saat ';
    		break;
    	case 'day':
    		return $time[0].' gün ';
    		break;
    	case 'days':
    		return $time[0].' gün ';
    		break;
    	case 'week':
    		return $time[0].' hafta ';
    		break;
    	case 'weeks':
    		return $time[0].' hafta ';
    		break;
    	case 'month':
    		return $time[0].' ay ';
    		break;
    	case 'months':
    		return $time[0].' ay ';
    		break;
    	case 'year':
    		return $time[0].' yıl ';
    		break;
    	case 'years':
    		return $time[0].' yıl ';
    		break;
    }
}