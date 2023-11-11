@extends('layouts.app')

@section('content')
<x-owner_aside/>

<div class="p-4 sm:ml-64">
    <div class="p-4 ">
     <!-- Breadcrumb -->
     <nav class="flex px-5 py-3 text-gray-700 border  rounded-lg bg-gray-800 border-gray-700"
     aria-label="Breadcrumb">
     <ol class="inline-flex items-center space-x-1 md:space-x-3">
         <li class="inline-flex items-center">
             <a href="/owner/dashboard"
             class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white">
             <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
             fill="currentColor" viewBox="0 0 20 20">
             <path
             d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
         </svg>
         Dashboard
     </a>
 </li>


</ol>
</nav>

<main class="pt-10">

    <form action="/owner/certificate" method="POST" enctype="multipart/form-data" class="bg-gray-700 px-5 pb-10 rounded" action="">
        @csrf
        <h1 class="pt-2 pb-10 font-bold text-2xl">Upload Certificate</h1>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
            <input class="block w-full text-sm py-2 text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" name="photo" type="file">

        </div>

    <button
data-modal-hide="default-modal"
type="submit"
class="mt-5 text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-green-600 hover:bg-green-700 focus:ring-green-800"
>
Upload
</button>
    </form>
   <h1 class=" mt-10 text-gray-700 font-bold">ALL CERTIFICATE</h1>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2">

        @forelse($certificates as $certificate)

 <div class="relative">
             <button onclick="window.location.href = '/owner/certificate/delete/{{$certificate->id}}'" class=" text-sm absolute top-2 right-2 font-medium mr-2 px-2.5 py-0.5 rounded bg-red-500 text-red-300">remove</button>    
            <img class="h-auto max-w-full rounded-lg" src="{{asset($certificate->photo)}}" loading="lazy" alt="">
        </div>
        @empty

        @endforelse

    </div>


</main>
</div>
</div>
@endsection
@section('scripts')
<script>
    const d = document.querySelector('#logo-sidebar');
    const navBtn = document.querySelector('#navBtn');

    navBtn.addEventListener('click', function (){
        console.log(d.classList.toggle('-translate-x-full'))
    })
</script>
@endsection
