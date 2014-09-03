/*! ==========================================================
*   playdown.js: app.js
*   Author(s): Corbin Matschull & Daniel Jajliardo
*
*   ==========================================================
*
*   Published under an MIT license:
*   (https://github.com/Spritsinz/ChatsphereSoftware/blob/master/LICENSE)
*
*  =========================================================== */
if(typeof jQuery === 'undefined'){ throw new Error('app.js requires jQuery to function!'); }



/*!  ========================================================
*    playdown.js: navbarcheck.js
*    Author(s): Corbin Matschull & Daniel Jajliardo
*     
*    ========================================================
*
*    Published under an MIT license
*	 (https://github.com/Spritsinz/ChatsphereSoftware/blob/master/LICENSE)
*
*    ======================================================== */
+function($){
	'use strict';


	var top 	  = document.scrollTop(),
		nav 	  = $('.navbar-inverse'),
		navOffset = nav.offset(),
		body	  = $('body'),
		isAway	  = false;

	function isAwayFromTop(element, window){
		if(top > 0 && navOffset.top > 0){
			nav.setAttribute('nav-top', 'nav-offset');
			nav.css({'background-color' : 'white'});
		}
		if(top < 0 && navOffset.top < 0){
			nav.setAttribute('nav-offset', 'nav-top');
			nav.css({'background-color' : 'transparent'});
		}
	}
}
