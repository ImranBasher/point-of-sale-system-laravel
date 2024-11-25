
{{--<script src="{{asset('backend/custom.js') }}"></script>--}}

<!-- Bootstrap -->
<script src="{{asset('backend') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- overlayScrollbars -->
<script src="{{asset('backend') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- AdminLTE App -->
<script src="{{asset('backend') }}/dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->

<!-- jQuery Mapael -->
<script src="{{asset('backend') }}/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="{{asset('backend') }}/plugins/raphael/raphael.min.js"></script>
<script src="{{asset('backend') }}/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="{{asset('backend') }}/plugins/jquery-mapael/maps/usa_states.min.js"></script>

<!-- ChartJS -->
<script src="{{asset('backend') }}/plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{asset('backend') }}/dist/js/demo.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
var firstItem = responseData[0];

@if(Route::is('dashboard'))
    <script src="{{asset('backend/dist/js/pages/dashboard2.js')}}"></script>
@endif

{{--<script src="{{asset('backend') }}/dist/js/pages/dashboard2.js"></script>--}}
<!-- Include SweetAlert2 CSS and JS -->

{{--sweet alert--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
{{--<script src="{{asset('backend/custom.js') }}"></script>--}}
{{--jquery print plugin--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.1/jQuery.print.min.js"></script>




@include('admin.category.NewCategory.allCategoryJS')
@include('admin.role-permission.role.js-role')
@include('admin.role-permission.permission.js-permission')

{{--@include('admin.subcategories.js-subcategory')--}}
{{--@include('admin.product.product_js')--}}

@include('admin.categories.js-category')

@include('admin.brand.brands_js')

@include('admin.origins.js-origin')

@include('admin.units.js-unit')

@include('admin.users.js-user')

@include('admin.products.js-product')

@include('admin.purchases.js-purchase')
@include('admin.purchases.js-purchase-order')

@include('admin.sales.js-sale')
@include('admin.sales.js-sales-order')

@include('admin.dues.purchases.js-due-pay')
@include('admin.dues.sales.js-due-sales-pay')

