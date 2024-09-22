@extends('master')

@section('theTitle')
  Posts by {{$user->username}}
@endsection


@section('theMainContent')

<h2>Posts by: {{$user->username}}</h2>
<h3>Contact: <a href="mailto:{{$user->email}}">{{$user->email}}</a></h3>

  @include('general.blog.multiplePosts')

@endsection
