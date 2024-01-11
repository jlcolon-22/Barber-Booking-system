@extends('layouts.app')

@section('content')
<x-emplooyee/>

 <div class="p-4 sm:ml-64">
        <div class="p-4  rounded-lg ">

            <!-- Breadcrumb -->
            <nav class="flex px-5 py-3 text-gray-700 border  rounded-lg bg-gray-800 border-gray-700" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/owner/dashboard"
                            class="inline-flex items-center text-base font-medium text-gray-400 hover:text-white">
                            <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Appointment
                        </a>
                    </li>


                </ol>
            </nav>

            <main class="pt-10">
               @if(session()->has('success') )
                <div class="flex items-center p-4 mb-4 text-base  rounded-lg bg-gray-800 text-green-400" role="alert">
  <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
  </svg>
  <span class="sr-only">Info</span>
  <div>
    <span class="font-medium">Your status change was successful!</span>
  </div>
</div>



              @endif

     <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-base text-left  text-gray-400">
                        <thead class="text-xs  uppercase  bg-gray-700 text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                     Photo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date
                                </th><th scope="col" class="px-6 py-3">
                                    Time
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Branch Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Branch Location
                                </th>
                                <th scope="col" class="px-6 py-3">
                                   Status
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($appointments as $appointment)
                             <tr class=" border-b bg-gray-900 border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">

                                       {{$appointment->postInfo->name}}
                                    </th>
                                    <td class="px-6 py-4">
                                        <img src="{{ asset($appointment->postInfo->photo) }}" class="h-[4rem] w-[4rem]" loading="lazy"
                                            alt="">
                                    </td>
                                    <td class="px-6 py-4">
                                       {{$appointment->postInfo->category}}
                                    </td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                       {{\Carbon\Carbon::parse($appointment->date)->format('d-m-Y')}}
                                    </td>
                                       <td class="px-6 py-4">
                                       {{$appointment->time}}
                                    </td>
                                    <td class="px-6 py-4">
                                       {{ $appointment->branchInfo?->name}}
                                    </td>
                                    <td class="px-6 py-4">
                                       {{$appointment->branchInfo?->location}}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($appointment->status == 1)
                                            <span class=" text-xs font-medium mr-2 px-2.5 py-0.5 rounded bg-green-900 text-green-300">Approved</span>
                                        @elseif ($appointment->status == 0)
                                            <span class=" text-xs font-medium mr-2 px-2.5 py-0.5 rounded bg-yellow-900 text-yellow-300">Pending</span>
                                         @elseif ($appointment->status == 3)
                                            <span class=" text-xs font-medium mr-2 px-2.5 py-0.5 rounded bg-violet-900 text-violet-300">Finish</span>
                                        @else
                                            <span class=" text-xs font-medium mr-2 px-2.5 py-0.5 rounded bg-red-900 text-red-300">Cancelled</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4  ">
                                       @if($appointment->status != 3)
                                         <a href="/employee/appointment/{{$appointment->id}}/done" class="px-3 py-2 text-xs font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">done</a>

                                       @endif


                                    </td>
                                </tr>
                            @empty

                                <h1 class="text-red-500 font-bold text-2xl">No result!</h1>
                            @endforelse





                        </tbody>
                    </table>
                    <div class="py-5 px-1">
                       {{ $appointments->links('pagination::tailwind') }}
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
</script>
@endsection
