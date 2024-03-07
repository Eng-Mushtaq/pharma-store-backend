@extends('admin.layouts.app')

@push('page-css')
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">فاتورة شراء</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">لوحة التحكم</a></li>
		<li class="breadcrumb-item active">اضافة فاتورة شراء</li>
	</ul>
</div>
@endpush


@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">

				<!-- Add Medicine -->
				<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('purchases.store')}}">
					@csrf
					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>الاجمالي<span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="total" >
								</div>
							</div>
{{--							<div class="col-lg-4">--}}
{{--								<div class="form-group">--}}
{{--									<label>التصنيف <span class="text-danger">*</span></label>--}}
{{--									<select class="select2 form-select form-control" name="category"> --}}
{{--										@foreach ($categories as $category)--}}
{{--											<option value="{{$category->id}}">{{$category->name}}</option>--}}
{{--										@endforeach--}}
{{--									</select>--}}
{{--								</div>--}}
{{--							</div>--}}
							<div class="col-lg-4">
								<div class="form-group">
									<label>Supplier <span class="text-danger">*</span></label>
									<select class="select2 form-select form-control" name="supplier">
										@foreach ($suppliers as $supplier)
											<option value="{{$supplier->id}}">{{$supplier->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>التاريخ <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="doc_date" value="{{date('Y-m-d')}}">
                                </div>
                            </div>
						</div>
					</div>

					<div class="service-fields mb-3">
						<div class="row">

                            <table style="width: 600px!important;">
                                <thead>
                                <tr>
{{--                                    <th>#</th>--}}
                                    <th style="width: 100px !important;">الصنف</th>
                                    <th style="width: 100px !important;">الكمية</th>
                                    <th style="width: 100px !important;">السعر</th>
                                    <th style="width: 100px;">.....</th>
                                </tr>
                                </thead>
                                <tbody id="table-body">
                                <tr>
                                    <td><select class="select2 form-select form-control" name="product_id[]">
                                        										@foreach ($products as $product)
                                        											<option value="{{$product->id}}">{{$product->name}}</option>
                                        										@endforeach
                                        									</select></td>
                                    <td>
                                        <input type="number" name="qty[]">
                                    </td>
                                    <td>
                                        <input type="number" name="price[]">
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <button id="add-row">Add Row</button>
						</div>
					</div>



					<div class="submit-section">
						<button class="btn btn-primary submit-btn" type="submit" >حفظ</button>
					</div>
				</form>
				<!-- /Add Medicine -->

			</div>
		</div>
	</div>
</div>
@endsection

@push('page-js')
	<!-- Datetimepicker JS -->

	<script src="{{asset('assets/js/moment.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        // $(document).ready(function() {
            // Add event listener for the "Add Row" button
            $("#add-row").click(function(event) {
                event.preventDefault();
                // Get the last row number
                var lastRow = $("#table-body tr:last");
                var rowNumber = lastRow.length ? parseInt(lastRow.find("td:first").text()) + 1 : 1;

                // Create a new table row
                var newRow = $('<tr> <td><select class="select2 form-select form-control" name="product_id[]">@foreach ($products as $product)<option value="{{$product->id}}">{{$product->name}}</option>@endforeach</select></td> <td> <input type="number" name="qty[]"> </td> <td> <input type="number" name="price[]"> </td> </tr>');

                // Add cells to the new row
                // newRow.append("<td>" + rowNumber + "</td>");
                // newRow.append("<td><input type='text' name='name'></td>");
                // newRow.append("<td><button class='remove-row'>Remove</button></td>");

                // Append the new row to the table body
                $("#table-body").append(newRow);

                // Add event listener for the "Remove" button within the new row
                newRow.find(".remove-row").click(function() {
                    $(this).closest("tr").remove();
                });
            });
        // });
    </script>
@endpush

