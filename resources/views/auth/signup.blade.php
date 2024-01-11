@extends('layouts.app')



@section('content')
    <x-frontend_header />
    <main class="bg-[url('/assets/bg1.jpg')] bg-cover  bg-center min-h-[100svh] items-center z-50 py-[5rem] flex justify-center">
        <div
            class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 bg-dark h-fit  mt-[4rem] rounded ">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">

                <h2 class="mt-3 text-center text-2xl font-bold leading-9 tracking-tight text-gray-50">Create your Account
                </h2>
            </div>

            <div class="mt-10  sm:mx-auto sm:w-full sm:max-w-sm">
                <form action="/auth/signup" method="post" class="space-y-6" action="#" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-base font-medium leading-6 text-gray-50">Firstname</label>
                        <div class="mt-2">
                            <input id="firstname" name="firstname" type="text" autocomplete="firstname" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 px-2 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-base sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="lastname" class="block text-base font-medium leading-6 text-gray-50">Lastname</label>
                        <div class="mt-2">
                            <input id="lastname" name="lastname" type="text" autocomplete="lastname" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 px-2 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-base sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-base font-medium leading-6 text-gray-50">Email address</label>
                        <div class="mt-2">
                            <input type="text" id="email" name="email"  pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Invalid email address"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 px-2 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-base sm:leading-6">
                        </div>
                        @error('email')

                        <small class="text-red-400">{{$message}}</small>

                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-base font-medium leading-6 text-gray-50">Password</label>

                        </div>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-base sm:leading-6 px-2">
                        </div>
                          @error('password')

                        <small class="text-red-400">{{$message}}</small>

                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-base font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign
                            in</button>
                    </div>
                </form>
                <div class="flex  items-center gap-x-7 my-7 ">
                    <hr class="opacity-50 w-[10rem]" />
                     <span class="text-base opacity-50 text-center w-fit">or</span>
                    <hr  class="opacity-50  w-[10rem]" >
                </div>
                <div class=" grid gap-y-2">
                    <a href="/auth/google"
                    class="flex w-full justify-center rounded-md bg-red-600 px-3 py-1.5 text-base font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600  items-center gap-x-2">
                    <img src="/icons/google.svg" loading="lazy" class="w-[1rem]" alt="">
                    Sign Up with Google
                </a>

                </div>
                <p class="mt-10 text-center text-base text-gray-500">
                    Already have an account?
                    <a href="/auth/login" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Sign In</a>
                </p>
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
