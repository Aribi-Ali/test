@extends('layouts.dashboard')

@section('content')
<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    title
                </th>
                <th scope="col" class="px-6 py-3">
                    slug
                </th>
                <th scope="col" class="px-6 py-3">
                    status
                </th>
                <th scope="col" class="px-6 py-3">
                    sumary
                </th>
                <th scope="col" class="px-6 py-3">
                    actions
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
            <a href="{{route("post.show",[$post->id])}} " class="hover:bg-green-400">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200">
                
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            <a href="{{route("post.show",[$post->id])}} " >
                
                    {{$post->title}}
            </a>

                </th>
                <td class="px-6 py-4">
                    {{$post->slug}}
                </td>
                <td class="px-6 py-4">
                    <a href="{{route("post.reverse",[$post->id])}}" class="{{reversePost($post->isPublished)}}">

                        {{isPublished($post->isPublished)}}

                    </a>
                </td>
                <td class="px-6 py-4">
                    {{$post->summary}}
                </td>
                <td class="px-6 py-4 flex ">
                    <a href="{{route("post.delete",[$post->id])}}" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">delete</a>
                    <a href="{{route("post.edit",[$post->id])}} " class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">edit</a>
                </td>
            </tr>

            @endforeach

           
        </tbody>
    </table>
    <div class="pagination my-2">
        {{ $posts->links() }}
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
    
    

    </script>
@endsection
