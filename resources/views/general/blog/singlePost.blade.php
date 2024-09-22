@extends('master')

@section('theTitle')
  Post title
@endsection

@section('theMainContent')
<article>
  <h3>{{$post->title}}</h3>
  <span class="subtitle">Author: <a href="{{route('general.blog.postsByUser', ['user_id' => $post->user->id])}}">{{$post->user->username}}</a> | {{$post->updated_at}}</span>
  <p>{{$post->body}}</p>
  <div class="categoriesSpace">
    @foreach($post->categories as $cat)
      <a class="category" href="{{route('general.blog.postsByCategory', ['id_category' => $cat->id])}}">
        {{$cat->name}}
      </a>
    @endforeach
  </div>
</article>
@endsection
