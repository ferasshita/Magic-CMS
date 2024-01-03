//[Data Table Javascript]

//Project:	Crypto Tokenizer UI Interface & Cryptocurrency Admin Template
//Primary use:   Used only for the Data Table

$(function () {
	"use strict";

	$('#example2').DataTable({
		'paging'      : true,
		'lengthChange': false,
		'searching'   : false,
		// scrollY:        250,
		// deferRender:    true,
		// scroller:       true,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : false
	});


	$('.example').DataTable( {
		'paging'      : true,
		'lengthChange': false,
		// scrollY:        250,
		// deferRender:    true,
		// scroller:       true,
		'searching'   : true,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : true,
		dom: 'Bfrtip',
		buttons: [
			{
				text: 'print',
				action: function (){
					setTimeout(function () {
						window.print();
					}, 500);

				}
			},
			{
				text: 'New bill',
				action: function (){
					$('#sub_bills').click();
				}
			},'copy', 'csv', 'excel', 'pdf'
		]

	} );

	$('.reports_1').DataTable( {
		'paging'      : true,
		'lengthChange': false,
		'searching'   : true,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : true,
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	} );
	$('#reports_2').DataTable( {
		'paging'      : true,
		'lengthChange': false,
		// scrollY:        250,
		// deferRender:    true,
		// scroller:       true,
		'searching'   : true,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : true,
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	} );
	$('.reports_3').DataTable( {
		'paging'      : true,
		'lengthChange': false,
		// scrollY:        250,
		// deferRender:    true,
		// scroller:       true,
		'searching'   : true,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : true,
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	} );
	$('#example_1').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	} );

	$('#tickets').DataTable({
		'paging'      : true,
		'lengthChange': true,
		// scrollY:        250,
		// deferRender:    true,
		// scroller:       true,
		'searching'   : true,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : false,
	});

	$('#productorder').DataTable({
		'paging'      : true,
		'lengthChange': true,
		// scrollY:        250,
		// deferRender:    true,
		// scroller:       true,
		'searching'   : true,
		'ordering'    : true,
		'info'        : true,
		'autoWidth'   : false,
	});


	$('#complex_header').DataTable();

	//--------Individual column searching

	// Setup - add a text input to each footer cell
	$('#example5 tfoot th').each( function () {
		var title = $(this).text();
		$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
	} );

	// DataTable
	var table = $('#example5').DataTable();

	// Apply the search
	table.columns().every( function () {
		var that = this;

		$( 'input', this.footer() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) {
				that
					.search( this.value )
					.draw();
			}
		} );
	} );


	//---------------Form inputs
	var table = $('#example6').DataTable();






}); // End of use strict
