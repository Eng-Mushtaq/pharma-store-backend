<!-- Sidebar -->
<div class="sidebar col-lg-2 pt-5 " id="sidebar">
	<div class="sidebar-inner slimscroll mt-3 ">
		<div id="sidebar-menu" class="sidebar-menu p-0 m-2">

			<ul>
				<li class="menu-title">
					<span>الرئيسية</span>
				</li>
				<li class="{{ route_is('dashboard') ? 'active' : '' }}">
					<a href="{{route('dashboard')}}"><i class="fe fe-home"></i> <span>لوحة التحكم</span></a>
				</li>

				@can('view-category')
				<li class="{{ route_is('categories.*') ? 'active' : '' }}">
					<a href="{{route('categories.index')}}"><i class="fe fe-layout"></i> <span>التصنيفات</span></a>
				</li>
				@endcan

				@can('view-products')
				<li class="submenu">
					<a href="#"><i class="fe fe-document"></i> <span> الأصناف</span> <span class="menu-arrow mr-1"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is(('products.*')) ? 'active' : '' }}" href="{{route('products.index')}}">المنتجات</a></li>
						@can('create-product')<li><a class="{{ route_is('products.create') ? 'active' : '' }}" href="{{route('products.create')}}">اضافة منتج</a></li>@endcan
						@can('view-outstock-products')<li><a class="{{ route_is('outstock') ? 'active' : '' }}" href="{{route('outstock')}}">منتجات خارج المخزون</a></li>@endcan
						@can('view-expired-products')<li><a class="{{ route_is('expired') ? 'active' : '' }}" href="{{route('expired')}}">الادوية المنتهية </a></li>@endcan
					</ul>
				</li>
				@endcan

				@can('view-purchase')
				<li class="submenu">
					<a href="#"><i class="fe fe-star-o"></i> <span> المشتريات</span> <span class="menu-arrow mr-1"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('purchases.*') ? 'active' : '' }}" href="{{route('purchases.index')}}">مشتريات</a></li>
						@can('create-purchase')
						<li><a class="{{ route_is('purchases.create') ? 'active' : '' }}" href="{{route('purchases.create')}}">اضافة فاتورة شراء</a></li>
						@endcan
					</ul>
				</li>
				@endcan
				@can('view-sales')
				<li class="submenu">
					<a href="#"><i class="fe fe-activity"></i> <span> المبيعات</span> <span class="menu-arrow mr-1"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('sales.*') ? 'active' : '' }}" href="{{route('sales.index')}}">المبيعات</a></li>
						@can('create-sale')
						<li><a class="{{ route_is('sales.create') ? 'active' : '' }}" href="{{route('sales.create')}}">اضافة فاتورة بيع</a></li>
						@endcan
					</ul>
				</li>
				@endcan

				@can('view-supplier')
				<li class="submenu">
					<a href="#"><i class="fe fe-user"></i> <span> الموردين</span> <span class="menu-arrow mr-1"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('suppliers.*') ? 'active' : '' }}" href="{{route('suppliers.index')}}">الموردين</a></li>
						@can('create-supplier')<li><a class="{{ route_is('suppliers.create') ? 'active' : '' }}" href="{{route('suppliers.create')}}">اضافة مورد</a></li>@endcan
					</ul>
				</li>
				@endcan

                @can('view-customer')
                    <li class="submenu">
                        <a href="#"><i class="fe fe-user"></i> <span> العملاء</span> <span class="menu-arrow mr-1"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ route_is('customers.*') ? 'active' : '' }}" href="{{route('customers.index')}}">العملاء</a></li>
                            @can('create-customer')<li><a class="{{ route_is('customers.create') ? 'active' : '' }}" href="{{route('customers.create')}}">اضافة عميل</a></li>@endcan
                        </ul>
                    </li>
                @endcan

				@can('view-reports')
				<li class="submenu">
					<a href="#"><i class="fe fe-document"></i> <span> التقارير</span> <span class="menu-arrow mr-1 "></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('sales.report') ? 'active' : '' }}" href="{{route('sales.report')}}">تقارير المبيعات</a></li>
						<li><a class="{{ route_is('purchases.report') ? 'active' : '' }}" href="{{route('purchases.report')}}">تقارير المشتريات</a></li>
					</ul>
				</li>
				@endcan

				@can('view-access-control')
				<li class="submenu">
					<a href="#"><i class="fe fe-lock"></i> <span> صلاحيات المستخدمين</span> <span class="menu-arrow mr-1"></span></a>
					<ul style="display: none;">
						@can('view-permission')
						<li><a class="{{ route_is('permissions.index') ? 'active' : '' }}" href="{{route('permissions.index')}}">الصلاحيات</a></li>
						@endcan
						@can('view-role')
						<li><a class="{{ route_is('roles.*') ? 'active' : '' }}" href="{{route('roles.index')}}">القواعد</a></li>
						@endcan
					</ul>
				</li>
				@endcan

				@can('view-users')
				<li class="{{ route_is('users.*') ? 'active' : '' }}">
					<a href="{{route('users.index')}}"><i class="fe fe-users"></i> <span>المستخدمين</span></a>
				</li>
				@endcan

				<li class="{{ route_is('profile') ? 'active' : '' }}">
					<a href="{{route('profile')}}"><i class="fe fe-user-plus"></i> <span>معلومات الحساب</span></a>
				</li>
				<li class="{{ route_is('backup.index') ? 'active' : '' }}">
					<a href="{{route('backup.index')}}"><i class="material-icons">backup</i> <span>النسخ الاحتياطي</span></a>
				</li>
				@can('view-settings')
				<li class="{{ route_is('settings') ? 'active' : '' }}">
					<a href="{{route('settings')}}">
						<i class="material-icons">settings</i>
						 <span> الاعدادات</span>
					</a>
				</li>
				@endcan
			</ul>
		</div>
	</div>
</div>
<!-- /Sidebar -->
