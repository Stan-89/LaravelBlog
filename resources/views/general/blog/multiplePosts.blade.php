  <?php
  //Paginating -> since all the same for all cases
  //Also: displaying
  ?>
  @foreach($posts as $post)
    <article>
      <h3>{{$post->title}}</h3>
      <span class="subtitle">Author: <a href="{{route('general.blog.postsByUser', ['user_id' => $post->user->id])}}">{{$post->user->username}}</a> | {{$post->updated_at}}</span>
      <p>{{substr($post->body, 0, 75)}}...</p>
      <a href="{{route('general.blog.singlePost', ['post_id' => $post->id])}}">Read more</a>
    </article>
  @endforeach

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
