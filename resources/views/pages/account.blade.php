@extends('layouts.app')

@section('content')
<x-frontend_header/>
<main class="bg-[url('/assets/bg3.jpeg')] bg-cover bg-center pb-[5rem] pt-[3rem] min-h-[100svh] origin-bottom items-center z-50 px-3 ">

    <form action="/account/{{Auth::id()}}" method="post" enctype="multipart/form-data" class="grid grid-cols-1 lg:w-3/5 px-10  mx-auto py-10 bg-black bg-opacity-90">
        <h1 class="pb-10 font-bold">User Information</h1>
       @if(session()->has('success'))
        <div class="p-4 mb-10 text-sm rounded-lg  bg-gray-800 text-green-400" role="alert">
          <span class="font-medium">Updated Successfully!</span> 
        </div>
       @endif

        @csrf
       <div >
          <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
              <input
              type="text"
              name="firstname"
              id="floating_first_name"
              class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
              placeholder=" "
              required
              value="{{Auth::user()->firstname}}"
              />
              <label
              for="floating_first_name"
              class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
              >First name</label
              >
          </div>
          <div class="relative z-0 w-full mb-6 group">
              <input
              type="text"
              name="lastname"
              id="lastname"
              class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
              placeholder=" "
              required
              value="{{Auth::user()->lastname}}"
              />
              <label
              for="lastname"
              class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
              >Last name</label
              >
          </div>
      </div>
      <div class="relative z-0 w-full mb-6 group">
        <input
        type="email"
        name="email"
        id="floating_email"
        class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
        placeholder=" "
        required
        value="{{Auth::user()->email}}"
        />
        <label
        for="floating_email"
        class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
        >Email address</label
        >
    </div>
    <div class="relative z-0 w-full mb-6 group">
        <input
        type="password"
        name="password"
        id="password"
        autocomplete="on"
        class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
        placeholder=" "
        

        />
        <label
        for="password"
        class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
        >Password</label
        >
       @error('password')
        <small class="text-red-500">{{$message}}</small>
       @enderror
    </div>
    <div class="relative z-0 w-full mb-6 group">
        <input
        type="file"
        name="profile"
     
        class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
        placeholder=" "
        

        />
        <label
        for="profile"
        class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
        >Profile</label
        >
    </div>
</div>
<button
data-modal-hide="default-modal"
type="submit"
class="text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-green-600 hover:bg-green-700 focus:ring-green-800"
>
Update
</button>
</form>

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