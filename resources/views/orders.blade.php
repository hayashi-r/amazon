@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-12">

          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Order ID</th>
                <th scope="col">Order Date</th>
                <th scope="col">Ship By</th>
                <th scope="col">SKU</th>
                <th scope="col">Product Name</th>
                <th scope="col">QTY</th>
                <th scope="col">Shipping</th>
                <th scope="col">Address</th>
              </tr>
            </thead>
            <tbody>
              
              
              
              @foreach ($orderdata as $orderd)
              <tr>
              <td>{{ $orderd->orderid }}</td>
              <td>{{ $orderd->purchasedate }}</td>
              <td>{{ $orderd->shipby }}</td>
              <td>{{ $orderd->sku }}</td>
              <td>{{ $orderd->productname }}</td>
              <td>{{ $orderd->qtypurchased }}</td>
              <td>{{ $orderd->shiplevel }}</td>
              <td>{{ $orderd->recipient }}<br>
              {{ $orderd->address1 }}<br>
              {{ $orderd->address2 }}<br>
              {{ $orderd->postalcode }} {{ $orderd->city }}<br>
              {{ $orderd->country }}<br>
              </td>
              </tr>
              @endforeach
              
              
            </tbody>
          </table>


        </div>
      </div>
    </div>

@endsection