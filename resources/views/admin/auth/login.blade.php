@extends('admin.layouts.plain')

@section('content')
<h1>تسجيل الدخول</h1>
<p class="account-subtitle">الوصول الى لوحة التحكم الخاصة بك</p>
@if (session('login_error'))
<x-alerts.danger :error="session('login_error')" />
@endif
<!-- Form -->
<form action="{{route('login')}}" method="post">
	@csrf
	<div class="form-group">
		<input class="form-control" name="email" type="text" placeholder="الايميل">
	</div>
	<div class="form-group">
		<input class="form-control" name="password" type="password" placeholder="كلمة المرور">
	</div>
	<div class="form-group">
		<button class="btn btn-primary btn-block" type="submit">تسجيل دخول</button>
	</div>
</form>
<!-- /Form -->

<div class="text-center forgotpass"><a href="{{route('password.request')}}">نسيت كلمة المرور ؟</a></div>
<div class="text-center dont-have">لا تملك حساب ؟<a href="{{route('register')}}">انشئ حساب</a></div>
@endsection