@extends('user-master')

@section('styles')
    <link rel="stylesheet" href="{{ URL::to('css/form.css') }}">
@endsection

@section('theMainContent')
<div class="container">
  @include('general.other.info-box')
  <form action="{{route('editingPost')}}" method="POST">
    <div class="input-group">
      <label for="theTitle">Title</label>{{$post->theTitle}}
      <input type="text" name="theTitle" id="title" value="{{old('theTitle') ? old('theTitle') : isset($post) ? $post->title : ''}}" {{$errors->has('theTitle') ? 'class=has-error' : ''}} />
    </div>
    <div class="input-group">
      <label for="selectCategories">Add categories</label>
      <select name="selectCategories" id="category_select">
        @foreach($theCategories as $category)
          <option value="{{$category}}">{{$category}}</option>
        @endforeach
      </select>
      <button type="button" class="btn">Add category</button>
      <div class="added-categories">
        <ul>
          @if(old('theCategories'))
            @php
              $oldCategories = old('theCategories');
            @endphp
          @endif

          @if(isset($postCategories))
            @php
              $oldCategories = $postCategories;
            @endphp
          @endif
          @if($oldCategories)
            @php
              $arrayCategories = explode(',', $oldCategories);
            @endphp
            @foreach($arrayCategories as $category)
              <li><a href="#" data-category_id="{{$category}}">{{$category}}</a></li>
            @endforeach
          @endif
        </ul>
      </div>
      <input type="hidden" name="theCategories" id="categories" value="{{old('theCategories') ? old('theCategories') : isset($postCategories) ? $postCategories : ''}}">
    </div>
    <div class="input-group">
      <label for="body">Body</label>
      <textarea name="theMessage" id="body" rows="12" {{$errors->has('theMessage') ? 'class=has-error' : ''}}>{{old('theMessage') ? old('theMessage') : isset($post) ? $post->body : ''}}</textarea>
    </div>
    <button type="submit" class="btn">Edit post</button>
    <input type="hidden" name="_token" value="{{ Session::token()}}"/>
    <input type="hidden" name="thePostID" value="{{old('thePostID') ? old('thePostID') : isset($post) ? $post->id : ''}}" />
  </form>
</div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{URL::to('js/posts.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('js/common.js')}}"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        activateMenu(2);
      });
    </script>
@endsection
