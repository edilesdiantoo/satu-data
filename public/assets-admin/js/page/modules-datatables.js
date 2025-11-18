"use strict";

$("[data-checkboxes]").each(function() {
  var me = $(this),
    group = me.data('checkboxes'),
    role = me.data('checkbox-role');

  me.change(function() {
    var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
      checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
      dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
      total = all.length,
      checked_length = checked.length;

    if(role == 'dad') {
      if(me.is(':checked')) {
        all.prop('checked', true);
      }else{
        all.prop('checked', false);
      }
    }else{
      if(checked_length >= total) {
        dad.prop('checked', true);
      }else{
        dad.prop('checked', false);
      }
    }
  });
});



$("#table-1").dataTable({
  "columnDefs": [
    { "sortable": false, 
  }
  ],
  
});
$("#table-2").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [0,2,3] }
  ]
});

$('#table-3 thead tr').clone(true).appendTo('#table-3 thead');
            $('#table-3 thead tr:eq(1) th').each(function(i) {
                if (!$(this).hasClass("noFilter")) {
                    var title = $(this).text();
                    $(this).html('<input type="text" placeholder="Search ' + title.toLowerCase() + '" />');

                    $('input', this).on('keyup change', function() {
                        if (table.column(i).search() !== this.value) {
                            table
                                .column(i)
                                .search(this.value)
                                .draw();
                        }
                    });
                } else {
                    $(this).html('<span></span>');
                }

            });

            var table = $('#table-3').DataTable({
                orderCellsTop: true,
                fixedHeader: false,
                columnDefs: [{
                    targets: 0,
                    visible: true
                }]
            });
