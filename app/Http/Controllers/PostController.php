<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResourceCollection;
use App\Mail\TestMail;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\Array_;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Mailjet\LaravelMailjet\Facades\Mailjet;

class PostController extends Controller
{

    public function index()
    {

        $posts = Post::paginate(15);
        return view("post.posts", ["posts" => $posts]);
    }
    public function show($id)
    {
        $post = Post::with("user")->findOrFail($id);
        preg_match_all('/<img.*?src="(.*?)".*?>/i', $post->content, $images);
        if (count($images[1]) > 0) {
            $cover = (string) $images[1][0];
            $post->cover = $cover;
        }


    
        // Retrieve suggested articles based on post categories
        $suggestedArticles = $post->getSuggestedArticles(8);
    
        // Retrieve the cover image for the post and each suggested article
        $posts = $suggestedArticles->map(function($post) {
            preg_match_all('/<img.*?src="(.*?)".*?>/i', $post->content, $matches);
            $imageUrls = $matches[1];
            if (count($imageUrls) > 0) {
                $cover = (string) $imageUrls[0];
                $post->cover = $cover;
            }
            return $post;
        });
        preg_match_all('/<img.*?src="(.*?)".*?>/i', $post->content, $matches);
        $imageUrls = $matches[1];
        if (count($imageUrls) > 0) {
            $cover = (string) $imageUrls[0];
            $post->cover = $cover;
        }
    
        return view('post.show', compact('post', 'posts'));
    }
    


    public function reverse($id)
    {

        $post = Post::findOrfail($id);

        $post->isPublished = !$post->isPublished;
        $post->save();

        return redirect()->back();
    }
    public function edit($id)
    {

        $post = Post::with("categories")->findOrFAil($id);
        //return $post;
        $categories=Category::all();
        return view("post.update", ["post" => $post,"categories"=>$categories]);
    }


    public function update(Request $request, $id)
    {

          //  return $request->categories;
        $post = Post::findOrFAil($id);

        $post_content = DB::table('posts')
            ->where('id', $id)
            ->pluck('content')
            ->first();

        // Use a regular expression to extract the URLs of embedded images
        preg_match_all('/<img.*?src="(.*?)".*?>/i', $post_content, $matches);
        $imageUrls = $matches[1];


        // Iterate through the list of image URLs and delete each file from disk
        

        $isPublished = $request->has("isPublished") ? true : false;


        $post->title = $request->title;
        $post->summary = $request->summary;
        $post->content = $request->content;
        $post->isPublished = $isPublished;
        $post->save();
        $post->categories()->sync($request->categories);
/*
        foreach ($imageUrls as $url) {
            $filename = basename($url);
            // return  $filenam   e;
            Storage::delete('public/' . $filename);
        }
*/
        return redirect()->back();
    }


    public function delete($id)
    {



        $post = Post::findOrFail($id);

        $post_content = DB::table('posts')
            ->where('id', $id)
            ->pluck('content')
            ->first();

        // Use a regular expression to extract the URLs of embedded images
        preg_match_all('/<img.*?src="(.*?)".*?>/i', $post_content, $matches);
        $imageUrls = $matches[1];



        // Iterate through the list of image URLs and delete each file from disk
        foreach ($imageUrls as $url) {
            $filename = basename($url);

            // return  $filenam   e;
            Storage::delete('public/' . $filename);
        }

        // Finally, delete the post from the database
        $post->delete();

        // Optionally, you can redirect the user to a success page or display a success message
        return redirect()->back()->with('success', 'Post deleted successfully.');
    }


    /*
     public function store(Request $request )
     {

    /*
              // Validate the incoming request data
              $request->validate([
                  'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              ]);
              */
    // Get the image file from the request
    /*
              $image = $request->file('upload');
              
              // Generate a unique filename for the image
              $filename = uniqid() . '.' . $image->getClientOriginalExtension();
              
              // Store the image on disk
              $image->storeAs('local', $filename);
              
              // Generate the image URL
              $imageUrl = asset('storage/images/' . $filename);
              
              // Return the image URL in a JSON response



            //  echo $imageUrl;
              return response()->json([
                  'url' => $imageUrl,
              ]);
          }
          
     */

    public function uploadImage(Request $request)
    {
        // Validate the incoming request data
        /* $request->validate([
                  'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              ]);*/

        if ($request->hasFile('upload')) {
            // Get the image file from the request
            $image = $request->file('upload');

            // Generate a unique filename for the image
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();

            // $image = $this->resizeImage($image,800,null);


            // Store the image on the local disk
            $image = $image->storeAs('public', $filename, 'local');

            // Generate the image URL
            $imageUrl = asset('storage/' . $filename);

            // Return the image URL in a JSON response
            return response()->json([
                'url' => $imageUrl,
            ]);
        }
        return response()->json([
            'error' => "some thing went wrong"
        ]);
    }



    public function upload(Request $request)
    {

        $post = new Post();
        $post->id = 0;
        $image = $post->addMediaFromRequest("upload")->toMediaCollection("images");
        $url = $image->getUrl();

        return response()->json(["url" => $url], 200);
    }


    public function deleteMedia()
    {

        Media::find(1)->delete();
        return "deleted ";
    }



    public function create()
    {
        $categories=Category::all();
        return view("post.create",["categories"=>$categories]);
    }

    public function storePost(Request $request)
    {

//return $request;
        $slug = $this->generateUniqueSlug($request->title, Post::class);

        $isPublished = $request->has("isPublished") ? true : false;

        $post = new Post();

        $post->title = $request->title;
        $post->summary = $request->summary;
        $post->content = $request->content;
        $post->slug = $slug;
        $post->isPublished = $isPublished;
        $post->user_id= Auth::user()->id;
        $post->save();
        $post->categories()->sync($request->categories);




        return redirect()->route('post.index');
    }





    static function generateUniqueSlug($title, $model, $separator = '-')
    {
        $slug = Str::slug($title, $separator);

        // Check if the slug already exists in the database
        $count = 0;
        $originalSlug = $slug;
        while ($model::where('slug', $slug)->exists()) {
            $count++;
            $slug = $originalSlug . $separator . $count;
        }

        return $slug;
    }

    static public function resizeImage($file, $maxWidth, $maxHeight)
    {
        $image = Image::make($file);

        $image->resize($maxWidth, $maxHeight, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return $image;
    }


    public function testMail(){
        
        $post=Post::first();

      if(Mail::to("mohamedbrabuz7@gmail.com")->send(new TestMail($post))) {
        return "done";
      }
        

        return `ipconfig`;

    }



}
