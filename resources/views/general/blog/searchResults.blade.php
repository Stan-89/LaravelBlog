@extends('master')

@section('theTitle')
   {{$searchTerms}} - search results
@endsection


@section('theMainContent')

<h2>Search results for {{$searchTerms}}</h2>

@include('general.blog.multiplePosts')

@endsection
