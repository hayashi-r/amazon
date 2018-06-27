@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Authorize Amazon Marketplace Access:</div>

                <div class="card-body">


                  @if ($errors->any())
                  <div class="alert alert-danger">
                  <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                  </ul>
                  </div>
                  @endif


                  <form action="amazonauth" method="post">
                    {{ csrf_field() }}

                    @if(Auth::check())
                    <input type="hidden" id="custId" name="custId" value="{{Auth::user()->id}}">
                    @endif

                    <div class="form-group" style="text-align:left;">
                        <label for="seller_id">Seller ID:</label>
                        <input type="text" class="form-control" name="seller_id" id="seller_id" placeholder="Enter Seller ID">
                    </div>
                    <div class="form-group" style="text-align:left;">
                        <label for="token">MWS Auth Token:</label>
                        <input type="text" class="form-control" name="token" id="token" placeholder="Enter MWS Auth Token">
                    </div>

                      <div class="form-group" style="text-align:left;">
                        <label for="marketplace_name">Amazon Marketplace:</label>
                        <select class="form-control" name="marketplace_name" id="marketplace_name">
                          <option value="Amazon.com">Amazon.com</option>
                          <option value="Amazon.co.uk">Amazon.co.uk</option>
                        </select>
                </div>

                  

              <div class="form-group" style="text-align:left;">
                      <label for="custom_name">Name of your Marketplace:</label>
                       <input type="text" class="form-control" name="custom_name" id="custom_name" placeholder="Marketplace Name">
              </div>
                  <button type="submit" value="Submit" class="btn btn-secondary">Submit</button>
              </form>
              </div>


                </div>
            </div>


            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Stored Amazon Marketplace Access:</div>

                    <div class="card-body">

                      <div class="row">

  <div class="col-4">
    <div class="list-group" id="list-tab" role="tablist">

      @foreach ($mwsdata as $data)
      <a class="list-group-item list-group-item-action" id="list-{{ $data->custom_name }}-list" data-toggle="list" href="#list-{{ $data->custom_name }}" role="tab" aria-controls="{{ $data->custom_name }}">{{ $data->custom_name }}</a>
      @endforeach

    </div>
  </div>
  <div class="col-8">
    <div class="tab-content" id="nav-tabContent">

      @foreach ($mwsdata as $data)
      <div class="tab-pane fade" id="list-{{ $data->custom_name }}" role="tabpanel" aria-labelledby="list-{{ $data->custom_name }}-list"><strong>Marketplace:</strong> {{ $data->marketplace_name }}<br>
       <strong>Seller ID:</strong> {{ $data->seller_id }}<br>
       <strong>Token:</strong> {{ $data->token }}<br>
       
      </div>
      @endforeach

    </div>
  </div>
</div>


@endsection