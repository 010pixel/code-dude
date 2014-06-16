var mainData;
var currentChatId;
$(document).ready(function(){
	mainData = getJsonData(init);
});

function getJsonData(func) {
	var jqxhr = $.getJSON('json/family.json', function(data) {
		mainData = data;
	})
	.error(function() { console.log("error"); })
	.success(function() {
		// If any6 function is passed then run the function
		if ( jQuery.isFunction(func) == true ) { func(); }
	});
	
	// After Process complete, return data
	jqxhr.complete(function(){
		// If any6 function is passed then run the function
		// if ( jQuery.isFunction(func) == true ) { func(); }
	});

	return mainData;
}

function init(){
	var treeHtml;
	treeHtml = generateTree(mainData.family,50);
	initiateFunctions();
}

// Initialize functions and set values
function generateTree(childArray, maxMembers){
	
	var myObject;

	myObject = childArray;
	
	for (var i=0; i<myObject.length; i++) {
		
		if ( i >= maxMembers ) { break; }
		
		// Get all data
		var treeData = "";
		var id = myObject[i].id;
		var name = myObject[i].name;
		var image = myObject[i].image;
		var parent = myObject[i].parent;
		var parentElement = (parseInt(parent) <= 0) ? ".tree" : "#" + parent ;
		
		treeData += '\n\t<li id="'+ id +'" class="individual" parent="'+ parent +'">';
		treeData += '<a image="'+ image +'">';
		treeData += '<span class="name">' + name + '</span>';
		treeData += '</a>';
		treeData += '</li>';
		
		if ( $(parentElement + " > ul").length > 0 ) {
		} else {
			$(parentElement).append("<ul></ul>");
		}
		
		$(parentElement + " > ul").append(treeData);
		$(parentElement).removeClass("individual");
		$(parentElement).addClass("group");
		// console.log(id);
		// console.log(parentElement);
		// console.log(treeData);
	}

}

// Initiate all functions for effects
function initiateFunctions(){
	$("li").mouseenter(function(){
		liHoverOn(this);
	});
	
	$("li").mouseleave(function(){
		liHoverOff(this);
	});

	$("li").click(function(){
		liClick(this);
	});

	$("ul").mouseleave(function(){
	 });

	$("a").mouseenter(function(){
		mouseOverImage(this);
	});
	$("a").mouseleave(function(){
		mouseOutImage(this);
	});
}

// When MouseOver LI
function liHoverOn(element){
}

// When MouseOut LI
function liHoverOff(element){
}

function liClick(element){
}


// Function to run when user mouseover image in Chat Content Box
function mouseOverImage(element){
	if($(element).find("p").length == 0){
		var imgSrc = $(element).attr("image");
		$(element).append('<p><img src="'+ imgSrc +'"></p>');
		var par = $(element).find("p");
		$(element).css('position','relative');
		$(par).css('position','absolute');
		$(par).css('background-color','#333');
		$(par).css('padding','6px 3px 3px');
		$(par).css('top','20px');
		$(par).css('left','70px');
		$(par).css('z-index','1000');
	}
}

// Function to run when user mouseout image in Chat Content Box
function mouseOutImage(element){
	if($(element).find("p").length > 0){
		$(element).find("p").remove();
	}
}