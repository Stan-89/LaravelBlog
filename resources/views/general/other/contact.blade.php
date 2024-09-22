@extends('master')

@section('theTitle')
Contact
@endsection

@section('styles')
  <link rel="stylesheet" href="{{URL::to('/css/form.css')}}" type="text/css">
@endsection

@section('theMainContent')
  <form action="{{route('processMessage')}}" method="POST" id="contact-form">
    <div class="input-group">
      <label for="name">Your name</label>
      <input type="text" name="name" id="name" value="{{old('name')}}"/>
    </div>
    <div class="input-group">
      <label for="email">Your email</label>
      <input type="text" name="email" id="email" value="{{old('email')}}"/>
    </div>
    <div class="input-group">
      <label for="subject">The subject</label>
      <input type="text" name="subject" id="subject" value="{{old('subject')}}"/>
    </div>
    <div class="input-group">
      <label for="message">Your name</label>
      <textarea name="message" id="message" rows="10">{{old('message')}}</textarea>
    </div>
    <button type="submit" class="btn">Submit message</button>
    <input type="hidden" value="{{Session::token()}}" name="_token"/>
  </form>

    @include('general.other.info-box')

@endsection
