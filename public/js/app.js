var MyApp = angular.module('MyApp', pass.angular_module_array)
.directive('onErrorSrc', function() {
	return {
		link: function(scope, element, attrs) {
			element.bind('error', function() {
				if (attrs.src != attrs.onErrorSrc) {
					attrs.$set('src', attrs.onErrorSrc);
				}
			});
			attrs.$observe('ngSrc', function(value) {
				if (!value && attrs.onErrorSrc) {
					attrs.$set('src', attrs.onErrorSrc);
				}
			});
		}
	}
})
.directive('dynamicModel', ['$compile', '$parse', function ($compile, $parse) {
    return {
        restrict: 'A',
        terminal: true,
        priority: 100000,
        link: function (scope, elem) {
            var name = $parse(elem.attr('dynamic-model'))(scope);
            elem.removeAttr('dynamic-model');
            elem.attr('ng-model', name);
            $compile(elem)(scope);
        }
    };
}])
.directive('dynamicShow', ['$compile', '$parse', function ($compile, $parse) {
    return {
        restrict: 'A',
        terminal: true,
        priority: 100000,
        link: function (scope, elem) {
            var name = $parse(elem.attr('dynamic-show'))(scope);
            elem.removeAttr('dynamic-show');
            elem.attr('ng-show', name);
            $compile(elem)(scope);
        }
    };
}])
.filter('range', function() {
	return function(input, total) {
		total = parseInt(total);
		for (var i=0; i<total; i++)
			input.push(i);
		return input;
	};
});

$('#myModal').on('shown.bs.modal', function () {
	$('#myInput').focus()
});

$(document).ready(function() {
	$("body").tooltip({ selector: '[data-toggle=tooltip]' });
	$( ".votecard .card-img" ).click(function() {
		$( ".faderdiv" ).toggleClass( "faded" );
	});

	$("[data-toggle=popover]").each(function(i, obj) {
		$(this).popover({
			container: 'body',
			html: true,
			trigger: 'manual',
			content: function() {
				var id = $(this).attr('id')
				return $('#popover-content-' + id).html();
			}
		});
	});

	$("textarea.auto-resize").each(function(i, obj) {
		this.style.height = "";
		this.style.height = (this.scrollHeight+3) + "px";
	});

	$('[data-toggle="tooltip"]').tooltip({
		trigger : 'hover'
	});
});
