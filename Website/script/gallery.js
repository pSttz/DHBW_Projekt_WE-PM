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
}


$(document).ready(function(){
	
	var gallery = $(".gallery");
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

				// get an image
				var image = images.eq(blockIndex)[0];

				// if the image has a title - transform it to span
				// var titleText = $(image).attr("title");
				// if(titleText != "") {
				// 	var title = document.createElement('span');
				// 	title.setAttribute('class', "desciption");
				// 	title.innerText = titleText;
				// 	$(image).removeAttr('title');
				// 	link.appendChild(title);
				// }
				
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
				block.css({
					"width": parent.width(),
					"height": object["height"] * ratio
				});
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


	$(".popover").click(function() {
		popover('<img src="'+$(this).attr("href")+'"/>', $(this).attr("class"), "show", imagesTotalNum);
		return false;
	});
});



function popover(content, className, actionType, imagesNum) {
	var siblings = getSiblingsIndex(className, imagesNum);
	var prevImageIndex = siblings[0];
	var nextImageIndex = siblings[1];

	var prevButton = '<a id="popover-prev" href="#" class="button" onClick="updatePopover('+prevImageIndex+','+imagesNum+');return false;">Previous</a>';
	var nextButton = '<a id="popover-next" href="#" class="button" onClick="updatePopover('+nextImageIndex+','+imagesNum+');return false;">Next</a>';

	var popoverTemplate = $('<div id="popover"><div class="popover-wrapper">'
		+ ' <a id="popover-close" href="#" class="button" onClick="closePopover();return false;">&times;</a>'
		+ '<div class="popover-controls"></div><div class="popover-content"></div></div></div>');
	var shadowTemplate = $('<div id="popover-shadow"/>');
	var popover = '#popover';
	var popoverControls = '#popover .popover-controls';
	var popoverContent = '#popover .popover-content';
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
	}

	// insert HTML content
	if(content != null){
		if(prevImageIndex != -1) $(popoverControls).append(prevButton);
		if(nextImageIndex >= 0) $(popoverControls).append(nextButton);	
		$(popoverContent).append(content);	
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
	var height = $(popover).children().find("img").prop("naturalHeight");
	var top = ( $(window).height() - height ) / 2  + "px";
	var left = ( $(window).width() - width ) / 2 + "px";
	$(popover).css({
		'width' : width,
		'height' : height,
		'top' : top,
		'left' : left
	});
}


function getSiblingsIndex(className, imagesNum) {
	var classes = className.split(' ');
	var index, indexPrev, indexNext;
	for (var index in classes) {
        if (classes[index].match(/^block\d+$/)) {
            index = parseInt(classes[index].match(/\d+/)[0]);
            break;
        }
    }
    indexPrev = (index != 0) ? index-1 : -1;
    indexNext = (index < imagesNum) ? index+1 : -1;
    return [indexPrev, indexNext];
}


function updatePopover(index, imagesNum) {
	var nextImageClass = $(document).find("a.block" + (parseInt(index))).attr("class");
	var nextImageSrc = $(document).find("a.block" + (parseInt(index)) + " img").attr("src");
	popover('<img src="' + nextImageSrc + '"/>', nextImageClass, "update", imagesNum);
	return false;
}


function closePopover(){
	var popover = '#popover';
	var shadow = '#popover-shadow';
	$(popover).fadeOut();
	$(popover).remove();
	$(shadow).remove();
}