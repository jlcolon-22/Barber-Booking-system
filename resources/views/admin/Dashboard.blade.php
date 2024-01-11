@extends('layouts/admin')


@section('content')
    <x-admin_aside />

    <div class="p-4 sm:ml-64">
        <div class="p-4 ">
           <!-- Breadcrumb -->
           <nav class="flex px-5 py-3  text-gray-700 border  rounded-lg bg-gray-800 border-gray-700"
           aria-label="Breadcrumb">
           <ol class="inline-flex items-center space-x-1 md:space-x-3">
               <li class="inline-flex items-center">
                   <a href="/admin/dashboard"
                       class="inline-flex items-center text-base font-medium text-gray-400 hover:text-white">
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



       <main class="mt-10">
                <form action="" method="get" class="py-1">
                    <select onchange="this.form.submit()" name="branch" id="" class="px-4 w-fit py-1 bg-gray-200 rounded " >
                        <option value="all" {{ app('request')->input('branch') == 'all' ? 'selected' : ''}}>All</option>

                        @foreach ($branches as $branch)
                        <option value="{{ $branch->name }}" {{ app('request')->input('branch') == $branch->name ? 'selected' : ''}}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </form>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-base text-left  text-gray-400">
                        <thead class="text-xs  uppercase  bg-gray-700 text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                   Hairstyle name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Photo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Barber
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Branch
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr class=" border-b bg-gray-900 border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
                                        {{ $post->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <img src="{{ $post->photo }}" class="h-[4rem] w-[4rem]" loading="lazy"
                                            alt="">
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $post->employeeInfo?->firstname .' '. $post->employeeInfo?->lastname  }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $post->branch?->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        ₱{{ $post->price }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $post->category  }}
                                    </td>


                                </tr>
                            @empty
                            <h1 class="text-red-500 font-bold">NO RESULT!</h1>
                            @endforelse


                        </tbody>
                    </table>
                    <div class="py-5 px-1">
                        {{-- {{ $employees->links('pagination::tailwind') }} --}}
                    </div>
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
    google.maps.event.addListener(marker, "click", function() {
   window[data.funkcija]();
});
</script>
@endsection

