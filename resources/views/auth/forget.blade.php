@extends('layouts.app')



@section('content')
    <x-frontend_header />
    <main class="bg-[url('/assets/bg3.jpeg')] bg-cover bg-center py-10 min-h-[100svh] origin-bottom items-center z-50 flex justify-center">
        <div
            class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 bg-dark h-fit min-w-[30rem]  max-w-[30rem] mt-[4rem] rounded ">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">

                <h2 class="mt-3 text-center text-2xl font-bold leading-9 tracking-tight text-gray-50">Enter your email, and we'll send you instructions on how to reset your password.
                </h2>
            </div>

            <div class="mt-10  sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="/auth/forget" method="POST">
                   @if (session()->has('error'))
                   <div class="flex items-center p-4 mb-4 text-sm  rounded-lg  bg-gray-800 text-red-400" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                      <span class="font-medium">The email you provided is not registered.</span>
                    </div>
                  </div>
                   @endif
                 
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-50">Email address</label>
                        <div class="mt-2">
                            <input id="email"  name="email" type="email" autocomplete="email" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 px-2 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                  

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Send
                            </button>
                    </div>
                </form>
              
              
           
            </div>
        </div>
    </main>
@endsection

