var blocks = {};
var ratio = 1;
var topLevel = 0;

function isEven(value) {
	if (value % 2 == 0) return true;
	else return false;
}


function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}


function divideBlocks(level, index, width1, width2, height1, height2, divideType) {		
	if(divideType == "horizontal") {
		var size1 = width1;
		var size2 = width2;
		var size3 = height1;
		var size4 = height2;
	}
	else {
		var size1 = height1;
		var size2 = height2;
		var size3 = width1;
		var size4 = width2;
	}
	
	// check chosen size of images
	// depends on it calculate ratio and make the block smaller
	if(size1 != size2) {
		if(size1 > size2) {
			ratio = size2 / size1;
			size3 = Math.ceil(size3 * ratio);
		} 
		else {
			ratio = size1 / size2;
			size4 = Math.ceil(size4 * ratio);
		}
	}

	if(divideType == "horizontal") {
		var blockWidth = Math.min(size1, size2);
		var blockHeight = size3 + size4;
	}
	else {
		var blockWidth = size3 + size4;
		var blockHeight = Math.min(size1, size2);			
	}

	// write new data to array "blocks"
	blocks['level' + level]['block'+ index]["divide"] = divideType;
	blocks['level' + level]['block'+ index]['width'] = blockWidth;
	blocks['level' + level]['block'+ index]['height'] = blockHeight;
}


function prepareDivide(blocksNum, level) {
	// we divide blocks in pairs - so, every block will have max 2 children
	// take every 2 images and combine them in a block, 
	// then take that block and the next one and combine them in a block, and so on
	for(i = 0, index = 0; i < blocksNum; i += 2, index++) {
		blocks['level' + level]['block'+ index] = {};
		
		// set first block
		var block1 = blocks['level' + (level-1)]['block'+ i];
		var width1 = block1["width"];
		var height1 = block1["height"];

		// set second block only if there is even blocks amount 
		// or, in case of odd blocks amount, it's not the last block 
		if(isEven(blocksNum) || !isEven(blocksNum) && i != blocksNum-1) {
			var block2 = blocks['level' + (level-1)]['block'+ (i+1)];
			var width2 = block2["width"];
			var height2 = block2["height"];
		} 

		// add children indexes to array "blocks"
		// we need it later to adapt size of the children depends on the parent's size
		if(isEven(blocksNum)) {
			// if there are even amount of children - just write every 2 indexes
			blocks['level' + level]['block'+ index]["children"] = i + "," + (i+1);
		} 
		else {
			// if there are odd amount of children
			// if it's the last child - write only its index
			if(i == blocksNum-1) {
				blocks['level' + level]['block'+ index]["children"] = i;
			}
			// else write both children' indexes
			else {
				blocks['level' + level]['block'+ index]["children"] = i + "," + (i+1);
			}
		}

		//if there is odd amount of images - set last block size equal last image size and exit
		if(!isEven(blocksNum) && i == blocksNum-1) {	
			blocks['level' + level]['block'+ index]["divide"] = "no_divide";
			blocks['level' + level]['block'+ (blocksNum-1) / 2]['width'] = width1;
			blocks['level' + level]['block'+ (blocksNum-1) / 2]['height'] = height1;
			break;
		}

		// compare width & height of images to decide how to arrange images in a block
		// on the basis of ratio
		// because later we need to make one of 2 images smaller to place them in a block without empty spaces
		// we have to choose the better way to make an image smaller, i.e. to find the smaller ratio
		var compareWidths = (width1 > width2 ? (width1 / width2) : (width2 / width1)).toFixed(2);
		var compareHeights =  (height1 > height2 ? (height1 / height2) : (height2 / height1)).toFixed(2);
		// var compareDifference = (Math.abs(compareWidths - compareHeights)).toFixed(2);

		if(compareWidths > compareHeights || height1 > 650 || height2 > 650) {
			divideBlocks(level, index, width1, width2, height1, height2, "vertical");
		}
		else if(compareWidths < compareHeights) {
			divideBlocks(level, index, width1, width2, height1, height2, "horizontal");
		}
		else {
			divideBlocks(level, index, width1, width2, height1, height2, "vertical");
		}

		// random variant, just to see how tiles could be arranged
		// var random = getRandomInt(0, 4);
		// if(random == 0 || random == 2 || height1 > 650 || height2 > 650) {
		// 	verticalDivide(level, index, width1, width2, height1, height2);
		// }
		// else {
		// 	horizontalDivide(level, index, width1, width2, height1, height2);
		// }

		// avoid repeating divide types - it makes gallery too monotone
		// check if a block's sibling has the same divide type
		// if yes - change it to another type
		var parentIndex = Math.floor(index/2);
		var parent = blocks['level' + level]['block'+ parentIndex];
		var parentSibling = blocks['level' + level]['block'+ (parentIndex+1)];

		if(parentSibling != undefined && parent.divide == parentSibling.divide) {
			if(parent.divide == "horizontal") {
				divideBlocks(level, index, width1, width2, height1, height2, "vertical");
			}
			else {
				divideBlocks(level, index, width1, width2, height1, height2, "horizontal");
			}
		}
	}	
}


