@extends('user-master')


@section('theMainContent')
<div class="container">
  <section id="post-admin">
    <a href="{{route('deleteMessage', ['id_msg' => $message->id])}}" class="deleteLink danger">Delete message</a>
  </section>
  <section class="post">
    <h3>Subject: {{$message->subject}}</h3>
    <h3>Sender: {{$message->sender}}</h3>
    <h3>E-mail: {{$message->email}}</h3>
    <h3>Sent at: {{$message->created_at}}</h3>
    <p>{{$message->body}}</p>

  </section>
</div>
@endsection

@php
(
$theSection = 4
)
@endphp

@include('users.scriptSection')
