@extends('admin.layouts.plain')

@section('content')
<h1>نسيت كلمة المرور؟</h1>
<p class="account-subtitle">ادخل ايميلك للحصول على رابط استعادة كلمة المرور</p>
<!-- Form -->
<form action="{{route('password.request')}}" method="post">
	@csrf
	<div class="form-group">
		<input class="form-control" name="email" type="text" placeholder="الايميل">
	</div>
	<div class="form-group mb-0">
		<button class="btn btn-primary btn-block" type="submit">تأكيد</button>
	</div>
</form>
<!-- /Form -->

<div class="text-center dont-have">تذكرني  <a href="{{route('login')}}">تسجل دخول</a></div>
@endsection