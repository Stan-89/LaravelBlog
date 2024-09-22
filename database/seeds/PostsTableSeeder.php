<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Post;
use App\Category;
use App\ContactMessage;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Time to populate

        //First: a few users
        $user1 = new User();
        $user1->username = "FirstOne";
        $user1->email = "firstemail@hotmail.com";
        $user1->password = bcrypt("firstPass1");
        $user1->save();

        $user2 = new User();
        $user2->username = "SecondOne";
        $user2->email = "secondemail@hotmail.com";
        $user2->password = bcrypt("secondPass2");
        $user2->save();

        $user3 = new User();
        $user3->username = "ThirdOne";
        $user3->email = "thirdemail@hotmail.com";
        $user3->password = bcrypt("thirdPass3");
        $user3->save();


        $user4 = new User();
        $user4->username = "FourthOne";
        $user4->email = "fourthemail@hotmail.com";
        $user4->password = bcrypt("fourthPass4");
        $user4->save();


        $user5 = new User();
        $user5->username = "FifthOne";
        $user5->email = "fifthemail@hotmail.com";
        $user5->password = bcrypt("fifthPass5");
        $user5->save();

        $user6 = new User();
        $user6->username = "NoPostsUser";
        $user6->email = "something@somewhere.ca";
        $user6->password = brcypt('sixthPass6');
        $user6->save();

        //Now, let's give them some posts
        $post1 = new Post();
        $post1->title = "Post number 1";
        $post1->body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
        aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
         non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $user1->posts()->save($post1);

        $post2 = new Post();
        $post2->title = "Post number 2";
        $post2->body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
        aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
         non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $user1->posts()->save($post2);

        $post3 = new Post();
        $post3->title = "Post number 3";
        $post3->body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
        aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
         non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $user1->posts()->save($post3);

        $post4 = new Post();
        $post4->title = "Post number 4";
        $post4->body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
        aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
         non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $user3->posts()->save($post4);

        $post5 = new Post();
        $post5->title = "Post number 5";
        $post5->body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
        aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
         non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $user3->posts()->save($post5);

        $post6 = new Post();
        $post6->title = "Post number 6";
        $post6->body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
        aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
         non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $user4->posts()->save($post6);


        $post7 = new Post();
        $post7->title = "Post number 7";
        $post7->body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
        aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
         non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $user5->posts()->save($post7);


        $post8 = new Post();
        $post8->title = "Post number 8";
        $post8->body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
        magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
        aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
         non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $user4->posts()->save($post8);

        //Let's create a few categories
        $category1 = new Category();
        $category1->name = "Category 1";
        $category1->save();

        $category2 = new Category();
        $category2->name = "Category 2";
        $category2->save();

        $category3 = new Category();
        $category3->name = "Category 3";
        $category3->save();

        $category4 = new Category();
        $category4->name = "Category 4";
        $category4->save();

        $category5 = new Category();
        $category5->name = "Category 5";
        $category5->save();

        $category6 = new Category();
        $category6->name = "Category 6";
        $category6->save();

        //Now let's assign categories to posts
        $category1->posts()->attach($post1);
        $category1->posts()->attach($post2);
        $category2->posts()->attach($post1);
        $category2->posts()->attach($post3);

        $post4->categories()->attach($category4);
        $post5->categories()->attach($category4);
        $post6->categories()->attach($category4);
        $post4->categories()->attach($category5);
        $post5->categories()->attach($category6);
        $post6->categories()->attach($category6);

        //And finally, some msgs
        $contactMessage1 = new ContactMessage();
        $contactMessage1->sender = "Sender 1";
        $contactMessage1->email = "email1@hotmail.com";
        $contactMessage1->subject = "Subject 1";
        $contactMessage1->body = "Body 1";
        $contactMessage1->save();

        $contactMessage2 = new ContactMessage();
        $contactMessage2->sender = "Sender 2";
        $contactMessage2->email = "email2@hotmail.com";
        $contactMessage2->subject = "Subject 2";
        $contactMessage2->body = "Body 2";
        $contactMessage2->save();

        $contactMessage3 = new ContactMessage();
        $contactMessage3->sender = "Sender 3";
        $contactMessage3->email = "email3@hotmail.com";
        $contactMessage3->subject = "Subject 3";
        $contactMessage3->body = "Body 3";
        $contactMessage3->save();

        $contactMessage4 = new ContactMessage();
        $contactMessage4->sender = "Sender 4";
        $contactMessage4->email = "email4@hotmail.com";
        $contactMessage4->subject = "Subject 4";
        $contactMessage4->body = "Body 4";
        $contactMessage4->save();


    }
}
