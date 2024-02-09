/*
Name: 			Tables / Advanced - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.4.1
*/

(function( $ ) {

	'use strict';

	var datatableInit = function() {

		$('#datatable-default').dataTable({
		    "pageLength":100
		     // "order": [[ 1, "desc" ]]
		});

	};

	$(function() {
		datatableInit();
	});

}).apply( this, [ jQuery ]);