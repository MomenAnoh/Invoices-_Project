@extends('layouts.master')
@section('title')
    قائمة الفواتير
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('delete'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    // الي جاي دا نوع الانوتيفيكشن 
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('restore_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم ا الفاتورة بنجاح",
                    // الي جاي دا نوع الانوتيفيكشن 
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('arshive'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم ارشفة الفاتورة بنجاح",
                    // الي جاي دا نوع الانوتيفيكشن 
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('Status_Update'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تحديث حالة الفاتورة  بنجاح",
                    // الي جاي دا نوع الانوتيفيكشن 
                    type: "success"
                })
            }
        </script>
    @endif

    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                            class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>


                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="example" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">المنتج</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">مبلغ التحصيل</th>
                                    <th class="border-bottom-0">العمولة</th>
                                    <th class="border-bottom-0">ق ض م</th>
                                    <th class="border-bottom-0">ن ض ق م</th>
                                    <th class="border-bottom-0">الاجمالي</th>
                                    <th class="border-bottom-0">الحالة</th>
                                    <th class="border-bottom-0">الملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>
                                    <th class="border-bottom-0"></th>
                                </tr>
                            </thead>
                            {{-- إذا لم توجد فواتير --}}
                            @if ($shows->isEmpty())
                                <div class="alert alert-danger">
                                    <p>لا توجد فواتير لعرضها.</p>
                                </div>
                            @else
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($shows as $show)
                                        <?php $i++; ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $show->invoice_number }}</td>
                                            <td>{{ $show->invoice_date }}</td>
                                            <td>{{ $show->due_date }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('invoicesdetalis', $show->id) }}">{{ $show->section->section }}</a>
                                            </td>
                                            <td>{{ $show->product }}</td>
                                            <td>{{ $show->Discount }}</td>
                                            <td>{{ $show->Amount_collection }}</td>
                                            <td>{{ $show->Amount_Commission }}</td>
                                            <td>{{ $show->Value_VAT }}</td>
                                            <td>{{ $show->Rate_VAT }}</td>
                                            <td>{{ $show->Total }}</td>
                                            <td>
                                                @if ($show->Value_Status == 1)
                                                    <span class="text-success">{{ $show->Status }}</span>
                                                @elseif($show->Value_Status == 0)
                                                    <span class="text-danger">{{ $show->Status }}</span>
                                                @else
                                                    <span class="text-warning">{{ $show->Status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $show->note }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                        type="button">العمليات<i
                                                            class="fas fa-caret-down ml-1"></i></button>
                                                    <div class="dropdown-menu tx-13">

                                                        <a class="dropdown-item"
                                                            href=" {{ url('edit_invoice', $show->id) }}">تعديل
                                                            الفاتورة</a>



                                                        <a class="dropdown-item" href="#"
                                                            data-invoice_id="{{ $show->id }}" data-toggle="modal"
                                                            data-target="#delete_invoice"><i
                                                                class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                            الفاتورة</a>



                                                        <a class="dropdown-item"
                                                            href="{{ url('status_invoice', $show->id) }}"><i
                                                                class=" text-success fas
                                                        fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                            حالةالدفع</a>


                                                        @can('ارشفة الفاتورة')
                                                            <a class="dropdown-item" href="#"
                                                                data-invoice_id="{{ $show->id }}" data-toggle="modal"
                                                                data-target="#arshive_invoice"><i
                                                                    class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل
                                                                الي الارشيف</a>
                                                        @endcan

                                                        @can('طباعة الفاتورة')
                                                            <a class="dropdown-item"
                                                                href="{{ route('Print_invoice', $show->id) }}"><i
                                                                    class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                                الفاتورة
                                                            </a>
                                                        @endcan


                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>

                        {{-- نموذج الحذف --}}
                        <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('invoices.destroy', $show->id) }}" method="post"
                                        id="deleteForm">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            هل أنت متأكد من عملية الحذف؟
                                            <input type="hidden" name="invoice_id" id="invoice_id" value="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">إلغاء</button>
                                            <button type="submit" class="btn btn-danger">تأكيد</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{--  نموذج الارشفة --}}
                        {{-- هعمل تريكاية هنا تميزلي في بين الحذف والارشفة بم ان الاتني هيروحو علي فانكشن الدستروي هدي الارشفه انبوت هيدين واديالو نيم اي دي واحطله فاليو وهنا في فانكشن الدستروي اعمل اف وافرق بينهم  --}}
                        <div class="modal fade" id="arshive_invoice" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ارشقة الفاتورة</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('invoices.destroy', $show->id) }}" method="post"
                                        id="deleteForm">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            هل أنت متأكد من عملية الارشفة؟
                                            <input type="hidden" name="invoice_id" id="invoice_id" value="">
                                            <input type="hidden" name="arsh_id" id="arsh_id" value="5">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">إلغاء</button>
                                            <button type="submit" class="btn btn-danger">تأكيد</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @endif


                    </div>
                </div>

                <!-- row closed -->
            </div>
            <!-- Container closed -->
        @endsection
        @section('js')
            <!-- Internal Data tables -->
            <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
            <!--Internal  Datatable js -->
            <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

            <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
            <!--Internal  Notify js -->
            <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.0/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.html5.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>


            <script>
                $('#delete_invoice').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var invoice_id = button.data('invoice_id')
                    var modal = $(this)
                    modal.find('.modal-body #invoice_id').val(invoice_id);
                })
            </script>
            <script>
                $('#arshive_invoice').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var invoice_id = button.data('invoice_id')
                    var modal = $(this)
                    modal.find('.modal-body #invoice_id').val(invoice_id);
                })
            </script>




        @endsection
