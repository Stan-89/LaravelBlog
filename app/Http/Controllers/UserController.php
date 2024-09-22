<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Input;
use DB;
use App\Rules\thePasswordFormat;
use App\Category;
use App\User;
use App\Post;
use App\ContactMessage;
use Response;


class UserController extends Controller
{

    //Number of posts to show in dashboard (before clicking show all)
    private static $NUMBER_POSTS_DASH = 3;
    private static $NUMBER_MESSAGES_DASH = 3;
    private static $NUMBER_POSTS_PAGINATION = 2;
    private static $NUMBER_CATEGORIES_PAGINATION = 2;
    private static $NUMBER_MSGS_PAGINATION = 2;

    //Logging in
    public function getLogin()
    {
      //Check if logged, redirect if so
      if(Auth::check())
      {
        return redirect()->route('general.blog.index');
      }

      //Return the view for logging in
      return view('users.login');
    }

    //Post request login
    public function postLogin(Request $request)
    {
      //Prepare custom error messages
      $errorMessages = [
        'theUsername.required' => 'Please enter a username',
        'theUsername.alpha_num' => 'Only letters and numbers are allowed in a username',
        'thePassword.required' => 'Please enter a password'
      ];


      //Perform the validation
      $this->validate($request, [
        'theUsername' => 'bail|required|alpha_num',
        'thePassword' => ['bail', 'required', new thePasswordFormat],
      ], $errorMessages);

      //If we've reached so far - perform logging in
      if(!Auth::attempt(['username' => $request['theUsername'], 'password' => $request['thePassword']]))
      {
        return redirect()->back()->with(['fail' => 'Please enter a valid username/password!']);
      }


      return redirect()->route('theDashboard')->with('success', "You've succesfully logged in!");

    }


    //Log the user out, redirect to main page
    public function getLogout()
    {
      //The logout itself
      Auth::logout();

      //No need for a view, just a route redirection
      return redirect()->route('general.blog.index');
    }

    //Show the main dashboard
    public function mainUserPage()
    {
      //Get the current user's posts
      $theUser = Auth::user();
      $posts = $theUser->posts()->with('user')->orderBy('created_at', 'desc')->take(self::$NUMBER_POSTS_DASH)->get();

      //Get some number of messages
      $messages = ContactMessage::orderBy('created_at', 'desc')->take(self::$NUMBER_MESSAGES_DASH)->get();


      return view ('users.index', ['posts' => $posts, 'messages' => $messages]);
    }

    //Function whose functionalities are shared by both adding and editing
    private static function verifyCategories($givenCategories)
    {
      //Check if chosen categories are valid
      $verifiedCategories = DB::table('categories')->pluck('name');

      $categoriesArray = explode(',', $givenCategories);
      $allCategoriesOK = true;

      for($i=0; $i<count($categoriesArray) && $allCategoriesOK; $i++)
      {
        //So that we don't iterate for nothing
        $foundInside = false;
        for($j=0; $j<count($verifiedCategories) && !$foundInside; $j++)
        {
          if($categoriesArray[$i] == $verifiedCategories[$j])
          {
            $foundInside = true;
          }
        }

        //If not found, then no match
        if(!$foundInside)
        {
          $allCategoriesOK = false;
        }
      }

      return $allCategoriesOK;
    }

    //Add a post - show the page [ GET ]
    public function addPost()
    {
      $categories = DB::table('categories')->pluck('name');
      return view('users.addPost', ['theCategories' => $categories]);
    }


    //Adding a post - with a request [ POST ]
    public function addingPost(Request $request)
    {

      //Verify:Title and body
      $messages = [
        'theTitle.required'=>'Please enter a valid title.',
        'theTitle.max'=>'The title cannot be longer than 50 characters',
        'theMessage.required'=>'Please enter a valid post message.'
      ];

      $this->validate($request,[
        'theTitle' => 'required|max:50',
        'theMessage' => 'required'
      ],$messages);


      //Check if chosen categories are valid
      $verifiedCategories = DB::table('categories')->pluck('name');

      //When an input field is empt (nothing in it), it has ""
      if($request['theCategories'] != "")
      {
        //Use the function to check
        $allCategoriesOK = self::verifyCategories($request['theCategories']);

        //If a catagory was not valid
        if(!$allCategoriesOK)
        {
          return redirect()->route('addPost')->with('fail', 'Enter valid categories only!');
        }

      }

      //We're here: passed validation, let's insert
      $tempPost = new Post();
      $tempPost->title = $request['theTitle'];
      $tempPost->body = $request['theMessage'];
      Auth::user()->posts()->save($tempPost);

      //Now that the post is saved, add some categories
      if($request['theCategories'] != "")
      {
        $categoriesArray = explode(',', $request['theCategories']);

        foreach($categoriesArray as $category)
        {
          //Get eloquent equivalence for this category
          $tempCat = Category::where('name', $category)->first();
          $tempPost->categories()->attach($tempCat);
        }

      }

      //Go to page
      return redirect()->route('theDashboard')->with('success', 'Your post has been succesfuly added!');
    }