function setCss(blockLevel, block, width, height) {
	// add padding only to images, i.e. level 0
	if(blockLevel == 0) {
		var padding = 5;
	}

	block.css({
		"width": width,
		"height": height,
		"padding": padding
	});	

	$(block).attr("data-height", height);
}


function popover(content, className, actionType) {
	var siblings = getSiblingsIndex(className);
	var prevImageIndex = siblings[0];
	var nextImageIndex = siblings[1];

	var prevButton = '<a id="popover-prev" href="#" class="button" onClick="updatePopover('+prevImageIndex+');return false;" style="top:'+($(window).height()/2-50)+'px">Previous</a>';
	var nextButton = '<a id="popover-next" href="#" class="button" onClick="updatePopover('+nextImageIndex+');return false;" style="top:'+($(window).height()/2-50)+'px">Next</a>';

	var popoverTemplate = $('<div id="popover"><div class="popover-wrapper">'
		+ ' <a id="popover-close" href="#" class="button" onClick="closePopover();return false;">&times;</a>'
		+ '<div class="popover-info-top"></div><div class="popover-content"></div><div class="popover-info-bottom"></div></div></div><div class="popover-controls"></div>');
	var shadowTemplate = $('<div id="popover-shadow"/>');
	var popover = '#popover';
	var popoverControls = '.popover-controls';
	var popoverContent = '#popover .popover-content';
	var popoverInfoTop = '#popover .popover-info-top';
	var popoverInfoBottom = '#popover .popover-info-bottom';
	var shadow = '#popover-shadow';

	// add popover/shadow divs if not added
	if($(popover).size() == 0) {
		$('body').append(shadowTemplate);
		$('body').append(popoverTemplate);	
	}

	$(shadow).click(function(e){
		closePopover();
	});

	if(actionType == "update") {
		$(popoverControls).empty();
		$(popoverContent).empty();	
		$(popoverInfoTop).empty();
		$(popoverInfoBottom).empty();	
	}

	// insert HTML content
	if(content != null){
		if(prevImageIndex != -1) $(popoverControls).append(prevButton);
		if(nextImageIndex >= 0) $(popoverControls).append(nextButton);	

		var imageDate = content.attr("data-date");
		var imageDescription = content.attr("data-description");
		var imageLikes = content.attr("data-likes");
		var imageTitle = content.attr("title");
		var imageId = content.attr("data-id");

		var date = new Date(imageDate);
		var day = date.getDate();
		var monthIndex = date.getMonth();
		var year = date.getFullYear();
		var monthNames = [
			"Januar", "Februar", "März",
			"April", "Mai", "Juni", "Juli",
			"August", "September", "Oktober",
			"November", "Dezember"
		];
		var humanDate = day + ". " + monthNames[monthIndex] + " " + year;

		var likeExists = false;
		var cookie = getCookie("likes").split(",");
		for(i = 0; i < cookie.length; i++) {
			if(cookie[i] == imageId) {
				likeExists = true;
				break;
			}
		}

		$(popoverContent).append(content);	
		$(popoverInfoTop).append("<div class='image-title'>" + imageTitle + "</div>");
		$(popoverInfoBottom).append("<div class='image-description'>" + imageDescription + "</div>");
		$(popoverInfoBottom).append("<div class='image-date'>Hinzugefügt am " + humanDate + "</div> | ");	
		$(popoverInfoBottom).append("<div class='image-likes' id='image-"+imageId+"'>Gefällt mir <span class='" + (likeExists ? 'liked' : '') +"'>" + imageLikes + "</span></div>");
		
	}

	// set the popover size and position
	popoverPosition(popover);

	if(actionType == "show") {
		// display the popover
		$(popover).fadeIn();
		$(shadow).show();
	}
}


