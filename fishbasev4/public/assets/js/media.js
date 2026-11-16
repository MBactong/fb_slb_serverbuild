
var sliderdrag = false;
var slidermove = false;
var mX = -1;
var mY = -1;

if (document.querySelector('#species-maps')) {
    var mapslider = tns({
        container: '#species-maps',
        items: 1,
        gutter: 5,
        mouseDrag: true,
        controls: false,
        loop:false,
        navPosition:"bottom",
        swipeAngle:false /*,
        responsive: {
        640: {
            items: 2
        },
        900: {
            items: 3
        },
        1200: {
            items: 5
        }
        }*/
    });
}
if (document.querySelector('#species-images')) {
    var slider = tns({
        container: '#species-images',
        items: 1,
        gutter: 5,
        mouseDrag: true,
        controls: false,
        loop:false,
        navPosition:"bottom",
        swipeAngle:false /*,
        responsive: {
        640: {
            items: 2
        },
        768: {
            items: 3
        } /*,
        860: {
            items: 3
        },
        1024: {
            items: 3
        }
        }*/
    });


/*slider.events.on('touchStart', function() {
    console.log("TOUCHSTART");
});
slider.events.on('touchEnd', function() {
    console.log("TOUCHEND");
});

slider.events.on('dragStart', function() {
    console.log("DRAGSTART");
});*/

sliderinfo = slider.getInfo();

sliderinfo.container.onmousemove = function(e) {
    if (mX < 0 && mY < 0) {
        mX = e.clientX;
        mY = e.clientY;
        slidermove = false;
        return;
    }
    if (slidermove) {
        if (Math.abs(mX - e.clientX) > 1  || Math.abs(mY - e.clientY) > 1) {
            mX = e.clientX;
            mY = e.clientY;
            sliderdrag = true;
            //console.log("DRAGGING");
        }
    }
    else {
        sliderdrag = false;
        //console.log("NOT DRAGGING");
    }
};

/*slider.events.on('dragMove', function() {
    slidermove = true;
    console.log("DRAGMOVE");
});*/

sliderinfo.container.onmousedown = function(e) {
    mX = e.clientX;
    mY = e.clientY;
    sliderdrag = false;
    slidermove = true;
};

sliderinfo.container.onmouseup = function() {
    slidermove = false;
};

slider.events.on('transitionStart', function() {
    slidermove = false;
    sliderdrag = false;
    //console.log("TRANSITIONSTART");
});
slider.events.on('transitionEnd', function() {
    sliderdrag = false;
    slidermove = false;
    //console.log("TRANSITIONEND");
});
slider.events.on('dragEnd', function() {
    sliderdrag = false;
    slidermove = false;
    //console.log("DRAGEND");
});

}

/* var stickyTitle = document.querySelector('#stickyTitle');
if (stickyTitle) {
    window.addEventListener('scroll', function() {
        var scrollPosition = Math.round(window.scrollY);
        if (scrollPosition > 99){
            document.querySelector('header').classList.add('sticky');
        }
        else {
            document.querySelector('header').classList.remove('sticky');
        }
    });
} */

