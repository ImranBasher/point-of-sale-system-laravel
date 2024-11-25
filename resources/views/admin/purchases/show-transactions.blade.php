@extends('admin.layout.main')

@section('content')
    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-bold" >Purchase  Product  Transaction  Details</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Transaction ID</th>
                        <th>Purchase ID</th>
                        <th>Amount</th>
                        <th>Note</th>
                        <th>Customer ID</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i = 1  @endphp
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{$i++ }}</td>
                                <td>{{$transaction->trx_id }}</td>
                                <td>{{$transaction->purchase_id }}</td>
                                <td>{{$transaction->amount}}</td>
                                <td>{{$transaction->note}}</td>
                                <td>{{$transaction->customer_id }}</td>
                                <td>{{$transaction->created_at }}</td>
                                <td>
                                    <a href="{{route('print-transaction',$transaction->trx_id)}}"  class="btn btn-warning">Print</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
