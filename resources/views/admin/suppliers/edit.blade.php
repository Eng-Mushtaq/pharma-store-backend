@extends('admin.layouts.app')

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">تعديل بيانات مورد</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">لوحة التحكم</a></li>
		<li class="breadcrumb-item active">تعديل بيانات المورد</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">
			
			<!-- Edit Supplier -->
			<form method="post" enctype="multipart/form-data" action="{{route('suppliers.update',$supplier)}}">
				@csrf
				@method("PUT")
				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>الاسم<span class="text-danger">*</span></label>
								<input class="form-control" type="text" value="{{$supplier->name ?? old('name')}}" name="name">
							</div>
						</div>
						<div class="col-lg-6">
							<label>الايميل<span class="text-danger">*</span></label>
							<input class="form-control" type="text" value="{{$supplier->email ?? old('email')}}" name="email" >
						</div>
					</div>
				</div>

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>رقم الهاتف<span class="text-danger">*</span></label>
								<input class="form-control" type="text" value="{{$supplier->phone ?? old('phone')}}" name="phone">
							</div>
						</div>
						<div class="col-lg-6">
							<label>الشركة<span class="text-danger">*</span></label>
							<input class="form-control" type="text" value="{{$supplier->company ?? old('company')}}" name="company">
						</div>
					</div>
				</div>

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>العنوان <span class="text-danger">*</span></label>
								<input type="text" name="address" value="{{$supplier->address ?? old('address')}}" class="form-control">
							</div>
						</div>
						<div class="col-lg-6">
							<label>الصنف</label>
							<input type="text" name="product" value="{{$supplier->product ?? old('product')}}" class="form-control">
						</div>
					</div>
				</div>	
				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-12">
							<label>ملاحظات</label>
							<textarea name="comment" class="form-control" value="{{$supplier->comment ?? old('comment')}}" cols="30" rows="10">{{$supplier->comment}}</textarea>
						</div>
					</div>
				</div>		
				
				
				<div class="submit-section">
					<button class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">حفظ</button>
				</div>
			</form>

			<!-- /Edit Supplier -->

			</div>
		</div>
	</div>			
</div>
@endsection	



@push('page-js')
	<!-- Select2 JS -->
	<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
@endpush




