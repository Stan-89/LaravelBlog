@extends('user-master')

@section('styles')
    <link rel="stylesheet" href="{{ URL::to('css/modal.css') }}">
@endsection
@section('theMainContent')
<div class="container">
  @include('general.other.info-box')
  <div class="card">
    <header>
      <nav>
        <ul>
          <li><a href="{{route('addPost')}}" class="btn">New post</a></li>
          <li><a href="{{route('showPosts')}}" class="btn">Show all posts</a></li>
        </ul>
      </nav>
    </header>
    <section>
      <ul>
        @if(count($posts) == 0)
          <li>No posts</li>
        @else
          @foreach($posts as $aPost)
            <li>
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
            </li>
          @endforeach
        @endif
      </ul>
    </section>
  </div>
  <div class="card">
    <header>
      <nav>
        <ul>
          <li><a href="{{route('showMessages')}}" class="btn">Show all messages</a></li>
        </ul>
      </nav>
    </header>
    <section>
      <ul>
      @if(count($messages) == 0)
        <li>No Messages</li>
      @else
        @foreach($messages as $aMessage)
        <li>
          <article>
            <div class="post-info">
              <h3>{{$aMessage->subject}}</h3>
              <span class="info">Sender: {{$aMessage->sender}} | {{$aMessage->created_at}}</span>
            </div>
            <div class="edit">
              <nav>
                <ul>
                  <li><a href="{{route('viewSingleMessage', ['id_msg' => $aMessage->id])}}">View</a></li>
                  <li><a href="{{route('deleteMessage', ['id_msg' => $aMessage->id])}}" class="danger deleteLink">Delete</a></li>
                </ul>
              </nav>
            </div>
          </article>
        </li>
        @endforeach
      @endif
      </ul>
    </section>
  </div>
</div>
<div class="modal" id="contact-message-info">
  <button class="btn" id="modal-close">Close</button>
</div>
@endsection

@php
(
$theSection = 1
)
@endphp

@include('users.scriptSection')
