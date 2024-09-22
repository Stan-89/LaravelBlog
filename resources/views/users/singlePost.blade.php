@extends('user-master')


@section('theMainContent')
<div class="container">
  <section id="post-admin">
    <a href="{{route('editPost', ['post_id' => $post->id])}}">Edit post</a>
    <a href="{{route('deletingPost', ['post_id' => $post->id])}}" class="deleteLink">Delete post</a>
  </section>
  <section class="post">
    <h1>{{$post->title}}</h1>
    <span class="info">{{$post->user->username}} | {{$post->created_at}}</span>
    <p>{{$post->body}}</p>

    <div class="categoriesSpaceAdmin">
        <ul class="categoriesList">
      @foreach($post->categories as $cat)
          <li>{{$cat->name}}</li>
      @endforeach
        </ul>
    </div>

  </section>
</div>
@endsection

@php
(
$theSection = 2
)
@endphp

@include('users.scriptSection')
