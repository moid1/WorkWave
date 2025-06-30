/*
 Template Name: Admiry - Bootstrap 4 Admin Dashboard
 Author: Themesdesign
 Website: www.themesdesign.in
 File: Datatable js
 */

$(document).ready(function() {
    $('#datatable').DataTable();

    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

        $('#datatable').on('init.dt', function () {
        // Attach event to the default search box
        $('#datatable_wrapper input[type="search"]').off().on('keyup', function () {
            var searchTerm = this.value.trim();
            // Use exact match with regex
            table.search('^' + searchTerm + '$', true, false).draw();
        });
    });
} );