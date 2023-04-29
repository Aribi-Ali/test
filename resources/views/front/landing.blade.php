@extends("layouts.admin")

@section("css")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" integrity="sha512-2zjbAnSrnD3+Xt3q10IhOkPuL1J2MQxR+MwNGZ8rNYYClfETNjjA9XVlFl5y5wo7J5k5ON5x7mb+nb2ZJFHS7w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section("content")
<nav class="flex items-center justify-between flex-wrap bg-gray-800 p-6">
    <div class="flex  items-center flex-shrink-0 text-white mr-6">
        <span class="font-semibold text-xl tracking-tight">Articly</span>
    </div>
    <div id="menu" class="block lg:hidden">
        <button  class="flex items-center px-3 py-2 border rounded text-gray-300 border-gray-300 hover:text-white hover:border-white">
            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3a3 3 0 016 0v1a3 3 0 01-6 0V3zm8 5a3 3 0 100 6 3 3 0 000-6zm-3 3a3 3 0 110-6 3 3 0 010 6zm11-6a3 3 0 00-3 3v1a3 3 0 006 0V3a3 3 0 00-3-3z"/></svg>
        </button>
    </div>
     {{--! to make items on right   !--}}
    <div class="w-full block lg:flex lg:items-center lg:w-auto" id="items">
        <div class="text-sm lg:flex-grow">
            <a href="#about" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white mr-4">
                About
            </a>
            <a href="#services" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white mr-4">
                Services
            </a>
            <a href="#contact" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white">
                Contact
            </a>
            
           
        </div>
    </div>
</nav>


@endsection


@section("scripts")
<script>
    // Get the hamburger menu button and the navigation links div
    const menuBtn = document.getElementById("menu");
  const navLinks = document.getElementById("items");
  
    // Add a click event listener to the hamburger menu button
    menuBtn.addEventListener("click", () => {
        //console.log("clicked")
      // Toggle the "hidden" class on the navigation links div
      navLinks.classList.toggle("hidden");
    });




  </script>
@endsection  