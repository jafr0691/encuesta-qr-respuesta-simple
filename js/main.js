$ .noConflict ();

jQuery (documento) .ready (función ($) {

	"uso estricto";

	[] .slice.call (document.querySelectorAll ('select.cs-select')) .forEach (function (el) {
		nuevo SelectFx (el);
	});

	jQuery ('. selectpicker'). selectpicker;


	$ ('# menuToggle'). on ('click', function (event) {
		$ ('cuerpo'). toggleClass ('abierto');
	});

	$ ('. search-trigger'). on ('click', function (event) {
		event.preventDefault ();
		event.stopPropagation ();
		$ ('. search-trigger'). parent ('. header-left'). addClass ('open');
	});

	$ ('. search-close'). on ('click', function (event) {
		event.preventDefault ();
		event.stopPropagation ();
		$ ('. search-trigger'). parent ('. header-left'). removeClass ('open');
	});

	// $ ('. user-area> a'). on ('click', function (event) {
	// event.preventDefault ();
	// event.stopPropagation ();
	// $ ('. user-menu'). parent (). removeClass ('open');
	// $ ('. user-menu'). parent (). toggleClass ('open');
	//});