function popoverPosition(popover) {
	var width = $(popover).children().find("img").prop("naturalWidth");
	var height = $(popover).children().find("img").prop("naturalHeight") + 100;

	if(height > $(window).height()) {
		var ratio = $(window).height() / height;
		height = $(window).height();
		width = width * ratio;
	}
	else if(height > 700) {
		var ratio = 700 / height;
		height = 700;
		width = width * ratio;
	}
	else if(width > $(window).width()) {
		var ratio = $(window).width() / width;
		width = $(window).width();
		width = width * ratio;
	}
	else if(width > 1000) {
		var ratio = 1000 / width;
		width = 1000;
		height = height * ratio;
	}

	var top = ( $(window).height() - height ) / 2  + "px";
	var left = ( $(window).width() - width ) / 2 + "px";
	$(popover).css({
		'width' : width,
		'height' : height,
		'top' : top,
		'left' : left
	});
}


function getSiblingsIndex(className) {
	var classes = className.split(' ');
	var index, indexPrev, indexNext;
	for (var index in classes) {
        if (classes[index].match(/^block\d+$/)) {
            index = parseInt(classes[index].match(/\d+/)[0]);
            break;
        }
    }
    indexPrev = (index != 0) ? index-1 : -1;
    if($(".level0.block" + (index+1)).length !=0 ) 	indexNext = index+1;
    else 											indexNext = 0;

    return [indexPrev, indexNext];
}


function updatePopover(index) {
	var nextLink = $(document).find("a.block" + (parseInt(index)));
	var image = nextLink.children("img").clone(true);
	var nextImageClass = nextLink.attr("class");
	popover(image, nextImageClass, "update");
	return false;
}


function closePopover(){
	var popover = '#popover';
	var shadow = '#popover-shadow';
	var popoverControls = '.popover-controls';
	$(popover).fadeOut();
	$(popover).remove();
	$(shadow).remove();
	$(popoverControls).remove();
}


