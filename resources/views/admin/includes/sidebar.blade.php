<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('backend') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><h4>POINT OF SALE </h4> </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('backend') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{strtoupper(Auth::user()->name)}}</a>
            </div>
        </div>







        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class=" fas fa-tachometer-alt"></i>
                            Dashboard
                    </a>
                </li>


{{--                @can('ad ')--}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Category
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('categories.index')}}" class="nav-link allCategory">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Show Category</p>
                            </a>
                        </li>
{{--                        <li class="nav-item">--}}
{{--                            <a href="pages/layout/collapsed-sidebar.html" class="nav-link">--}}
{{--                                <i class="far fa-circle nav-icon"></i>--}}
{{--                                <p>Collapsed Sidebar</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                    </ul>
                </li>




                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Brands
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('brands.index')}}" class="nav-link allBrands">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Show Brand</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Origin
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('origins.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Origin</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Units
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('units.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Unit</p>
                            </a>
                        </li>

                    </ul>
                </li>

                {{------Customer----------}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('users.admin')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Admin</p>
                            </a>
                        </li>

                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('users.customer')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Customers</p>
                            </a>
                        </li>

                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('users.supplier')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Suppliers</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('products.index')}}" class="nav-link allProduct">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Show Product</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Purchase
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('show-purchase')}}" class="nav-link allProduct">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Show purchase</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('purchases.index')}}" class="nav-link allProduct">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage purchase</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Sales
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('sales.index')}}" class="nav-link allProduct">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Sales</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('show-sales')}}" class="nav-link allProduct">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Show Sales</p>
                            </a>
                        </li>
                    </ul>
                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p>
                                            Manage Dues
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{route('dues_purchase.index')}}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Purchase Dues</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('purchase-pay.show')}}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Purchase Payment</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('dues_sales.index')}}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Sales Dues</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('sales_pay.show')}}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Sales Payment</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Role Permission
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('roles.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Role</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('permissions.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permission</p>
                            </a>
                        </li>
                    </ul>
                </li>







                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link btn btn-danger" >
                        <i class="far fa-sign-out "></i>
                        Logout
                    </a>
                </li>






            </ul>
        </nav>








    </div>
    <!-- /.sidebar -->
</aside>
