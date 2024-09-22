@extends('user-master')

@section('styles')
    <link rel="stylesheet" href="{{ URL::to('css/form.css') }}">
@endsection

@section('theMainContent')
<div class="container">
  @include('general.other.info-box')
  <form action="{{route('editingCategory')}}" method="POST">
    <div class="input-group">
      <label for="theCategory">Category:{{ $category->name }}</label>
      <input type="text" name="theCategory" value="{{ old('theCategoryName') ? old('theCategoryName') : $category->name }}"
      {{$errors->has('theCategoryName') ? 'class=has-error': ''}}
    </div>
    <br/><br/>
    <button type="submit" class="btn">Edit category</button>
    <input type="hidden" name="_token" value = "{{ Session::token() }}" />
    <input type="hidden" name="theCategoryID" value="{{$category->id}}" />
  </form>
</div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{URL::to('js/common.js')}}"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        activateMenu(3);
      });
    </script>
@endsection
