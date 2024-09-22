<?php
namespace App\Http\Controllers;
use App\Post;
use App\User;
use App\Category;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Input;


class PostController extends Controller
{

  //For public posts -> general . *
  private static $NUMBER_POSTS_PAGE = 2;

  //Index page
  public function getBlogIndex()
  {
    //Fetch 3 posts per page, along with user (fk) so we can show a link to the profile
    //and also the category that it's in [with arguments are the relations previously defined inside the model]
    $posts = Post::with(['user', 'categories'])->orderBy('created_at', 'desc')->paginate(self::$NUMBER_POSTS_PAGE);
    return view ('general.blog.mainBlog', ['posts' => $posts]);
  }

  //getting a single post
  public function getSinglePost($id_post)
  {
    //Fetch the post
    //First works, but ->user and ->categories will fetch them inside the view so
    //better if we look them up here (ex: $post->user will go fetch the users in the view; $post->categories will fetch the cats)
    //$post = Post::where('id', $post_id)->first();

    //Using with, we fetch the information in adance (can check with print_r) so
    //the view's only job is to print (also: different front end could be possible this way)
    $post = Post::where('id', $id_post)->with(['user', 'categories'])->first();

    //No such post exists
    if($post == null)
    {
      return redirect()->route('general.blog.index');
    }
    return view('general.blog.singlePost', ['post' => $post]);
  }


  //Get posts by category, argument is user_id
  public function getPostsUser($id_user)
  {
    //Get the user object based on the id
    //But this way we wouldn't have access to the categories

    //So we must use eloquent, but with the following we're not able to ORDER BY DATE OF CREATION [on posts]
  //  $user = User::where('id', $id_user)->with('posts')->first();

  //$user = User::where('posts.id', $id_user)->with('posts')->join('posts', 'posts.user_id', '=', 'users.id')->orderBy('posts.created_at', 'desc')->first();

    /*
      Note: before:
      $user = User::where('id', $id_user)->with('posts')->first();
      but problem is that we fethc all of the posts, and then we paginate further down in
      $posts= $user->posts()->with('categories')->orderBy('created_at', 'desc')->paginate(self::$NUMBER_POSTS_PAGE);

      so, just leave User:where('id', $id_user)->first() instead and alter on
      $theUser->posts() WILL FETCH THE POSTS and apply structuring and stuff. Much better this way. Same thing for categories
    */



    $user = User::where('id', $id_user)->first();

    //No such post exists
    if($user == null)
    {
      return redirect()->route('general.blog.index');
    }

  //  $posts = Post::paginate(self::$NUMBER_POSTS_PAGE);

    //Posts only for that user in particular
    /*
    $posts = Post::whereHas('user', function($query){
      $query->where('id', '=', '1');
    })->with(['user', 'categories'])->paginate(self::$NUMBER_POSTS_PAGE);
    Can't get a var inside that query,also: we can get them directly when querying the User using WITH (the POSTS associated to it will come)
    */
    //We get the categories here before paginating
    $posts= $user->posts()->with('categories')->orderBy('created_at', 'desc')->paginate(self::$NUMBER_POSTS_PAGE);

    /*
      NOTE ON SORTING (ORDERING) AND THE DIFFERENT RELATIONS:
      With eloquent, $user = User::where ... ->orderBy(...) WILL ONY APPLY TO USER.
      If we want to sort the WITH Relation, we CANNOT Do it in place. We muust do it separetely, in a different variable.
      so:
      $posts=$user->posts_.with('categories')->orderBy(...)  -> paginate [THIS WILL ORDER THE POSTS THEMSELVES]



    */


    return view ('general.blog.postsByUser', ['user' => $user, 'posts' => $posts, 'theUserID' => $user->id]);
  }

  //Get posts by category
  public function getPostsCategory($id_category)
  {
    //Get the category
    $category = Category::where('id', $id_category)->first();
    //If we use ->find(), it will only give us the 1st res

    if($category == null)
    {
      return redirect()->route('general.blog.index');
    }

    //Now, the posts with their users and categories (for printing)
    //When using with: use the name of the relationships that we defined in model.
    $posts = $category->posts()->with(['user', 'categories'])->orderBy('created_at', 'desc')->paginate(self::$NUMBER_POSTS_PAGE);

    return view('general.blog.postsByCategory', ['category' => $category, 'posts' => $posts]);
  }

  //Search results
  //Note: Request also works with GET, use ['nameOfInputField'] from form
  public function searchResults(Request $request)
  {
    //Check if something was quried
    if(empty($request['searchQuery']))
    { //Note: can only send 1 session var with redirect, array doesn't work
      return redirect()->route('searchStatic')->with('fail', 'Please enter a valid search value');
    }

    //Query the title and body
    //NTS: WHERE field can be array with mulitple conditions [WHERE ...1 AND ...2 AND ...3]
    $posts = Post::where('title', 'like', '%'.$request['searchQuery'].'%')
              ->orWhere('body', 'like', '%'.$request['searchQuery'].'%')
              ->with(['user'])
              ->orderBy('created_at', 'desc')
              ->paginate(self::$NUMBER_POSTS_PAGE);
              //Note: if just 'posts'=> $posts, pagination WILL NOT TAKE CARE OF GET PARAMS, they will be left out (ex: /searchResults?page=2)
              //So by ->appends(Input::except('page')), we append this url for the future pagination

    return view('general.blog.searchResults', ['searchTerms' => $request['searchQuery'], 'posts' => $posts->appends(Input::except('page'))]);
  }

}
