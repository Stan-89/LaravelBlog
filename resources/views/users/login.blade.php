@extends('master')

@section('theTitle')
Log in
@endsection

@section('styles')
  <link rel="stylesheet" href="{{URL::to('/css/form.css')}}" type="text/css">
@endsection

@section('theMainContent')
  <form action="{{route('postLogin')}}" method="POST" id="login-form">
    <div class="input-group">
      <label for="theUsername">Username</label>
      <input type="text" name="theUsername" id="theUsername" value="{{old('theUsername')}}"/>
    </div>
    <div class="input-group">
      <label for="thePassword">Password</label>
      <input type="password" name="thePassword" id="thePassword"/>
    </div>
    <button type="submit" class="btn">Login</button>
    <input type="hidden" value="{{Session::token()}}" name="_token"/>
  </form>

    @include('general.other.info-box')

@endsection
