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
			placement: 'bottom',
			trigger: 'manual',
			content: function() {
				var id = $(this).attr('id')
				return $('#popover-content-' + id).html();
			}
		});
	});

	switch(location.hash){
		case '#tooltip-quickvote':
			$('#quickvote').popover('show')
			break;
		case '#tooltip-search':
			$('#search').popover('show')
			break;
		case '#tooltip-recommendations':
			$('#recommendations').popover('show')
			break;
		case '#tooltip-profile':
			$('#recommendations').popover('hide')
			$('#profile').popover('show')
			break;
		case '#tooltip-percentage':
			$('#percentage').popover('show')
			break;
	}
});

$('[data-toggle="tooltip"]').tooltip({
	trigger : 'hover'
});