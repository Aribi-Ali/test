@extends('layouts.dashboard')

@section('css')
<link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
 
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js">
    </script>
 
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js">
    </script>
 
    <!-- Default bootstrap CSS link taken from the
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        bootstrap website-->
 
    <script src=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js">
    </script>
@endsection
@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-7 offset-3 mt-4">
                <div class="card-body">
                    <form method="post" action="{{ route('post.update',[$post->id]) }}" enctype="multipart/form-data" >
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="confirm-password">
                                title
                            </label>
                            <input placeholder="title"
                                class="w-full px-6 py-2 border rounded-lg text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="title"
                                id="title" type="title" value="{{$post->title ?? "" }} ">
                        </div>
                     
                        <div class="flex items-center my-2 ">
                            <input type="checkbox" name="isPublished" id="isPublished" value="{{$post->isPublished ? 1 : 0}}" {{$post->isPublished ? "checked" : ""}}  " class="form-checkbox h-5 w-5 text-blue-600 transition duration-150 ease-in-out">
                            <label for="isPublished" id="publishedLabel" class="ml-2 text-gray-700">{{isPublished($post->isPublished)}}</label>
                          </div>
                          

                          
                          <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="summary">Summary</label>
                            <textarea   class="form-textarea mt-1 block w-full border rounded-md py-2 px-3 placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" id="summary" name="summary" rows="3" placeholder="Enter a summary for your post">{{$post->summary }}</textarea>
                          </div>
                          
                        
                          <label class="block text-gray-700 font-bold mb-2" for="summary">categories</label>
                         
                          <div class="my-4  row justify-content-center align-items-center">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group form">
                 
                                    <!-- Various options in drop down menu to
                                        select the types of data structures
                                        that we need -->
                                    <select class="mul-select w-full" name="categories[]" multiple="true">
                                        @foreach ($categories as $category)
                                    <option value="{{$category->id}}"   {{selectedCategory($category->id,$post->categories)}}>{{ $category->name }}</option>
                                @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <label class="block text-gray-700 font-bold mb-2" for="summary">content</label>

                           
                          <textarea id="editor"  class="form-textarea mt-1 block w-full border rounded-md py-2 px-3 placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"  name="content" rows="3" placeholder="Enter a content for your post">{{$post->content }}</textarea>



                        <button class="my-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-28 rounded focus:outline-none focus:shadow-outline" type="submit">
                            update
                          </button>
                          
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection




@section('scripts')
    <script>
       

        
    
    
    console.log('{{route('image.upload')}}')



            const checkbox = document.getElementById("isPublished");
const label = document.getElementById("publishedLabel");

checkbox.addEventListener("change", function() {
  if (checkbox.checked) {
    checkbox.value = true;
    label.textContent = "Published";
  } else {
    checkbox.value = false;
    label.textContent = "Not Published";
  }
  checkbox.classList.add("animate-pulse");
  setTimeout(() => checkbox.classList.remove("animate-pulse"), 500);
});



// adapter 


class MyUploadAdapter {
    constructor( loader ) {
        // The file loader instance to use during the upload.
        this.loader = loader;
    }

    // Starts the upload process.
    upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
    }

    // Aborts the upload process.
    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }

    // Initializes the XMLHttpRequest object using the URL passed to the constructor.
    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();

        // Note that your request may look different. It is up to you and your editor
        // integration to choose the right communication channel. This example uses
        // a POST request with JSON as a data structure but your configuration
        // could be different.
        xhr.open( 'POST', '{{route('image.upload')}}', true );
        xhr.responseType = 'json';
        xhr.setRequestHeader('x-csrf-token','{{csrf_token()}}')
    }

    // Initializes XMLHttpRequest listeners.
    _initListeners( resolve, reject, file ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${ file.name }.`;

        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;



            console.log(response);

            // This example assumes the XHR server's "response" object will come with
            // an "error" which has its own "message" that can be passed to reject()
            // in the upload promise.
            //
            // Your integration may handle upload errors in a different way so make sure
            // it is done properly. The reject() function must be called when the upload fails.
            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }

            // If the upload is successful, resolve the upload promise with an object containing
            // at least the "default" URL, pointing to the image on the server.
            // This URL will be used to display the image in the content. Learn more in the
            // UploadAdapter#upload documentation.
            resolve( {
                default: response.url
            } );
        } );

        //console.log(response.url)

        // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
        // properties which are used e.g. to display the upload progress bar in the editor
        // user interface.
        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
    }

    // Prepares the data and sends the request.
    _sendRequest( file ) {
        // Prepare the form data.
        const data = new FormData();

        data.append( 'upload', file );

        // Important note: This is the right place to implement security mechanisms
        // like authentication and CSRF protection. For instance, you can use
        // XMLHttpRequest.setRequestHeader() to set the request headers containing
        // the CSRF token generated earlier by your application.

        // Send the request.
        this.xhr.send( data );
    }
}

function simpleUploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new MyUploadAdapter( loader );
    };
}


ClassicEditor
    .create( document.querySelector( '#editor' ), {
        extraPlugins: [ simpleUploadAdapterPlugin ],


        // More configuration options.
        // ...
    } )
    
    .catch( error => {
        console.log( error );
    } );

    
    $(document).ready(function() {
            $(".mul-select").select2({
                placeholder: "select data-structures",
                tags: true,
            });
        })
  
    
    </script>
@endsection
