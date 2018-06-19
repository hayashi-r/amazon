@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Settings</div>

                <div class="card-body">
                  <h2 style="text-align:left;">Authorize Amazon Marketplace Access:</h2>

                  <form action="amazonauth" method="post">
                    {{ csrf_field() }}
                    <div class="form-group" style="text-align:left;">
                        <label for="seller_id">Seller ID:</label>
                        <input type="text" class="form-control" name="seller_id" id="seller_id" placeholder="Enter Seller ID" style="width:25%;">
                    </div>
                    <div class="form-group" style="text-align:left;">
                        <label for="token">MWS Auth Token:</label>
                        <input type="text" class="form-control" name="token" id="token" placeholder="Enter MWS Auth Token" style="width:25%;">
                    </div>

                      <div class="form-group" style="text-align:left;">
                        <label for="marketplace_name">Amazon Marketplace:</label>
                        <select class="form-control" name="marketplace_name" id="marketplace_name" style="width:25%;">
                          <option value="Amazon.com">Amazon.com</option>
                          <option value="Amazon.co.uk">Amazon.co.uk</option>
                        </select>
                </div>

                  <div class="form-group" style="text-align:left;">
                      <label for="marketplace_id">Marketplace ID:</label>
                      <input type="text" class="form-control" name="marketplace_id" id="marketplace_id" placeholder="Marketplace ID" style="width:25%;">
              </div>

              <div class="form-group" style="text-align:left;">
                      <label for="custom_name">Name of your Marketplace:</label>
                       <input type="text" class="form-control" name="custom_name" id="custom_name" placeholder="Marketplace Name" style="width:25%;">
              </div>
                  <button type="submit" value="Submit" class="btn btn-secondary">Submit</button>
              </form>
              </div>

              @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                </div>
            </div>

        </div>
    </div>

@endsection
