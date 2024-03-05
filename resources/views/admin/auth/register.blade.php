@extends('admin.layouts.plain')

@section('content')
<h1>انشئ حساب</h1>
<p class="account-subtitle">الوصول الى لوحة التحكم الخاصة بك</p>

<!-- Form -->
<form action="{{route('register')}}" method="POST">
	@csrf
	<div class="form-group">
		<input class="form-control" name="name" type="text" value="{{old('name')}}" placeholder="اسمك الكامل">
	</div>
	<div class="form-group">
		<input class="form-control" name="email" type="text" value="{{old('email')}}" placeholder="الايميل">
	</div>
	<div class="form-group">
		<input class="form-control" name="password" type="password" placeholder="كلمة المرور">
	</div>
	<div class="form-group">
		<input class="form-control" name="password_confirmation" type="password" placeholder="تأكيد كلمة المرور">
	</div>
	<div class="form-group mb-0">
		<button class="btn btn-primary btn-block" type="submit">انشاء حساب</button>
	</div>
</form>
<!-- /Form -->
								
<div class="text-center dont-have">لديك حساب بالفعل ؟ <a href="{{route('login')}}">تسجيل دخول</a></div>
@endsection