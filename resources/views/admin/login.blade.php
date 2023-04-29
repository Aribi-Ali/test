@extends("layouts.admin")


@section("css")
<style>
    body {
      background-image: linear-gradient(to bottom right, #48bb78, #f6e05e);
    }
  </style>
  @endsection
@section("content") 
    <div class="flex flex-col items-center justify-center min-h-screen py-2">
      <div class="flex flex-col items-center bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-4">Login</h1>
        <form class="w-full" method="POST" action="{{route("login")}} ">
            @csrf
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="email">
              email
            </label>
            
            <input name="email" class="w-full px-3 py-2 border rounded-lg text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email">
            @error("email")
            <div style="background-color: #fef2f2; border: 1px solid #e74c3c; color: #c0392b; padding: 10px; border-radius: 5px;" class="my-2">
              <span style="display: block; margin-top: 5px;">{{$message}}</span>
            </div>
            @enderror
            
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="password">
              Password
            </label>
            <input name="password" class="w-full px-3 py-2 border rounded-lg text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Password">
            @error("password")
            <div style="background-color: #fef2f2; border: 1px solid #e74c3c; color: #c0392b; padding: 10px; border-radius: 5px;" class="my-2">
              <span style="display: block; margin-top: 5px;">{{$message}} </span>
            </div>
            @enderror
                     
          </div>
          <div >
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-28 rounded focus:outline-none focus:shadow-outline" type="submit">
              Sign In
            </button>
                <a class=" mt-2 block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                    Forgot Password?
                </a>
          </div>
        </form>
      </div>
    </div>
  


@endsection