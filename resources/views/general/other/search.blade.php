@extends('master')

@section('theTitle')
Contact
@endsection

@section('styles')
  <link rel="stylesheet" href="{{URL::to('/css/form.css')}}" type="text/css">
@endsection

@section('theMainContent')

  <form action="{{route('searchResults')}}" method="GET" id="searchForm">
    <div class="input-group">
      <label for="searchWord">Search for:</label>
      <input type="text" name="searchQuery" id="searchQuery" placeholder="..."/>
    </div>
    <button type="submit" class="btn">Go</button>
  </form>

  @include('general.other.info-box')

@endsection
