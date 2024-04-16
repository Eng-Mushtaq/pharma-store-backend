@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">الطلبات</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">لوحة التحكم</a></li>
		<li class="breadcrumb-item active">الطلبات</li>
	</ul>
</div>
<div class="col-sm-5 col">
{{--	<a href="{{route('products.create')}}" class="btn btn-primary float-right mt-2">اضافة صنف</a>--}}
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">

		<!-- Products -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="orders-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
								<th>اسم المستخدم</th>
{{--								<th>التصنيف</th>--}}
								<th>السعر</th>
{{--								<th>الكمية</th>--}}
{{--								<th>نسبة الخصم</th>--}}
								<th>الحالة</th>
								<th class="action-btn">العمليات</th>
							</tr>
						</thead>
						<tbody>


						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /Products -->

	</div>
</div>

@endsection

@push('page-js')
<script>
    $(document).ready(function() {
        var table = $('#orders-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('orders.index')}}",
            columns: [
                {data: 'user', name: 'user_id'},
                // {data: 'category', name: 'category'},
                {data: 'total_price', name: 'total_price'},
                {data: 'status', name: 'status'},
                // {data: 'discount', name: 'discount'},
				// {data: 'exp_date', name: 'exp_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
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
