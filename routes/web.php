<?php

//Main page
Route::get('/',[
  'uses' => 'PostController@getBlogIndex',
  'as'=>'general.blog.index'
]);

//All of these pages contain /blog/ in the beginning of their url, so group them
Route::group(['prefix' => 'blog'], function()
{
  //Same page (blog index)
  Route::get('/',[
    'uses' => 'PostController@getBlogIndex',
    'as'=>'general.blog.index'
  ]);

  //Showing posts of a specific user
  Route::get('/userPosts/{id_user}',[
    'uses' => 'PostController@getPostsUser',
    'as'=>'general.blog.postsByUser'
  ]);

  //Showing the posts that contain a specific category
  Route::get('/categoryPosts/{id_category}',[
    'uses'=>'PostController@getPostsCategory',
    'as'=> 'general.blog.postsByCategory'
  ]);

  //For the showing of a single blog
  Route::get('/{id_post}', [
    'uses'=>'PostController@getSinglePost',
    'as' => 'general.blog.singlePost'
  ]);

});


//See difference of about vs contact: about does not require a controller

//About: needs no controller
Route::get('/about', function(){
  return view('general.other.about');
})->name('about');

//Contact: with a controller
Route::get('/contact', [
  'uses'=>'ContactMessageController@getContactIndex',
  'as' => 'contact'
]);

//Search (static): no controller
Route::get('/search', function(){
  return view('general.other.search');
})->name('searchStatic');

//Calling a route: route('showName', ['extraParam' => $quote->name->nameValue])

/*
Route::get('/',[
  'uses' => 'QuoteController@mainPageFetch',
  'as' => 'mainPage'
]);
*/

/*
//Search results
Route::post('/searchResults', [
  'uses' => 'PostController@searchResults',
  'as' =>  'searchResults'
]);
No post for search results if we're going to paginate (search info in request)
Better use get
*/
//Search results
Route::get('/searchResults',[
  'uses' => 'PostController@searchResults',
  'as' =>  'searchResults'
]);

//Contact form process
//We can give it the same URL as the form contact, the other one was a GET. This one is a POST.
Route::post('/contact', [
  'uses' => 'ContactMessageController@processMessage',
  'as' => 'processMessage'
]);



//--------------- User part from here on
Route::group(['prefix' => 'user'], function()
{

    //Login part
    Route::get('/login', [
      'uses' => 'UserController@getLogin',
      'as' => 'getLogin'
    ]);

    Route::post('/login', [
      'uses' => 'UserController@postLogin',
      'as' => 'postLogin'
    ]);


    //All of these : needs to be logged in
Route::group(['middleware' => 'auth'], function(){
      //Logout
      Route::get('/logout', [
        'uses' => 'UserController@getLogout',
        'as' => 'getLogout'
      ]);


      Route::get('/dashboard',[
        'uses' => 'UserController@mainUserPage',
        'as' => 'theDashboard'
      ]);

      Route::get('/showPosts',[
        'uses' => 'UserController@showPosts',
        'as' => 'showPosts'
      ]);

      Route::get('/showSinglePost/{post_id}', [
        'uses' => 'UserController@showSinglePost',
        'as' => 'showSinglePost'
      ]);

      Route::get('/editPost/{post_id}',[
        'uses' => 'UserController@editPost',
        'as' => 'editPost'
      ]);

      Route::post('/editingPost',[
        'uses' => 'UserController@editingPost',
        'as' => 'editingPost'
      ]);

      Route::get('/addPost', [
        'uses' => 'UserController@addPost',
        'as' => 'addPost'
      ]);

      Route::post('/addPost', [
        'uses' => 'UserController@addingPost',
        'as' => 'addingPost'
      ]);

      Route::get('/deletingPost/{post_id}', [
        'uses' => 'UserController@deletingPost',
        'as' => 'deletingPost'
      ]);

      //Categories
      Route::get('/categoriesPage', [
        'uses' => 'UserController@showCategories',
        'as' => 'categoriesPage'
      ]);

      //Adding a category
      Route::post('/addingCategory', [
        'uses' => 'UserController@addCategory',
        'as' => 'addingCategory'
      ]);

      //Deleting a category
      Route::get('/deleteCategory/{id_category}', [
        'uses' => 'UserController@deleteCategory',
        'as' => 'deletingCategory'
      ]);

      //Editing a category
      Route::get('/editCategory/{id_category}', [
          'uses' => 'UserController@editCategory',
          'as' => 'editCategory'
      ]);

      //Editing a category
      Route::post('/editingCategory', [
        'uses' => 'UserController@editingCategory',
        'as' => 'editingCategory'
      ]);

      //Messages page
      Route::get('/showMessages',[
        'uses' => 'UserController@showMessages',
        'as' => 'showMessages'
      ]);

      //Deleting a msg
      Route::get('/deleteMessage/{id_msg}', [
        'uses' => 'UserController@deleteMessage',
        'as' => 'deleteMessage'
      ]);

      //Viewing a single message
      Route::get('/viewSingleMessage/{id_msg}', [
        'uses' => 'UserController@viewSingleMessage',
        'as' => 'viewSingleMessage'
      ]);
});


});
