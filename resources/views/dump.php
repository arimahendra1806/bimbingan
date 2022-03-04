<!-- {{-- <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/af-2.3.7/b-2.2.1/b-colvis-2.2.1/b-html5-2.2.1/b-print-2.2.1/cr-1.5.5/date-1.1.1/fc-4.0.1/fh-3.2.1/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.0/sp-1.4.0/sl-1.3.4/sr-1.1.0/datatables.min.js"></script> --}}
    {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/sl-1.3.4/sr-1.1.0/datatables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script> --}} -->
    <!-- {{-- <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script> --}} -->

    <!-- {{-- <th><input type="checkbox" name="select_all" value="1" id="select-all"></th> --}} -->

    <!-- // var rows_selected = []; -->

    <!-- // { data: null, name: 'select_all'}, -->

    <!-- // {
    //     render: function (data, type, full, meta){
    //         return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
    //     }, targets: [0]
    // } -->


    <!-- // rowCallback: function(row, data, dataIndex){
    //     // Get row ID
    //     var rowId = data[0];

    //     // If row ID is in the list of selected row IDs
    //     if($.inArray(rowId, rows_selected) !== -1){
    //         $(row).find('input[type="checkbox"]').prop('checked', true);
    //         $(row).addClass('selected');
    //     }
    // } -->

    <!-- /* Button Checkbox All */
    $('#select-all').on('click', function(){
        // Get all rows with search applied
        var rows = table.rows({ search: 'applied' }).nodes();
        // Check/uncheck checkboxes for all rows in the table
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Handle click on checkbox to set state of "Select all" control
    $('#TahunAjaranTabels tbody').on('change', 'input[type="checkbox"]', function(){
        // If checkbox is not checked
        if(!this.checked){
            var el = $('#select-all').get(0);
            // If "Select all" control is checked and has 'indeterminate' property
            if(el && el.checked && ('indeterminate' in el)){
                // Set visual state of "Select all" control
                // as 'indeterminate'
                el.indeterminate = true;
            }
        }
    }); -->


<!-- <script>
    // function updateDataTableSelectAllCtrl(table){
    //     var $table             = table.table().node();
    //     var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
    //     var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
    //     var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

    //     // If none of the checkboxes are checked
    //     if($chkbox_checked.length === 0){
    //         chkbox_select_all.checked = false;
    //         if('indeterminate' in chkbox_select_all){
    //             chkbox_select_all.indeterminate = false;
    //         }

    //     // If all of the checkboxes are checked
    //     } else if ($chkbox_checked.length === $chkbox_all.length){
    //         chkbox_select_all.checked = true;
    //         if('indeterminate' in chkbox_select_all){
    //             chkbox_select_all.indeterminate = false;
    //         }

    //     // If some of the checkboxes are checked
    //     } else {
    //         chkbox_select_all.checked = true;
    //         if('indeterminate' in chkbox_select_all){
    //             chkbox_select_all.indeterminate = true;
    //         }
    //     }
    // }

    // // Handle click on checkbox
    // $('#example tbody').on('click', 'input[type="checkbox"]', function(e){
    //     var $row = $(this).closest('tr');

    //     // Get row data
    //     var data = table.row($row).data();

    //     // Get row ID
    //     var rowId = data[0];

    //     // Determine whether row ID is in the list of selected row IDs
    //     var index = $.inArray(rowId, rows_selected);

    //     // If checkbox is checked and row ID is not in list of selected row IDs
    //     if(this.checked && index === -1){
    //         rows_selected.push(rowId);

    //     // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
    //     } else if (!this.checked && index !== -1){
    //         rows_selected.splice(index, 1);
    //     }

    //     if(this.checked){
    //         $row.addClass('selected');
    //     } else {
    //         $row.removeClass('selected');
    //     }

    //     // Update state of "Select all" control
    //     updateDataTableSelectAllCtrl(table);

    //     // Prevent click event from propagating to parent
    //     e.stopPropagation();
    // });

    // // Handle click on table cells with checkboxes
    // $('#example').on('click', 'tbody td, thead th:first-child', function(e){
    //     $(this).parent().find('input[type="checkbox"]').trigger('click');
    // });

    // // Handle click on "Select all" control
    // $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
    //     if(this.checked){
    //         $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
    //     } else {
    //         $('#example tbody input[type="checkbox"]:checked').trigger('click');
    //     }

    //     // Prevent click event from propagating to parent
    //     e.stopPropagation();
    // });

    // // Handle table draw event
    // table.on('draw', function(){
    //     // Update state of "Select all" control
    //     updateDataTableSelectAllCtrl(table);
    // });
</script> -->

<!-- select: true,
buttons: [
    {
        text: 'Select all',
        action: function () {
            table.rows().select();
        }
    },
    {
        text: 'Select none',
        action: function () {
            table.rows().deselect();
        }
    }
], -->

<!-- $param = "69";
$guru = TahunAjaran::onlyTrashed()->where('id',$param);
$guru->restore(); -->

<!-- // return '<a href="'. route('edit.tahun.ajaran.koor', $model->id) .'">Edit</a>'; -->

<!-- // $phone = "+6285335786589";
// $this->whatsappNotification($phone);

// $details = [
//     'title' => 'Mail from Online Web Tutor',
//     'body' => 'Berhasil Update Tahun Ajaran.'
// ];

// Mail::to('arimahendra1806@gmail.com')->send(new \App\Mail\MailController($details)); -->

<!-- private function whatsappNotification(string $recipient)
{
    $sid    = getenv("TWILIO_AUTH_SID");
    $token  = getenv("TWILIO_AUTH_TOKEN");
    $wa_from= getenv("TWILIO_WHATSAPP_FROM");
    $twilio = new Client($sid, $token);

    $body = "Hello!!";

    return $twilio->messages->create("whatsapp:$recipient",["from" => "whatsapp:$wa_from", "body" => $body]);
} -->