function makeGallery(galleryClass) {
	var gallery = $(galleryClass);
	var galleryWidth = gallery.width();
	//clone images from DOM to use them later
	var images = gallery.children().clone(true);
	var imagesTotalNum = images.size();
	var imagesNum = imagesTotalNum;
	var imagesNumEven = 2 * Math.round(imagesNum / 2); //round imagesNum to even to find number of blocks
	var blocksNum = imagesNumEven / 2; 
	// images are saved in the array "images", so gallery can be cleared
	gallery.empty();

	// begin to create blocks starting from level 0 (images)
	// firstly write images to blocks array as level 0
	var level = 0;
	blocks['level' + level] = {};
	for(i = 0; i < imagesNum; i++) {
		var image = images.eq(i);
		var width = image.prop("width");
		var height = image.prop("height");

		blocks['level' + level]['block'+ i] = {};

		blocks['level' + level]['block'+ i]['width'] = width;
		blocks['level' + level]['block'+ i]['height'] = height;
	}

	// now combine blocks in pairs until 1 main block reached
	while(Object.keys(blocks['level' + level]).length > 1) {
		var blocksNum = Object.keys(blocks['level' + level]).length;
		level++;
		blocks['level' + level] = {};
		prepareDivide(blocksNum, level);
		topLevel = level;
	}

	// force first and second levels to be horizontal divided, 
	// otherwise images will be too small
	for(i = 0; i < 2; i++) {
		var currentLevel = (topLevel-i);
		var width1 = blocks['level' + (currentLevel-1)]['block0'].width;
		var width2 = blocks['level' + (currentLevel-1)]['block1'].width;
		var height1 = blocks['level' + (currentLevel-1)]['block0'].height;
		var height2 = blocks['level' + (currentLevel-1)]['block1'].height;	
		divideBlocks(currentLevel, 0, width1, width2, height1, height2, "horizontal");
	}

	// console.log(images);
	// console.log(JSON.stringify(blocks));
	// console.log(images);

	// append blocks from array "blocks" and adapt their size depends on the gallery width
	for(i = topLevel; i >= 0; i--) {
		// iterate through levels
		var countLevelBlocks = Object.keys(blocks["level"+i]).length;
		var parentBlockIndex = 0;	

		// iterate through blocks
		for(k = 0; k < countLevelBlocks; k++) {

			var blockLevel = i;
			var blockIndex = k;

			// get current block from the array
			var object = blocks['level' + blockLevel]["block" + blockIndex];
			
			// find block's sibling's size
			// we need it later to adapt block size relatively to its sibling
			if(isEven(blockIndex)) {
				// if index of the block is even - find out if it has a sibling
				if(blocks['level' + blockLevel]["block" + (blockIndex+1)] !== undefined) {
					var sibling = blocks['level' + blockLevel]["block" + (blockIndex+1)];
					var siblingWidth = sibling["width"];
					var siblingHeight = sibling["height"];
				}
				// the block doesn't have siblings
				else {
					var siblingWidth = 0;
					var siblingHeight = 0;
				}
			}
			// if block index is odd, it has a sibling in any case
			// just get the previous block size
			else {
				var sibling = blocks['level' + blockLevel]["block" + (blockIndex-1)];
				var siblingWidth = sibling["width"];
				var siblingHeight = sibling["height"];
			}

			// we need divide type written to parent block later, to adapt size correctly
			var objectParentDivideType = blocks['level' + (blockLevel == topLevel ? blockLevel : blockLevel+1)]["block" + (Math.floor(blockIndex/2))]["divide"];
			
			// blockLevel == 0 means, that it's the level with images
			if(blockLevel == 0) {
				// create link element
				var link = document.createElement('a');
				link.setAttribute('href', images.eq(blockIndex).prop("src"));
				link.setAttribute('class', "tiles-item level"+ blockLevel +" block" + blockIndex + " tiles-image popover");
				// link.setAttribute('data-date', images.eq(blockIndex).data("date"));

				// get an image
				var image = images.eq(blockIndex)[0];

				// append additional information
				var likesCount = $(image).data("likes");
				if(likesCount > 0) {
					var likes = document.createElement('span');
					var likesInner = document.createElement('span');
					likes.setAttribute('class', "likes");
					likesInner.innerText = likesCount;
					link.appendChild(likes);
					likes.appendChild(likesInner);
				}
				
				link.appendChild(image);
				var block = $(link);
			}
			else {
				var block = $("<div class='tiles-item level"+ blockLevel +" block" + blockIndex + "'/>");
			}

			// increase parent index for every 3rd, 5th, 7th ... block
			// that allows to place max 2 blocks per parent
			if(blockIndex != 0 && blockIndex % 2 == 0) {
				parentBlockIndex++;
			} 

			// get parent block, 
			// if it's the top-level, parent is the gallery itself, else - a block from level up
			if(blockLevel == topLevel) {
				var parent = gallery;
			}
			else {
				var parent = $(".tiles-item.level"+ (blockLevel+1) +".block" + parentBlockIndex);
			}

			// add helper classes to all levels block, exept level with images
			// it's not so necessary, but can help to style if needed
			if(blockLevel != 0) {
				if(object["divide"] ==  "horizontal") {
					block.addClass("horizontal");
				}
				else if(object["divide"] ==  "vertical") {
					block.addClass("vertical");
				}
				else {
					block.addClass("no-divide");
				}
			}

			// begin to calculate block sizes depends on a divide type
			if(blockLevel == topLevel) {
				// set top-level block width equal to parent (gallery) width
				// and calculate the height depending on the ratio
				ratio = parent.width() / object["width"];
				var newWidth = parent.width();

				// var newHeight = object["height"] * ratio;
				var children = object["children"].split(',');
				var newHeight = 0;
				for(var childIndex = 0; childIndex < children.length; childIndex++) {
					newHeight += blocks['level' + (blockLevel-1)]["block" + childIndex];
				}

				if(newHeight == 0) newHeight = object["height"] * ratio;
				else newHeight = newHeight * ratio;

				// $(block).attr("data-orig-height", object["height"]);
				setCss(blockLevel, block, newWidth, newHeight);
			}
			else {
				// divide type is horizontal
				if(objectParentDivideType == "horizontal") {
					ratio = parent.width() / object["width"];
					var newWidth = parent.width();
					
					// if it's the first block, adapt height on the basis of ratio
					if(isEven(blockIndex)) {
						var newHeight = object["height"] * ratio;
					}
					// if it's the second block, adapt height depends on the siblings size
					else {
						var siblingObject =  $(".tiles-item.level"+ blockLevel +".block" + (blockIndex-1));
						var siblingHeight = siblingObject.height();
						var parentHeight = parent.height();
						if(parentHeight <= siblingHeight) { var newHeight = object["height"] * ratio; }
						else { var newHeight = parentHeight - siblingHeight; }
					}

					setCss(blockLevel, block, newWidth, newHeight);
				}

				// divide type is vertical
				else if(objectParentDivideType == "vertical") {
					ratio = parent.height() / object["height"];
					var newHeight = parent.height();

					// if it's the first block, adapt width on the basis of ratio
					if(isEven(blockIndex)) {
						var newWidth = object["width"] * ratio;
					}
					// if it's the second block, adapt width depends on the siblings size
					else {
						var siblingObject =  $(".tiles-item.level"+ blockLevel +".block" + (blockIndex-1));
						// get sibling width with method getComputedStyle, 
						// because width() returns a value without decimal
						// it causes wrong calculation
						var siblingWidth = (window.getComputedStyle(siblingObject[0]).width).replace("px", "");
						var parentWidth = (window.getComputedStyle(parent[0]).width).replace("px", "");
						// if(siblingWidth > parentWidth) var newWidth = object["width"] * ratio;
						// else 
						var newWidth = parentWidth - siblingWidth;
					}

					setCss(blockLevel, block, newWidth, newHeight);
				}

				// divide type is "no_divide" in other words there's one block in the parent, 
				// no need to divide and adapt size depending on the sibling
				else {
					// just set the width equal the parent width
					// and calculate the height depending on the ratio
					ratio = parent.width() / object["width"];
					var newWidth = parent.width();
					var newHeight = object["height"] * ratio;

					setCss(blockLevel, block, newWidth, newHeight);
				}
			}

			// append the prepared block to DOM
			parent.append(block);
		}
	}	
}

