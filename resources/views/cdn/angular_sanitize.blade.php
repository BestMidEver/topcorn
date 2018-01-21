<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.min.js"></script>
<script>
    (function() {
        try {

            window.angular.module('ngSanitize');
        } catch(e) {
            return false;
        }
        return true;
    })()
    || document.write('<script src="/js/fallbackcdn/angular-sanitize.min.js"><\/script>')
</script>