    @extends('layouts.app')



    @section('content')
    <x-frontend_header/>


    <main class="bg-[url('/assets/bg3.jpeg')] bg-cover bg-center   origin-bottom items-center z-50  ">
     
        {{-- <section class="grid grid-cols-3 px-10 py-10"> --}}
            
        {{--   @forelse($branches as $branch)
          <div class="w-full h-fit max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class=" min-h-[16rem] max-h-[16rem] overflow-hidden relative">
               <a href="/view?branch={{$branch->name}}&q={{$branch->id}}" >
                <img class=" h-full rounded-t-lg object-cover origin-top-left  w-full" src="{{ asset($branch->photo)}}" alt="product image" loading="lazy" />
            </a>
        </div>
        <div class="px-5 pb-5 pt-2">
        	<h2 class="text-gray-500">{{ '@'.$branch->location}}</h2>
            <a href="/view?branch={{$branch->name}}&q={{$branch->id}}">
                <h5 class="text-lg font-semibold tracking-tight text-gray-900 dark:text-white">{{$branch->name}}</h5>
            </a>

            <div class="flex items-center justify-end">
        
                <a href="/view?branch={{$branch->name}}&q={{$branch->id}}" class="text-blue-600">View</a>
            </div>
        </div>
    </div>
    @empty


    @endforelse --}}

    {{-- </section> --}}
       <section  class=" px-10 py-10  min-h-[100svh]  bg-black bg-opacity-80">
        <h1 class="text-center font-bold  pb-10">Choose Location</h1>
            <map_branch locations="{{ $branches }}"></map_branch>
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