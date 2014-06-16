var jsonUrl = 'json/data.json';

var jqxhr = $.getJSON( jsonUrl, function(data) {
				console.log( data );
			})
			.done(function() {
				console.log( data );
			})
			.fail(function() {
				console.log( "error" );
			})
			.always(function() {
				console.log( "complete" );
			});

function createHeader(title, desc, url) {
    var content = '';
	content = '		<div class="hero-unit">';
	content = '        	<h1>'+ title +'</h1>';
	content = '    		<p>'+ desc +'</p>';
	content = '     	<p><a href="'+ url +'" class="btn btn-primary btn-large">Download &raquo;</a></p>';
	content = '     </div>';
	return content;
}

function createMenuBar() {
}

function createFooter(content) {
	$("footer p").html(content);
}

function homePageItems() {
}