function sendLike(id) {
	var likeExists = false;
	var cookie = getCookie("likes").split(",");
	for(i = 0; i < cookie.length; i++) {
		if(cookie[i] == id) {
			likeExists = true;
			break;
		}
	}
	if(!likeExists) updateLikes(id);
	return false;
}

function updateLikes(id) {
	$.ajax({
        type: "GET",
        url: "likes.php",
        dataType: 'html',
        data: ({ id: id }),
        success: function(data) {
            appendCookie("likes", id, 365);
            var prevLikes = parseInt($("#image-"+id + " span").html());
            $("#image-" + id + " span").html(prevLikes+1);
            $("#image-" + id + " span").addClass("liked");
            $('*[data-id="'+ id +'"]').attr("data-likes", (prevLikes+1));
            $('*[data-id="'+ id +'"]').prev("span").children("span").html(prevLikes+1);

        }
    });
}


$(document).ready(function() {
	$('body').on('click', '.popover', function() {
		var image = $(this).children("img").clone(true);
		var className = $(this).attr("class");
		popover(image, className, "show");
		return false;
	});

	$('#search_form').submit(function(e) {   
		makeSearch($(this).children('#search').val());
		e.preventDefault(); 
	});

	$('#search_button').click(function(e) {   
		makeSearch($(this).siblings('#search').val());
	});

	$('#sort_gallery').on('change', function() {
		if(this.value == "no_sort") 		removeSort();
		else if(this.value == "title_asc") 	makeSort("title", "asc");
		else if(this.value == "title_desc") makeSort("title", "desc");
		else if(this.value == "title_desc") makeSort("title", "desc");
		else if(this.value == "date_asc") 	makeSort("date", "asc");
		else if(this.value == "date_desc") 	makeSort("date", "desc");
		else if(this.value == "tags_asc") 	makeSort("tags", "asc");
		else if(this.value == "likes_asc") 	makeSort("likes", "asc");
	});

	$('body').on('click', '.image-likes', function() {
		sendLike($(this).prop("id").split('-')[1]);
	});
});



$(window).load(function() {
	if($(".gallery").length != 0) {
		$(".gallery").removeClass("loading");
		$(".loader").hide();
		makeGallery(".gallery");
	}
});
