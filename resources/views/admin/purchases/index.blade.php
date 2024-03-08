@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">المشتريات</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">لوحة التحكم</a></li>
		<li class="breadcrumb-item active">المشتريات</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="{{route('purchases.create')}}" class="btn btn-primary float-right mt-2">اضافة فاتورة مشتريات</a>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">

		<!-- Recent Orders -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="purchase-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
{{--								<th>اسم الدواء</th>--}}
{{--								<th>التصنيف</th>--}}
								<th>المورد</th>
								<th>مبلغ  الفاتورة</th>
{{--								<th>الكمية</th>--}}
								<th>تاريخ الفاتوره</th>
								<th class="action-btn">العمليات</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /Recent Orders -->

	</div>
</div>
@endsection

@push('page-js')
<script>
    $(document).ready(function() {
        var table = $('#purchase-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('purchases.index')}}",
            columns: [
                // {data: 'product', name: 'product'},
                // {data: 'category', name: 'category'},
                {data: 'supplier', name: 'supplier'},
                {data: 'total_price', name: 'total_price'},
                // {data: 'quantity', name: 'quantity'},
				{data: 'doc_date', name: 'doc_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ] ,               language: {
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
