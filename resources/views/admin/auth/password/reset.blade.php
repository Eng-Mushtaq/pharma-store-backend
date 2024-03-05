@extends('admin.layouts.plain')

@section('content')
<h1>نسيت كلمة المرور ؟</h1>
<p class="account-subtitle">ادخل ايميلك للحصول على رابط استعادة كلمة المرور</p>
<!-- Form -->
<form action="{{route('password.request')}}" method="post">
	@csrf
    <input type="hidden" name="token" value="{{request()->token}}">
	<div class="form-group">
		<input class="form-control" name="email" type="text" placeholder="الايميل">
	</div>
    <div class="form-group">
		<input class="form-control" name="password" type="password" placeholder="ادخل كلمة مرور جديدة">
	</div>
    <div class="form-group">
		<input class="form-control" name="password_confirmation" type="password" placeholder="اعد كتابة كلمة المرور">
	</div>
	<div class="form-group mb-0">
		<button class="btn btn-primary btn-block" type="submit">اعادة تعيين كلمة المرور</button>
	</div>
</form>
<!-- /Form -->

<div class="text-center dont-have">تذكر كلمة المرور ؟ <a href="{{route('login')}}">تسجيل دخول</a></div>
@endsection