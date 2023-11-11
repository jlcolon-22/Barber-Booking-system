@extends('layouts.app')


@section('content')
    {{-- header --}}
 <x-frontend_header/>





















    {{--  hero --}}
    <main class="bg-[url('/assets/bg3.jpeg')]  bg-cover bg-center min-h-[100svh] origin-bottom items-center z-50 ">

        <section class="text-gray-600 body-font bg-black bg-opacity-50">
            <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
                <div
                    class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
                    <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-50 ">Improve your Selfie
                        <br class="hidden lg:inline-block">Go and See Your Barber
                    </h1>
                    <p class="mb-8 leading-relaxed text-gray-100"> This online barbershop reservation is for Angeles City to
                        facilitate their haircut and not have to wait for a long time at the actual barbershop. This website
                        was created so that they don't run out of time waiting at the barbershop.</p>
                    <div class="flex justify-center">
                        <a href="/services"
                            class="inline-flex text-white bg-orange-500 border-0 py-2 px-6 focus:outline-none hover:bg-orange-600 rounded text-lg">Book
                            Now</a>

                    </div>
                </div>
                <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                    <img class="object-cover object-center rounded" alt="hero" src="{{ asset('assets/about.png') }}">
                </div>
            </div>
        </section>
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
