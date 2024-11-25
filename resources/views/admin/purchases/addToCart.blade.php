
<div class="container mt-4">
    <h2>Purchase Cart</h2>
{{--    @if(session('success'))--}}
{{--        <div class="alert alert-success">{{ session('success') }}</div>--}}
{{--    @endif--}}

{{--    @if(session('error'))--}}
{{--        <div class="alert alert-danger">{{ session('error') }}</div>--}}
{{--    @endif--}}

    <table class="table table-bordered" id = "open-and-close-addToCartTable">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Sub Total</th>
        </tr>
        </thead>
        <tbody id = "addToCartData">
            @foreach($purchaseCart as $item)
                <tr>
                    <td>{{ $item['product_id'] }}</td>
                    <td> <img src="#" > </td>
                    <td>{{$item['title']}}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['unit_price'] }}</td>
                    <td>{{ $item['sub_total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('admin.purchase.checkout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Proceed to Checkout</button>
    </form>
</div>
