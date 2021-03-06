/**
* jquery.elastislide.js v1.1.0
* http://www.codrops.com
*
* Licensed under the MIT license.
* http://www.opensource.org/licenses/mit-license.php
* 
* Copyright 2012, Codrops
* http://www.codrops.com
*/
;( function( $, window, undefined ) {
'use strict';
var $event = $.event,
$special,
resizeTimeout;
$special = $event.special.debouncedresize = {
setup: function() {
$( this ).on( "resize", $special.handler );
},
teardown: function() {
$( this ).off( "resize", $special.handler );
},
handler: function( event, execAsap ) {
var context = this,
args = arguments,
dispatch = function() {
event.type = "debouncedresize";
$event.dispatch.apply( context, args );
};
if ( resizeTimeout ) {
clearTimeout( resizeTimeout );
}
execAsap ?
dispatch() :
resizeTimeout = setTimeout( dispatch, $special.threshold );
},
threshold: 150
};
var BLANK = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';
$.fn.imagesLoaded = function( callback ) {
var $this = this,
deferred = $.isFunction($.Deferred) ? $.Deferred() : 0,
hasNotify = $.isFunction(deferred.notify),
$images = $this.find('img').add( $this.filter('img') ),
loaded = [],
proper = [],
broken = [];
if ($.isPlainObject(callback)) {
$.each(callback, function (key, value) {
if (key === 'callback') {
callback = value;
} else if (deferred) {
deferred[key](value);
}
});
}
function doneLoading() {
var $proper = $(proper),
$broken = $(broken);
if ( deferred ) {
if ( broken.length ) {
deferred.reject( $images, $proper, $broken );
} else {
deferred.resolve( $images );
}
}
if ( $.isFunction( callback ) ) {
callback.call( $this, $images, $proper, $broken );
}
}
function imgLoaded( img, isBroken ) {
if ( img.src === BLANK || $.inArray( img, loaded ) !== -1 ) {
return;
}
loaded.push( img );
if ( isBroken ) {
broken.push( img );
} else {
proper.push( img );
}
$.data( img, 'imagesLoaded', { isBroken: isBroken, src: img.src } );
if ( hasNotify ) {
deferred.notifyWith( $(img), [ isBroken, $images, $(proper), $(broken) ] );
}
if ( $images.length === loaded.length ){
setTimeout( doneLoading );
$images.unbind( '.imagesLoaded' );
}
}
if ( !$images.length ) {
doneLoading();
} else {
$images.bind( 'load.imagesLoaded error.imagesLoaded', function( event ){
imgLoaded( event.target, event.type === 'error' );
}).each( function( i, el ) {
var src = el.src;
var cached = $.data( el, 'imagesLoaded' );
if ( cached && cached.src === src ) {
imgLoaded( el, cached.isBroken );
return;
}
if ( el.complete && el.naturalWidth !== undefined ) {
imgLoaded( el, el.naturalWidth === 0 || el.naturalHeight === 0 );
return;
}
if ( el.readyState || el.complete ) {
el.src = BLANK;
el.src = src;
}
});
}
return deferred ? deferred.promise( $this ) : $this;
};
var $window = $( window ),
Modernizr = window.Modernizr;
$.Elastislide = function( options, element ) {
this.$el = $( element );
this._init( options );
};
$.Elastislide.defaults = {
orientation : 'horizontal',
speed : 500,
easing : 'ease-in-out',
minItems : 3,
start : 0,
onClick : function( el, position, evt ) { return false; },
onReady : function() { return false; },
onBeforeSlide : function() { return false; },
onAfterSlide : function() { return false; }
};
$.Elastislide.prototype = {
_init : function( options ) {
this.options = $.extend( true, {}, $.Elastislide.defaults, options );
var self = this,
transEndEventNames = {
'WebkitTransition' : 'webkitTransitionEnd',
'MozTransition' : 'transitionend',
'OTransition' : 'oTransitionEnd',
'msTransition' : 'MSTransitionEnd',
'transition' : 'transitionend'
};
this.transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ];
this.support = Modernizr.csstransitions && Modernizr.csstransforms;
this.current = this.options.start;
this.isSliding = false;
this.$items = this.$el.children( 'li' );
this.itemsCount = this.$items.length;
if( this.itemsCount === 0 ) {
return false;
}
this._validate();
this.$items.detach();
this.$el.empty();
this.$el.append( this.$items );
this.$el.wrap( '<div class="elastislide-wrapper elastislide-loading elastislide-' + this.options.orientation + '"></div>' );
this.hasTransition = false;
this.hasTransitionTimeout = setTimeout( function() {
self._addTransition();
}, 100 );
this.$el.imagesLoaded( function() {
self.$el.show();
self._layout();
self._configure();
if( self.hasTransition ) {
self._removeTransition();
self._slideToItem( self.current );
self.$el.on( self.transEndEventName, function() {
self.$el.off( self.transEndEventName );
self._setWrapperSize();
self._addTransition();
self._initEvents();
} );
}
else {
clearTimeout( self.hasTransitionTimeout );
self._setWrapperSize();
self._initEvents();
self._slideToItem( self.current );
setTimeout( function() { self._addTransition(); }, 25 );
}
self.options.onReady();
} );
},
_validate : function() {
if( this.options.speed < 0 ) {
this.options.speed = 500;
}
if( this.options.minItems < 1 || this.options.minItems > this.itemsCount ) {
this.options.minItems = 1;
}
if( this.options.start < 0 || this.options.start > this.itemsCount - 1 ) {
this.options.start = 0;
}
if( this.options.orientation != 'horizontal' && this.options.orientation != 'vertical' ) {
this.options.orientation = 'horizontal';
}
},
_layout : function() {
this.$el.wrap( '<div class="elastislide-carousel"></div>' );
this.$carousel = this.$el.parent();
this.$wrapper = this.$carousel.parent().removeClass( 'elastislide-loading' );
var $img = this.$items.find( 'img:first' );
this.imgSize = { width : $img.outerWidth( true ), height : $img.outerHeight( true ) };
this._setItemsSize();
this.options.orientation === 'horizontal' ? this.$el.css( 'max-height', this.imgSize.height ) : this.$el.css( 'height', this.options.minItems * this.imgSize.height );
this._addControls();
},
_addTransition : function() {
if( this.support ) {
this.$el.css( 'transition', 'all ' + this.options.speed + 'ms ' + this.options.easing );
}
this.hasTransition = true;
},
_removeTransition : function() {
if( this.support ) {
this.$el.css( 'transition', 'all 0s' );
}
this.hasTransition = false;
},
_addControls : function() {
var self = this;
this.$navigation = $( '<nav><span class="elastislide-prev">Previous</span><span class="elastislide-next">Next</span></nav>' )
.appendTo( this.$wrapper );
this.$navPrev = this.$navigation.find( 'span.elastislide-prev' ).on( 'mousedown.elastislide', function( event ) {
self._slide( 'prev' );
return false;
} );
this.$navNext = this.$navigation.find( 'span.elastislide-next' ).on( 'mousedown.elastislide', function( event ) {
self._slide( 'next' );
return false;
} );
},
_setItemsSize : function() {
var w = this.options.orientation === 'horizontal' ? ( Math.floor( this.$carousel.width() / this.options.minItems ) * 100 ) / this.$carousel.width() : 100;
this.$items.css( {
'width' : w + '%',
'max-width' : this.imgSize.width,
'max-height' : this.imgSize.height
} );
if( this.options.orientation === 'vertical' ) {
this.$wrapper.css( 'max-width', this.imgSize.width + parseInt( this.$wrapper.css( 'padding-left' ) ) + parseInt( this.$wrapper.css( 'padding-right' ) ) );
}
},
_setWrapperSize : function() {
if( this.options.orientation === 'vertical' ) {
this.$wrapper.css( {
'height' : this.options.minItems * this.imgSize.height + parseInt( this.$wrapper.css( 'padding-top' ) ) + parseInt( this.$wrapper.css( 'padding-bottom' ) )
} );
}
},
_configure : function() {
this.fitCount = this.options.orientation === 'horizontal' ? 
this.$carousel.width() < this.options.minItems * this.imgSize.width ? this.options.minItems : Math.floor( this.$carousel.width() / this.imgSize.width ) :
this.$carousel.height() < this.options.minItems * this.imgSize.height ? this.options.minItems : Math.floor( this.$carousel.height() / this.imgSize.height );
},
_initEvents : function() {
var self = this;
$window.on( 'debouncedresize.elastislide', function() {
self._setItemsSize();
self._configure();
self._slideToItem( self.current );
} );
this.$el.on( this.transEndEventName, function() {
self._onEndTransition();
} );
if( this.options.orientation === 'horizontal' ) {
this.$el.on( {
swipeleft : function() {
self._slide( 'next' );
},
swiperight : function() {
self._slide( 'prev' );
}
} );
}
else {
this.$el.on( {
swipeup : function() {
self._slide( 'next' );
},
swipedown : function() {
self._slide( 'prev' );
}
} );
}
this.$el.on( 'click.elastislide', 'li', function( event ) {
var $item = $( this );
self.options.onClick( $item, $item.index(), event );
});
},
_destroy : function( callback ) {
this.$el.off( this.transEndEventName ).off( 'swipeleft swiperight swipeup swipedown .elastislide' );
$window.off( '.elastislide' );
this.$el.css( {
'max-height' : 'none',
'transition' : 'none'
} ).unwrap( this.$carousel ).unwrap( this.$wrapper );
this.$items.css( {
'width' : 'auto',
'max-width' : 'none',
'max-height' : 'none'
} );
this.$navigation.remove();
this.$wrapper.remove();
if( callback ) {
callback.call();
}
},
_toggleControls : function( dir, display ) {
if( display ) {
( dir === 'next' ) ? this.$navNext.show() : this.$navPrev.show();
}
else {
( dir === 'next' ) ? this.$navNext.hide() : this.$navPrev.hide();
}
},
_slide : function( dir, tvalue ) {
if( this.isSliding ) {
return false;
}
this.options.onBeforeSlide();
this.isSliding = true;
var self = this,
translation = this.translation || 0,
itemSpace = this.options.orientation === 'horizontal' ? this.$items.outerWidth( true ) : this.$items.outerHeight( true ),
totalSpace = this.itemsCount * itemSpace,
visibleSpace = this.options.orientation === 'horizontal' ? this.$carousel.width() : this.$carousel.height();
if( tvalue === undefined ) {
var amount = this.fitCount * itemSpace;
if( amount < 0 ) {
return false;
}
if( dir === 'next' && totalSpace - ( Math.abs( translation ) + amount ) < visibleSpace ) {
amount = totalSpace - ( Math.abs( translation ) + visibleSpace );
this._toggleControls( 'next', false );
this._toggleControls( 'prev', true );
}
else if( dir === 'prev' && Math.abs( translation ) - amount < 0 ) {
amount = Math.abs( translation );
this._toggleControls( 'next', true );
this._toggleControls( 'prev', false );
}
else {
var ftv = dir === 'next' ? Math.abs( translation ) + Math.abs( amount ) : Math.abs( translation ) - Math.abs( amount );
ftv > 0 ? this._toggleControls( 'prev', true ) : this._toggleControls( 'prev', false );
ftv < totalSpace - visibleSpace ? this._toggleControls( 'next', true ) : this._toggleControls( 'next', false );
}
tvalue = dir === 'next' ? translation - amount : translation + amount;
}
else {
var amount = Math.abs( tvalue );
if( Math.max( totalSpace, visibleSpace ) - amount < visibleSpace ) {
tvalue	= - ( Math.max( totalSpace, visibleSpace ) - visibleSpace );
}
amount > 0 ? this._toggleControls( 'prev', true ) : this._toggleControls( 'prev', false );
Math.max( totalSpace, visibleSpace ) - visibleSpace > amount ? this._toggleControls( 'next', true ) : this._toggleControls( 'next', false );
}
this.translation = tvalue;
if( translation === tvalue ) {
this._onEndTransition();
return false;
}
if( this.support ) {
this.options.orientation === 'horizontal' ? this.$el.css( 'transform', 'translateX(' + tvalue + 'px)' ) : this.$el.css( 'transform', 'translateY(' + tvalue + 'px)' );
}
else {
$.fn.applyStyle = this.hasTransition ? $.fn.animate : $.fn.css;
var styleCSS = this.options.orientation === 'horizontal' ? { left : tvalue } : { top : tvalue };
this.$el.stop().applyStyle( styleCSS, $.extend( true, [], { duration : this.options.speed, complete : function() {
self._onEndTransition();
} } ) );
}
if( !this.hasTransition ) {
this._onEndTransition();
}
},
_onEndTransition : function() {
this.isSliding = false;
this.options.onAfterSlide();
},
_slideTo : function( pos ) {
var pos = pos || this.current,
translation = Math.abs( this.translation ) || 0,
itemSpace = this.options.orientation === 'horizontal' ? this.$items.outerWidth( true ) : this.$items.outerHeight( true ),
posR = translation + this.$carousel.width(),
ftv = Math.abs( pos * itemSpace );
if( ftv + itemSpace > posR || ftv < translation ) {
this._slideToItem( pos );
}
},
_slideToItem : function( pos ) {
var amount	= this.options.orientation === 'horizontal' ? pos * this.$items.outerWidth( true ) : pos * this.$items.outerHeight( true );
this._slide( '', -amount );
},
add : function( callback ) {
var self = this,
oldcurrent = this.current,
$currentItem = this.$items.eq( this.current );
this.$items = this.$el.children( 'li' );
this.itemsCount = this.$items.length;
this.current = $currentItem.index();
this._setItemsSize();
this._configure();
this._removeTransition();
oldcurrent < this.current ? this._slideToItem( this.current ) : this._slide( 'next', this.translation );
setTimeout( function() { self._addTransition(); }, 25 );
if ( callback ) {
callback.call();
}
},
setCurrent : function( idx, callback ) {
this.current = idx;
this._slideTo();
if ( callback ) {
callback.call();
}
},
next : function() {
self._slide( 'next' );
},
previous : function() {
self._slide( 'prev' );
},
slideStart : function() {
this._slideTo( 0 );
},
slideEnd : function() {
this._slideTo( this.itemsCount - 1 );
},
destroy : function( callback ) {
this._destroy( callback );
}
};
var logError = function( message ) {
if ( window.console ) {
window.console.error( message );
}
};
$.fn.elastislide = function( options ) {
var self = $.data( this, 'elastislide' );
if ( typeof options === 'string' ) {
var args = Array.prototype.slice.call( arguments, 1 );
this.each(function() {
if ( !self ) {
logError( "cannot call methods on elastislide prior to initialization; " +
"attempted to call method '" + options + "'" );
return;
}
if ( !$.isFunction( self[options] ) || options.charAt(0) === "_" ) {
logError( "no such method '" + options + "' for elastislide self" );
return;
}
self[ options ].apply( self, args );
});
} 
else {
this.each(function() {
if ( self ) {
self._init();
}
else {
self = $.data( this, 'elastislide', new $.Elastislide( options, this ) );
}
});
}
return self;
};
} )( jQuery, window );
