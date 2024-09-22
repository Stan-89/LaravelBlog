@extends('user-master')

@section('styles')
    <link rel="stylesheet" href="{{ URL::to('css/categories.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection

@section('theMainContent')
<div class="container">
  @include('general.other.info-box')
  <section id="category-admin">
    <form action="{{route('addingCategory')}}" method="POST">
      <div class="input-group">
        <label for="theName">Category name</label>
        <input type="text" name="theName" id="name"/>
        <button type="submit" class="btn">Create category</button>
        <input type="hidden" name="_token" value="{{ Session::token()}}"/>
      </div>
    </form>
  </section>

  <section class="list">
      @if(count($categories) ==0)
        No categories
      @endif
      @foreach($categories as $category)
        <article>
          <div class="category-info" data-id="{{$category->id}}">
            <h3>{{$category->name}}</h3>
          </div>
          <div class="edit">
            <nav>
                <ul>
                  <li class="category-edit"><input type="text" /></li>
                  <li><a href="{{route('editCategory', ['category_id' => $category->id])}}">Edit</a></li>
                  <li><a href="{{route('deletingCategory', ['id_category' => $category->id])}}" class="danger deleteLink">Delete</a></li>
                </ul>
          </div>
        </article>
      @endforeach
  </section>

  <section class="pagination">
    @if($categories->previousPageUrl() != "")
        @if($categories->currentPage() != 1)
          <a href="{{$categories->url(1)}}" class="linkNavigation"> << </a>
        @else
          <div class="emptyLink"></div>
        @endif
      <a href="{{$categories->previousPageUrl()}}" class="linkNavigation"> < </a>
    @else
      <div class="emptyLink"></div>
      <div class="emptyLink"></div>
    @endif
    @if($categories->nextPageUrl() != "")
      <a href="{{$categories->nextPageUrl()}}" class="linkNavigation"> > </a>
      @if($categories->currentPage() != $categories->lastItem())
        <a href="{{$categories->url($categories->lastPage())}}" class="linkNavigation"> >> </a>
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
$theSection = 3
)
@endphp

@include('users.scriptSection')
