@extends('admin.layouts.app')

@push('page-css')
    
@endpush    

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">اضافة دواء</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">لوحة التحكم</a></li>
		<li class="breadcrumb-item active">اضافة دواء</li>
	</ul>
</div>
@endpush


@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">
                <!-- Add Product -->
                <form method="post" enctype="multipart/form-data" id="update_service" action="{{route('products.store')}}">
                    @csrf
                    <div class="service-fields mb-3">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>دواء <span class="text-danger">*</span></label>
                                    <select class="select2 form-select form-control" name="product"> 
                                        @foreach ($purchases as $purchase)
                                            <option value="{{$purchase->id}}">{{$purchase->product}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>سعر الشراء<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="price" value="{{old('price')}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>الخصم (%)<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="discount" value="0">
                                </div>
                            </div>
                            
                        </div>
                    </div>

                                    
                    
                    <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>وصف الدواء <span class="text-danger">*</span></label>
                                    <textarea class="form-control service-desc" name="description">{{old('description')}}</textarea>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">تأكيد</button>
                    </div>
                </form>
                <!-- /Add Product -->
			</div>
		</div>
	</div>			
</div>
@endsection

@push('page-js')
	
@endpush