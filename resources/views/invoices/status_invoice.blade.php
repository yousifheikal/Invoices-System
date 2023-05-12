@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
    تغيير حالة الدفع
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تغيير حالة الدفع</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- row -->
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('change.status', $invoice->id) }}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                            @csrf
                            {{-- 1 --}}

                            <div class="row">

                                <input type="hidden" class="form-control" id="invoice_id" name="invoice_id" value="{{$invoice->id}}">

                                <div class="col">
                                    <label for="inputName" class="control-label">رقم الفاتورة</label>
                                    <input type="text" class="form-control" id="inputName" name="invoice_number"
                                           value="{{$invoice->invoice_number}}" required readonly>
                                </div>

                                <div class="col">
                                    <label>تاريخ الفاتورة</label>
                                    <input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD"
                                           type="text" value="{{$invoice->invoice_Date}}" required readonly>
                                </div>

                                <div class="col">
                                    <label>تاريخ الاستحقاق</label>
                                    <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                           value="{{$invoice->Due_date}}" type="text" required readonly>
                                </div>

                            </div>

                            {{-- 2 --}}
                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">القسم</label>
                                    <input type="text" class="form-control" id="section" name="section"
                                           value="{{$invoice->section_id}}" required readonly>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">المنتج</label>
                                    <input type="text" class="form-control" id="product" name="product"
                                           value="{{$invoice->product}}" required readonly>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">مبلغ التحصيل</label>
                                    <input type="text" class="form-control" id="inputName" name="Amount_collection"
                                           value="{{$invoice->Amount_collection}}" readonly>
                                </div>
                            </div>


                            {{-- 3 --}}

                            <div class="row">

                                <div class="col">
                                    <label for="inputName" class="control-label">مبلغ العمولة</label>
                                    <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                           name="Amount_Commission" value="{{$invoice->Amount_Commission}}"
                                           required readonly>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">الخصم</label>
                                    <input type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                                           value="{{$invoice->Discount}}" required readonly>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                    <input type="text" class="form-control form-control-lg" id="Rate_VAT" name="Rate_VAT"
                                           value="{{$invoice->Rate_Vat}}" required readonly>
                                </div>

                            </div>

                            {{-- 4 --}}

                            <div class="row">
                                <div class="col">
                                    <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                    <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" value="{{$invoice->Value_Vat}}" readonly>
                                </div>

                                <div class="col">
                                    <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                    <input type="text" class="form-control" id="Total" name="Total" value="{{$invoice->Total}}" readonly>
                                </div>
                            </div>

                            {{-- 5 --}}
                            <div class="row">
                                <div class="col">
                                    <label for="exampleTextarea">ملاحظات</label>
                                    <textarea class="form-control" id="exampleTextarea" name="note" readonly rows="3">{{$invoice->note}}</textarea>
                                </div>
                            </div><br>

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label">حالة الدفع</label>
                                <select name="status" id="status" class="form-control" required>
                                    <!--placeholder-->
                                    <option value="" selected disabled>--حدد حالة الدفع--</option>
                                    <option value="مدفوعة">مدفوعة</option>
                                    <option value="مدفوعة جزائيا">مدفوعة جزائيا</option>
                                </select>
                            </div>

                            <div class="col">
                                <label>تاريخ الدفع</label>
                                <input class="form-control fc-datepicker" name="Payment_date" placeholder="YYYY-MM-DD"
                                       value="{{ old('due_date') }}" type="text" required>
                            </div>

                        </div>
                        <br>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">تحديث حالة الدفع</button>
                            </div>

                        </form>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

@endsection
