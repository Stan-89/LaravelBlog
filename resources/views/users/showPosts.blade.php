@extends('user-master')

@section('styles')
    <link rel="stylesheet" href="{{ URL::to('css/modal.css') }}">
@endsection

@section('theMainContent')
<div class="container">
  @include('general.other.info-box')
  <section id="post-admin">
    <a href="{{route('addPost')}}" class="btn">New Post</a>
  </section>
  <section class="list">
    @if(count($posts)==0)
      No posts
    @else
      @foreach($posts as $aPost)
      <article>
        <div class="post-info">
          <h3>{{$aPost->title}}</h3>
          <span class="info">{{$aPost->user->username}} | {{$aPost->created_at}}</span>
        </div>
        <div class="edit">
          <nav>
            <ul>
              <li><a href="{{route('showSinglePost', ['id_post' => $aPost->id])}}">View post</a></li>
              <li><a href="{{route('editPost', ['post_id' => $aPost->id])}}">Edit</a></li>
              <li><a href="{{route('deletingPost', ['post_id' => $aPost->id])}}" class="danger deleteLink">Delete post</a></li>
            </ul>
          </nav>
        </div>
      </article>
      @endforeach
    @endif
  </section>

  <section class="pagination">
    @if($posts->previousPageUrl() != "")
        @if($posts->currentPage() != 1)
          <a href="{{$posts->url(1)}}" class="linkNavigation"> << </a>
        @else
          <div class="emptyLink"></div>
        @endif
      <a href="{{$posts->previousPageUrl()}}" class="linkNavigation"> < </a>
    @else
      <div class="emptyLink"></div>
      <div class="emptyLink"></div>
    @endif
    @if($posts->nextPageUrl() != "")
      <a href="{{$posts->nextPageUrl()}}" class="linkNavigation"> > </a>
      @if($posts->currentPage() != $posts->lastItem())
        <a href="{{$posts->url($posts->lastPage())}}" class="linkNavigation"> >> </a>
      @else
        <div class="emptyLink"></div>
      @endif
    @else
      <div class="emptyLink"></div>
    @endif
  </section>

</div>
@endsection

@php
(
$theSection = 2
)
@endphp

@include('users.scriptSection')