var initPhotoSwipeFromDOM = function(gallerySelector) {

    var parseThumbnailElements = function(el) {
    var thumbElements = el.childNodes,
        numNodes = thumbElements.length,
        items = [],
        figureEl,
        linkEl,
        size,
        item;

        for(var i = 0; i < numNodes; i++) {
            figureEl = thumbElements[i]; // <figure> element
            // include only element nodes 
            if(figureEl.nodeType !== 1) {
                continue;
            }

            linkEl = figureEl.children[0]; // <a> element
            title = false;
            // get data-attributes
            filename = linkEl.getAttribute('href').replace(/^.*[\\\/]/, '');
            title = "<b>" + filename + "</b>";
            author = linkEl.getAttribute('data-author');
            if (author) {
                collab = linkEl.getAttribute('data-collab');
                if (collab) {
                    title = title + ' by <a href="https://fishbase.mabe.at/Collaborators/CollaboratorSummary.php?ID=%collab%">' + author + '</a>';
                    title = title.replace('%collab%', collab);
                }
                else {
                    title = title + " by " + author;
                }
            }
            dl = '';
            size = linkEl.getAttribute('data-size');
            if (size) {
                dl = dl + "<dt>Size (cm):</dt> <dd>" + size + "</dd>";
            }
            country = linkEl.getAttribute('data-country');
            loc = linkEl.getAttribute('data-location');
            if (country || loc) {
                dl = dl + "<dt>Locality:</dt><dd>";
                if (country) {
                    dl = dl + country;
                }
                if (country && loc) {
                    dl = dl + ", ";
                }
                if (loc) {
                    dl = dl + loc;
                }
                dl = dl + "</dd>";
            }
            sex = linkEl.getAttribute('data-sex');
            if (sex) {
                dl = dl + "<dt>Sex/Stage:</dt><dd>" + sex + "</dd>";
            }
            d = linkEl.getAttribute('data-date');
            if (d) {
                dl = dl + "<dt>Date:</dt><dd>" + d + "</dd>";
            }
            ref = linkEl.getAttribute('data-ref');
            if (ref) {
                dl = dl + '<dt>Reference:</dt><dd><a href="https://fishbase.mabe.at/References/FBRefSummary.cfm?ID=%ref%">';
                dl = dl.replace('%ref%', ref);
                dl = dl + linkEl.getAttribute('data-refname') + ', ' + linkEl.getAttribute('data-refyear') + '<br>' + linkEl.getAttribute('data-refpub');
                dl = dl + '</a></dd>';
            }
            remark = linkEl.getAttribute('data-remark');
            if (remark) {
                dl = dl + "<dt>Remark:</dt><dd>" + remark + "</dd>";
            }

            if (dl) {
                title = title + "<dl>" + dl + "</dl>";
            }
            //size = linkEl.getAttribute('data-size').split('x');
            //imgEl = figureEl.children[0];
            // create slide object
            item = {
                src: linkEl.getAttribute('href'),
                w: 0,
                h: 0,
                title: title /*,
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)*/
            };

            /*if(figureEl.children.length > 1) {
                // <figcaption> content
                item.title = figureEl.children[1].innerHTML; 
            }*/

            /*if(linkEl.children.length > 0) {
                // <img> thumbnail element, retrieving thumbnail url
                item.msrc = linkEl.children[0].getAttribute('src');
            }*/

            item.el = figureEl; // save link to element for getThumbBoundsFn
            items.push(item);
        }
        return items;
    };

    // find nearest parent element
    var closest = function closest(el, fn) {
        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
    };

    // triggers when user clicks on thumbnail
    var onThumbnailsClick = function(e) {
        
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;

        if (sliderdrag) {
            return;
        }

        var eTarget = e.target || e.srcElement;

        // find root element of slide
        var clickedListItem = closest(eTarget, function(el) {
            return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
        });

        if(!clickedListItem) {
            return;
        }
        

        // find index of clicked item by looping through all child nodes
        // alternatively, you may define index via data- attribute
        var clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;

        for (var i = 0; i < numChildNodes; i++) {
            if(childNodes[i].nodeType !== 1) { 
                continue; 
            }

            if(childNodes[i] === clickedListItem) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }



        if(index >= 0) {
            // open PhotoSwipe if valid index found
            console.log(index);
            console.log(clickedGallery);
            openPhotoSwipe( index, clickedGallery );
        }
        return false;
    };

    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
        params = {};

        if(hash.length < 5) {
            return params;
        }

        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if(!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');  
            if(pair.length < 2) {
                continue;
            }           
            params[pair[0]] = pair[1];
        }

        if(params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        return params;
    };

    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
        var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;

        items = parseThumbnailElements(galleryElement);

        // define options (if needed)
        options = {

            // define gallery index (for URL)
            galleryUID: galleryElement.getAttribute('data-pswp-uid'),
            hideAnimationDuration:0, showAnimationDuration:0,
            shareEl: false,
            bgOpacity:.8,
            addCaptionHTMLFn: function(item, captionEl, isFake) {
                // item      - slide object
                // captionEl - caption DOM element
                // isFake    - true when content is added to fake caption container
                //             (used to get size of next or previous caption)

                if(!item.title) {
                    captionEl.children[0].innerHTML = '';
                    return false;
                }
                //captionEl.children[0].innerHTML = "CAPTION";
                captionEl.children[0].innerHTML = item.title;
                return true;
            }
            /*getThumbBoundsFn: function(index) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect(); 

                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
            }*/

        };

        // PhotoSwipe opened from URL
        if(fromURL) {
            if(options.galleryPIDs) {
                // parse real index when custom PIDs are used 
                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                for(var j = 0; j < items.length; j++) {
                    if(items[j].pid == index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                // in URL indexes start from 1
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }

        // exit if index not found
        if( isNaN(options.index) ) {
            return;
        }

        if(disableAnimation) {
            options.showAnimationDuration = 0;
        }

        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.listen('gettingData', function(index, item) {
            if (!item.w || !item.h) {
                /*const innerImgEl = item.el.getElementsByTagName('img')[0]
                if (innerImgEl) {
                item.w = innerImgEl.width
                item.h = innerImgEl.height
                }*/

                const img = new Image();
                img.onload = function () {
                item.w = this.width
                item.h = this.height
                gallery.updateSize(true)
                };
                img.src = item.src;
            }
            });
        gallery.init();
    };

    // loop through all gallery elements and bind events
    var galleryElements = document.querySelectorAll( gallerySelector );

    for(var i = 0, l = galleryElements.length; i < l; i++) {
        galleryElements[i].setAttribute('data-pswp-uid', i+1);
        galleryElements[i].onclick = onThumbnailsClick;
    }

    // Parse URL and open gallery if it contains #&pid=3&gid=1
    var hashData = photoswipeParseHash();
    if(hashData.pid && hashData.gid) {
        openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
    }
};

// execute above function
if (document.querySelector('#species-images')) {
    initPhotoSwipeFromDOM('#species-images');
}

if (document.querySelector('#pictures-gallery')) {
    initPhotoSwipeFromDOM('#pictures-gallery');
}
if (document.querySelector('#earlylife-gallery')) {
    initPhotoSwipeFromDOM('#earlylife-gallery');
}
if (document.querySelector('#diseases-gallery')) {
    initPhotoSwipeFromDOM('#diseases-gallery');
}
if (document.querySelector('#stamps-gallery')) {
    initPhotoSwipeFromDOM('#stamps-gallery');
}
if (document.querySelector('#users-gallery')) {
    initPhotoSwipeFromDOM('#users-gallery');
}

