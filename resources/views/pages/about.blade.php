@extends('layouts.app')


@section('content')
	<x-frontend_header/>

<main class="bg-[url('/assets/bg3.jpeg')]  bg-cover bg-center origin-bottom items-center z-50 ">

		<div class="sm:flex  min-h-[100svh] items-center bg-black bg-opacity-60 mx-auto ">
    <div class="sm:w-1/2 p-10">
        <div class="image object-center text-center">
            <img src="{{ asset('assets/about.png')}}">
        </div>
    </div>
    <div class="sm:w-1/2 p-5">
        <div class="text">
            <span class="text-gray-500 border-b-2 border-indigo-600 uppercase">About us</span>
            <h2 class="my-4 font-bold text-3xl  sm:text-4xl ">About <span class="text-indigo-600">Our Company</span>
            </h2>
            <p class="text-gray-300">
               This online barbershop reservation is for Angeles City to facilitate their haircut and not have to wait for a long time at the actual barbershop. This website was created so that they don't run out of time waiting at the barbershop.

            </p>
        </div>
    </div>
</div>
	</main>

@endsection
 @section('scripts')


    <script>
      // const dropdownUserAvatarButton = document.querySelector('#dropdownUserAvatarButton');
        // const dropdownAvatar = document.querySelector('#dropdownAvatar');
        // dropdownUserAvatarButton.addEventListener('click',function(){

        //     dropdownAvatar.classList.toggle('hidden')
        // })

        const userDropdown = document.querySelector('#user-dropdown');
        const navbarUser = document.querySelector('#navbar-user');

        function showDropdown() {
            userDropdown.classList.toggle('hidden')
        }

        function showList() {
            navbarUser.classList.toggle('hidden')
        }
    </script>
    @endsection