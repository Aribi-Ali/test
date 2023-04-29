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
        <h1 class="text-3xl font-bold mb-4">Register</h1>
        <form class="w-full">
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="username">
              Username
            </label>
            <input placeholder="username" class="w-full px-6 py-2 border rounded-lg text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" >
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="email">
              Email Address
            </label>
            <input placeholder="email" class="w-full px-6 py-2 border rounded-lg text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" >
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="password">
              Password
            </label>
            <input placeholder="password"  class="w-full px-6 py-2 border rounded-lg text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" >
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="confirm-password">
              Confirm Password
            </label>
            <input placeholder="confirm password" class="w-full px-6 py-2 border rounded-lg text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="confirm-password" type="password" >
          </div>
          <div class="flex items-center justify-around">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-28 rounded focus:outline-none focus:shadow-outline" type="button">
              Register
            </button>
          </div>
          <a class=" block mt-4 align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href=""> i have an account . . . </a>
        </form>
      </div>
    </div>



@endsection