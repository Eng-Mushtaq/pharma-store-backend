@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
@endpush

@push('page-header')
    <div class="col-sm-12">
        <h3 class="page-title">المنتهيه</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">الاصناف</a></li>
            <li class="breadcrumb-item active">المنتهية</li>
        </ul>
    </div>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- Recent Orders -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="expired-product"
                            class="datatable table table-striped table-bordered table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>الاسم التجاري</th>
                                    <th>التصنيف</th>
                                    <th>السعر</th>
                                    <th>الكمية</th>
                                    <th>نسبة الخصم</th>
                                    <th>تاريخ الانتهاء</th>
                                    <th class="action-btn">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Expired Products -->

        </div>
    </div>
@endsection

@push('page-js')
    <script>
        $(document).ready(function() {
            var table = $('#expired-product').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('expired') }}",
                columns: [{
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'discount',
                        name: 'discount'
                    },
                    {
                        data: 'expiry_date',
                        name: 'expiry_date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                language: {
                    "loadingRecords": "جارٍ التحميل...",
                    "zeroRecords": "لم يعثر على أية سجلات",
                    "lengthMenu": "أظهر _MENU_ مدخلات",
                    "info": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                    "search": "ابحث:",
                    "paginate": {
                        "first": "الأول",
                        "previous": "السابق",
                        "next": "التالي",
                        "last": "الأخير"
                    },


                },
            });

        });
    </script>
@endpush
