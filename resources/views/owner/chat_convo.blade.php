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
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>


                </ol>
            </nav>

            <main class="pt-10">
                <div class="grid grid-cols-1 px-5 md:px-10  mx-auto py-10 bg-gray-900  ">
                    <div class="flex justify-between items-center pb-10 ">
                        <h1 class="font-bold">Chats</h1>
                        <a href="/owner/message" class="px-4 py-2 bg-blue-500 text-sm rounded">Back</a>
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg space-y-2">
                        <a href="/owner/message"
                           class="bg-gray-600 flex items-center justify-between px-3 py-2 rounded">
                            <div class="flex items-center gap-x-2">
                                <img src="{{asset('assets/about.png')}}"
                                     class="w-[2.5rem] h-[2.5rem] rounded-full border border-blue-500"
                                     alt="">
                                <h2>
                                    {{$branch->customerInfo?->firstname}}</h2>
                            </div>
                            {{--                    <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>--}}
                        </a>
                        {{--                        <Chat convo_id="{{$branch->id}}"></Chat>--}}
                        <chat_owner convo_id="{{$branch->id}}" user_id="{{Auth::id()}}"></chat_owner>
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

        navBtn.addEventListener('click', function () {
            console.log(d.classList.toggle('-translate-x-full'))
        })
    </script>

@endsection
