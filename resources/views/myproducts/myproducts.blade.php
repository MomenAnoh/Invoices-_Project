@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
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


    {{--    دا الفاليدشن بتاع لارافيل جايبو من لارافيل --}}

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- حوار السيشن هيستعدي السيشنز الي اتنا عاملها في الكنترولارز -->
    @if (session()->has('store'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{--           الي جاية دي بتجيب الحاجة الي انما كاتبها في الكنترولار الكلمة الي هتظهر يعني --}}
            <strong>{{ session()->get('store') }}</strong>

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times; </span>
            </button><br><br>
    @endif

    <!-- دي علي الابديت بقا -->
    @if (session()->has('update'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('update') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- دي علي الديليت بقا -->
    @if (session()->has('delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{--                    الي جاية دي بتجيب الحاجة الي انما كاتبها في الكنترولار الكلمة الي هتظهر يعني --}}
            <strong>{{ session()->get('delete') }}</strong>

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times; </span>
            </button><br><br>
    @endif
    </div>

    <!-- ROW -->

    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <button type="button" class="modal-effect btn btn-outline-primary" data-toggle="modal"
                        data-target="#exampleModal"> اضافة منتج</button><br><br>
                    {{--                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة قسم</a> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">اسم المنتج</th>
                                <th class="border-bottom-0">اسم المقسم </th>
                                <th class="border-bottom-0">الملاحظات </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($getProducts as $getProduct)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $getProduct->product_name }}</td>
                                    {{-- عشان اعرض بقا اسم السيكشن لازم اعمل الريلبشن في الموديل واستعدي الفانكشن هنا  --}}
                                   <td>{{ $getProduct->section->section }}</td> 
                                    <td>{{ $getProduct->description }}</td>
                                    <td>
                                        <!-- ال جاي دا في شوية جافا اسكربت  دا بتاع زرتري تاتديليت والايدت ولسه هستخدمها تحت تاني ولسه  هحتاج الجيكويري  -->
                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                            data-pro_id="{{ $getProduct->id }}"
                                            data-product_name="{{ $getProduct->product_name }}"
                                            data-section_name="{{ $getProduct->section->section }}" 
                                            data-description="{{ $getProduct->description }}" data-toggle="modal"
                                            href="#exampleModal2" title="تعديل"><i class="las la-pen"></i></a>

                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                            data-pro_id="{{ $getProduct->id }}"
                                            data-product_name="{{ $getProduct->product_name }}" data-toggle="modal"
                                            href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- add -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">اضافة منتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('product.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم المنتج</label>
                                <input type="text" class="form-control" id="product_name" name="product_name">
                            </div>

                            {{--   الي جاي دا الي هيظهر فيه الاقسام الي انا عاملها في السكشن      --}}
                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                            <select name="section_id" id="section_id" class="form-control">
                                <option value="" selected disabled> --حدد القسم--</option>
                                @foreach ($get as $ge)
                                    {{--   الي جاي دا معناه اني هيظهري في الاختيارات الاسم بتاع القسم بس هيتخزن الاي دي --}}
                                    <option value="{{ $ge->id }}">{{ $ge->section }}</option>
                                @endforeach
                            </select>

                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">ملاحظات</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">تاكيد</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- edit -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- autocomplete="off" دي بتوقف افتراحات الكتابة  -->
                        <!-- "section/update" دي هستخدمها هنا   -->
                        <form action="product/update" method="post" autocomplete="off">
                            {{ method_field('patch') }}
                            {{ csrf_field() }}
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="title">اسم المنتج :</label>

                                    <input type="hidden" class="form-control" name="pro_id" id="pro_id"
                                        value="">

                                    <input type="text" class="form-control" name="product_name" id="product_name">
                                </div>

                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                                <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2"
                                    required>
                                    @foreach ($get as $ge)
                                        <option>{{ $ge->section }}</option>
                                    @endforeach
                                </select>

                                <div class="form-group">
                                    <label for="des">ملاحظات :</label>
                                    <textarea name="description" cols="20" rows="5" id='description' class="form-control"></textarea>
                                </div>

                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تاكيد</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- delete -->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="product/destroy" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="modal-body">
                                <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                <input type="hidden" name="pro_id" id="pro_id" value="">
                                <input class="form-control" name="product_name" id="product_name" type="text"
                                    readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- breadcrumb -->
    @endsection
    @section('content')
        <!-- row -->
        <div class="row">

        </div>
        <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
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
    <script>
        // لازم اخلي الاسماء زي منا عاملها فوق بالظبط
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var product_name = button.data('product_name')
            var section_name = button.data('section_name')
            var pro_id = button.data('pro_id')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #pro_id').val(pro_id);
            modal.find('.modal-body #description').val(description);
        })

        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var pro_id = button.data('pro_id')
            var product_name = button.data('product_name')
            var modal = $(this)

            modal.find('.modal-body #pro_id').val(pro_id);
            modal.find('.modal-body #product_name').val(product_name);
        })
    </script>
@endsection
