@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-7 offset-3 mt-4">
                <div class="card-body">
                    <form method="post" action="{{ route('category.store') }}" enctype="multipart/form-data" >
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="confirm-password">
                                name
                            </label>
                            <input placeholder="name" name="name"
                                class="w-full px-6 py-2 border rounded-lg text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="title"
                                id="title" type="title">
                        </div>
                     

                          
                          <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="summary">description</label>
                            <textarea class="form-textarea mt-1 block w-full border rounded-md py-2 px-3 placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" id="summary" name="description" rows="3" placeholder="Enter a summary for your post"></textarea>
                          </div>
                          



                        <button class="my-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-28 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Register
                          </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