    //Edit a post - show the page [GET]
    public function editPost($id_post)
    {
      //Verify validity of the given id
      $outcome = self::verifyPost($id_post);
      //If not 'allGood'
      if($outcome !== 'allGood')
      {
        return redirect()->route('theDashboard')->with('fail', $outcome);
      }


      //Fetch info

      //Get the categories and fill in postCategories var
      $categories =  DB::table('categories')->pluck('name')->toArray();



      //Get the post itself
      $post = Post::where('id', '=', $id_post)->with(['user', 'categories'])->first();

      $postCategories = implode(",", $post->categories()->pluck('name')->toArray());

      //Return the view with all appropriate variables
      return view('users.editPost', ['theCategories' => $categories, 'postCategories' => $postCategories, 'post' => $post]);

    }

    //Editing a post
    public function editingPost(Request $request)
    {
      //Start by verifying if the post id is right
      $outcome = self::verifyPost($request['thePostID']);

      //If not 'allGood'
      if($outcome !== 'allGood')
      {
        return redirect()->route('theDashboard')->with('fail', $outcome);
      }

      //Verify:Title and body
      $messages = [
        'theTitle.required'=>'Please enter a valid title.',
        'theTitle.max'=>'The title cannot be longer than 50 characters',
        'theMessage.required'=>'Please enter a valid post message.'
      ];

      $this->validate($request,[
        'theTitle' => 'required|max:50',
        'theMessage' => 'required'
      ],$messages);


      //When an input field is empt (nothing in it), it has ""
      if($request['theCategories'] != "")
      {
        //Use the function to check
        $allCategoriesOK = self::verifyCategories($request['theCategories']);

        //If a catagory was not valid
        if(!$allCategoriesOK)
        {
          /*
              NOTE: When using back(), it will not be the old(...) values shown.
              It will be the values that were pre-loaded (so editPost method which uses editPost.blade.php but also in addition, a flash error message).
              Thus, we basically re-load the whole thing before printing it!
          */
          return redirect()->back()->with('fail', 'Enter valid categories only!');
        }

      }

      //We're here: passed validation, let's insert
      $tempPost = Post::find($request['thePostID']);
      $tempPost->title = $request['theTitle'];
      $tempPost->body = $request['theMessage'];
      $tempPost->update();

      //Now that the post is saved, add some categories

      //But before, delete all old ones [detach, thus deleting from many to many relation]
      $tempPost->categories()->detach();

      if($request['theCategories'] != "")
      {
        $categoriesArray = explode(',', $request['theCategories']);

        foreach($categoriesArray as $category)
        {
          //Get eloquent equivalence for this category
          $tempCat = Category::where('name', $category)->first();
          $tempPost->categories()->attach($tempCat);
        }

      }

      //Go to page
      return redirect()->route('editPost', ['post_id' => $tempPost->id])->with('success', 'Your post has been succesfuly edited!');
    }

    //Deleting a post
    public function deletingPost($id_post)
    {
      //Start by verifying if the post id is right
      $outcome = self::verifyPost($id_post);

      //If not 'allGood'
      if($outcome !== 'allGood')
      {
        return redirect()->route('theDashboard')->with('fail', $outcome);
      }

      //Get the post in question
      $post = Post::find($id_post);
      $post->categories()->detach();
      $post->delete();

      return redirect()->route('theDashboard')->with('success', 'You have succesfully deleted that post');

    }


    //Showing the posts
    public function showPosts()
    {
      //Get the posts of the currently logged user, paginate them and sort them by creation date
      $posts = Auth::user()->posts()->with(['user', 'categories'])->orderBy('created_at', 'desc')->paginate(self::$NUMBER_POSTS_PAGINATION);

      return view('users.showPosts', ['posts' => $posts]);
    }

    //Showing a single post
    public function showSinglePost($id_post)
    {
      $outcome = self::verifyPost($id_post);
      //If not 'allGood'
      if($outcome !== 'allGood')
      {
        return redirect()->route('theDashboard')->with('fail', $outcome);
      }

      /*
          Note: fetching first result WITH its relations:
          $post = Post::find($id_post)->with(['user', 'categories'])->first(); WON'T WORK.

          NOTE # 2: When fetching, do:
          1. Condition (where), 2. Relations (with); 3.Numbers we're going to fetch
          ex: $post = Post::where('id', '=', $id_post)->with(['user', 'categories'])->first();

      */

      $post = Post::where('id', '=', $id_post)->with(['user', 'categories'])->first();

      return view('users.singlePost', ['post' => $post]);
    }

