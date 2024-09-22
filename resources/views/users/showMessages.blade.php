@extends('user-master')

@section('styles')
    <link rel="stylesheet" href="{{ URL::to('css/model.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection

@section('theMainContent')
<div class="container">
  @include('general.other.info-box')

  <section class="list">
      @if(count($messages) ==0)
        No messages
      @endif
      @foreach($messages as $message)
        <article>
          <div class="category-info" data-id="{{$message->id}}">
            <h3>Subject: {{$message->subject}}</h3>
            <h3>Sender: {{$message->sender}}</h3>
            <h3>E-mail: {{$message->email}}</h3>
          </div>
          <div class="edit">
            <nav>
                <ul>
                  <li class="category-edit"><input type="text" /></li>
                  <li><a href="{{route('viewSingleMessage', ['id_msg' => $message->id])}}">View</a></li>
                  <li><a href="{{route('deleteMessage', ['id_msg' => $message->id])}}" class="danger deleteLink">Delete</a></li>
                </ul>
          </div>
        </article>
      @endforeach
  </section>

  <section class="pagination">
    @if($messages->previousPageUrl() != "")
        @if($messages->currentPage() != 1)
          <a href="{{$messages->url(1)}}" class="linkNavigation"> << </a>
        @else
          <div class="emptyLink"></div>
        @endif
      <a href="{{$messages->previousPageUrl()}}" class="linkNavigation"> < </a>
    @else
      <div class="emptyLink"></div>
      <div class="emptyLink"></div>
    @endif
    @if($messages->nextPageUrl() != "")
      <a href="{{$messages->nextPageUrl()}}" class="linkNavigation"> > </a>
      @if($messages->currentPage() != $messages->lastItem())
        <a href="{{$messages->url($messages->lastPage())}}" class="linkNavigation"> >> </a>
      @else
        <div class="emptyLink"></div>
      @endif
    @else
      <div class="emptyLink"></div>
    @endif
  </section>

@endsection

@php
(
$theSection =4
)
@endphp

@include('users.scriptSection')
