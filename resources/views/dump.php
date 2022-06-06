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

<!-- if($data->bimbingan->progres)
        {
            $data->bimbingan->progres->bimbingan_kode = $kb;
            $data->bimbingan->progres->save();
        }

        if($data->bimbingan)
        {
            $arr_id = $data->bimbingan->pluck('id')->toArray();
            for($i = 0; $i < count($arr_id); $i++)
            {
                BimbinganModel::where('id', $arr_id[$i])->update(['kode_bimbingan' => $kb, 'pembimbing_kode' => $kp]);
            }
        }

        $data->kode_pembimbing = $kp; -->



        <!-- Card Konsultasi -->
        <!-- <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Konsultasi Judul</h4>
                        <p class="card-title-desc">
                            Lengkapi form berikut untuk melakukan <b>konsultasi</b>, silahkan upload file hasil pengerjaan
                            kalian.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <h4 class="card-title text-danger"><i class="fas fa-exclamation-triangle"></i> | Peringatan</h4>
                            <p>
                                Pastikan Anda <b>sudah membaca</b> materi dari <b>Dosen Pembimbing</b>, sebelum melakukan
                                <b>konsultasi</b>.
                            </p>
                            <hr>
                            <div class="row mb-1">
                                <div class="col-md-4">
                                    <label for="kode_bimbingan" class="col-form-label">Kode Bimbingan: <b
                                            class="info">*Otomatis Terisi</b></label>
                                    <input type="text" class="form-control" id="kode_bimbingan" name="kode_bimbingan"
                                        value="{{ $detail['kode_bimbingan'] }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="tahun_ajaran_id" class="col-form-label">Tahun Ajaran: <b
                                            class="info">*Otomatis Terisi</b></label>
                                    <input type="text" class="form-control" id="tahun_ajaran_id" name="tahun_ajaran_id"
                                        value="{{ $tahun_id->tahun_ajaran }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="status_konsultasi" class="col-form-label">Status: <b
                                            class="info">*Otomatis Terisi</b></label>
                                    <input type="text" class="form-control" id="status_konsultasi"
                                        name="status_konsultasi" value="{{ $detail['status_konsultasi'] }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <label for="keterangan" class="col-form-label">Keterangan Konsultasi Sebelumnya: <b
                                            class="info">*Otomatis Terisi</b></label><br>
                                    <textarea class="form-control" name="keterangan" id="keterangan" style="width: 100%" rows="3" aria-valuetext=""
                                        readonly>{{ $detail['keterangan'] }}</textarea>
                                </div>
                            </div>
                            <form id="Store" enctype="multipart/form-data" files="true">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="file_upload" class="col-form-label">File Upload: <b
                                                class="error">*Pastikan format PDF | Max 2MB</b></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control no-outline" id="fileShow" name="fileShow"
                                                value="{{ $detail['file'] }}" style="display: none" readonly>
                                            <a href="javascript:void(0)" class="btn btn-info waves-effect waves-light"
                                                type="button" data-toggle="tooltip" title="Pertinjau File" id="btnShow">
                                                <i class="far fa-file-pdf"></i>
                                            </a>
                                        </div>
                                        <input type="file" class="form-control" id="file_upload" name="file_upload">
                                        <span class="text-danger error-text file_upload_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <input type="submit" class="btn btn-primary" name="addSave"
                                            value="Konsultasi Sekarang">
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <h4 class="card-title text-secondary"><i class="far fa-comments"> Kolom Diskusi</i></h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="komen" class="col-form-label text-secondary">Ketikan Komentar :</label>
                                    <form class="row gx-3 gy-2 align-items-center" id="KomenStore">
                                        @csrf
                                        <div class="hstack gap-3">
                                            <input class="form-control me-auto" type="text"
                                                placeholder="Ketik pesan anda disini.." id="komentar" name="komentar">
                                            <span class="text-danger error-text komentar_error"></span>
                                            <input type="submit" class="btn btn-outline-primary" name="komenSave"
                                                value="Kirim">
                                            <div class="vr"></div>
                                            <button type="reset" class="btn btn-outline-danger">Reset</button>
                                            <a type="button" class="btn btn-outline-success" data-toggle="tooltip"
                                                title="Refresh Komentar" id="btnRefresh"><i class="fas fa-sync-alt"></i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <table class="table dt-responsive nowrap w-100 borderless" id="KomenTabels">
                                        <thead style="display: none;">
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->


        <!-- {{-- <h4 class="card-title text-danger"><i class="fas fa-exclamation-triangle"></i> | Peringatan
                        </h4>
                        <p>
                            Pastikan Anda <b>sudah membaca</b> materi dari <b>Dosen Pembimbing</b>, sebelum melakukan
                            <b>konsultasi</b>.
                        </p>
                        <hr>
                        <div class="row mb-1">
                            <div class="col-md-4">
                                <label for="kode_bimbingan" class="col-form-label">Kode Bimbingan: <b
                                        class="info">*Otomatis Terisi</b></label>
                                <input type="text" class="form-control" id="kode_bimbingan" name="kode_bimbingan"
                                    value="{{ $detail['kode_bimbingan'] }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="tahun_ajaran_id" class="col-form-label">Tahun Ajaran: <b
                                        class="info">*Otomatis Terisi</b></label>
                                <input type="text" class="form-control" id="tahun_ajaran_id" name="tahun_ajaran_id"
                                    value="{{ $tahun_id->tahun_ajaran }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="status_konsultasi" class="col-form-label">Status: <b
                                        class="info">*Otomatis Terisi</b></label>
                                <input type="text" class="form-control" id="status_konsultasi" name="status_konsultasi"
                                    value="{{ $detail['status_konsultasi'] }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="keterangan" class="col-form-label">Keterangan Konsultasi Sebelumnya: <b
                                        class="info">*Otomatis Terisi</b></label><br>
                                <textarea class="form-control" name="keterangan" id="keterangan" style="width: 100%" rows="3" aria-valuetext=""
                                    readonly>{{ $detail['keterangan'] }}</textarea>
                            </div>
                        </div>
                        <form id="Store">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="link_upload" class="col-form-label">Link Video: <b
                                            class="error">*Pastikan upload di Youtube</b></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control no-outline" id="linkShow" name="linkShow"
                                            value="{{ $detail['link'] }}" style="display: none" readonly>
                                        <a class="btn btn-info waves-effect waves-light image-popup-video-map"
                                            type="button" data-toggle="tooltip" title="Pertinjau Video" id="btnShow">
                                            <i class="fab fa-youtube-square"></i>
                                        </a>
                                    </div>
                                    <input type="text" class="form-control" id="link_upload" name="link_upload">
                                    <span class="text-danger error-text link_upload_error"></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <input type="submit" class="btn btn-primary" name="addSave"
                                        value="Simpan">
                                </div>
                            </div>
                        </form> --}} -->


        <!-- var lightboxvideo = GLightbox({
            selector: ".image-popup-video-map"
        }); -->


        <!-- /* Function detail link video */
            function linkVideo() {
                // var getLink = document.getElementById('linkShow').value;
                // getLink = getLink.replace('https://', '//');

                // lightboxvideo.setElements([{
                //     href: getLink
                // }]);
            } -->


            <!-- <div class="row mb-1">
                                <div class="col-md-12">
                                    <label for="linkShow" class="col-form-label">Video Konsultasi Program:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control no-outline" id="linkShow" name="linkShow"
                                            readonly>
                                        <a class="btn btn-info waves-effect waves-light image-popup-video-map" type="button"
                                            data-toggle="tooltip" title="Pertinjau Video" id="btnShow">
                                            <i class="fab fa-youtube-square"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <form id="Store">
                                    @csrf
                                    <input type="hidden" name="kd" id="kd">
                                    <div class="col-md-12 mb-3">
                                        <label for="keterangan" class="col-form-label">Keterangan:</label><br>
                                        <textarea class="form-control" name="keterangan" id="keterangan" style="width: 100%" rows="3"></textarea>
                                        <span class="text-danger error-text keterangan_error"></span>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <input type="submit" class="btn btn-primary" name="addSave"
                                            value="Perbarui Peninjauan">
                                    </div>
                                </form>
                            </div> -->