    //Private function for verifying the post [used in show, delete and edit so it gets its own function]
    private static function verifyPost($id_post)
    {
      $varToReturn = 'allGood';

      //Check if argument is set
      if(empty($id_post))
      {
        $varToReturn = 'Invalid url!';
      }

      //Check if it exists
      $post = Post::find($id_post);
      if($varToReturn == 'allGood' && !$post)
      {
        $varToReturn = 'Invalid post!';
      }

      //Check if user
      $user = Auth::user();
      if($varToReturn == 'allGood' && $post->user->id != $user->id)
      {
        $varToReturn = 'I see what you did there :/';
      }

      return $varToReturn;

    }

    //Showing the categories
    public function showCategories()
    {
      //Get all of them, ordered by date of creation and paginated at the same itme.
      $categories = Category::orderBy('created_at', 'desc')->paginate(self::$NUMBER_MESSAGES_DASH);

      return view('users.categoriesPage', ['categories' => $categories]);

    }

    //Adding a category
    public function addCategory(Request $request)
    {
      //Messages for the check
      $messages = [
        'theName.required' => 'Please enter a name for the category',
        'theName.max' => 'Maximum of 30 characters for the name'
      ];

      //Validate
      $this->validate($request, [
        'theName' => 'required|max:30'
      ], $messages);

      //So far so good

      //Check for uniqueness
      if(Category::where('name', '=', $request['theName'])->count())
      {
        return redirect()->back()->with(['fail' => 'A category with this name already exists!']);
      }

      //Add it
      $category = new Category();
      $category->name = $request['theName'];
      $category->save();

      return redirect()->back()->with('success', 'The category '.$category->name.' has been succesfully added.');

    }

    //Deleting a category
    public function deleteCategory($id_category)
    {
      //Check if given id is valid!
      if($category = Category::find($id_category))
      {
        $category->posts()->detach();
        $category->delete();
        return redirect()->back()->with(['success' => 'The category was succesfully deleted!']);
      }
      else
      {
        return redirect()->back()->with(['fail' => 'I see what you did there :)']);
      }

    }


    //Getting the page for edit category
    //Edit a post - show the page [GET]
    public function editCategory($id_category)
    {
      //Check that the id_category is valid.
      if($category = Category::where('id', $id_category)->first())
      {
        return view('users.editCategory', ['category' => $category]);
      }
      else
      {
        return redirect()-back()->with(['fail' => 'Invalid category!']);
      }
    }



    //Editing a category, with POST
    public function editingCategory(Request $request)
    {
      //Note: in adding category, manual check for existance. Here: use VALIDATOR TO CHECK FOR UNIQUENESS
      //But if not the same name, (name in db, here theName) instead of unique:categories [unique:tableName]
      //We're going to have to specify the name. unique:categories,name
      $messages = [
        'theCategory.required' => 'A new name for the category is required',
        'theCategory.max' => 'Maximum of 30 characters for the name',
        'theCategory.unique' => 'The name must be unique!'
      ];

      //Validate
      $this->validate($request, [
        'theCategory' => 'bail|required|max:30|unique:categories,name'
      ], $messages);

      //So far, ok. Let's get it now
      if(!$category = Category::where('id', $request['theCategoryID'])->first())
      {
        return redirect()-back()->with(['fail' => 'Invalid category!']);
      }

      $category->name = $request['theCategory'];
      $category->update();

      return redirect()->route('editCategory', ['id_category' => $category->id])->with('success', 'Your category has been succesfuly edited!');
    }

    //Contact messages
    public function showMessages()
    {
      $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(self::$NUMBER_MSGS_PAGINATION);
      return view('users.showMessages', ['messages' => $messages]);
    }

    //Deleting a message
    public function deleteMessage($id_msg)
    {
      //If it doesn't exist
      if(!$theMsg = ContactMessage::find($id_msg))
      {
        return redirect()->route('showMessages')->with(['fail' => 'This message does not exist!']);
      }

      $theMsg->delete();
      return redirect()->route('showMessages')->with(['success' => 'The message was successfully deleted!']);
    }

    //Showing a single message
    public function viewSingleMessage($id_msg)
    {
      //If it doesn't exist
      if(!$theMsg = ContactMessage::find($id_msg))
      {
        return redirect()->back()->with(['fail' => 'This message does not exist!']);
      }


      return view('users.showSingleMessage', ['message' => $theMsg]);
    }


}
