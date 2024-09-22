@extends('master')

@section('theTitle')
  Posts containing: {{$category->name}}
@endsection


@section('theMainContent')

<h2>Posts tagged with {{$category->name}}</h2>

  @include('general.blog.multiplePosts')

@endsection
