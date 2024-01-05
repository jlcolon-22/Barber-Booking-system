@extends('layouts.app')

@section('content')
    <x-frontend_header/>
    <main
        class="bg-[url('/assets/bg3.jpeg')] bg-cover bg-center pb-[5rem] pt-[3rem] min-h-[100svh] origin-bottom items-center z-50 px-3 ">

        <div class="grid grid-cols-1 lg:w-2/5 px-10  mx-auto py-10 bg-black bg-opacity-90">
            <h1 class="pb-10 font-bold">Chats</h1>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg space-y-2">
                @forelse($branches as $branch)

                   @if ($branch->ownerInfo)
                   <a href="/message/convo/{{$branch->id}}"
                    class="bg-gray-600 flex items-center justify-between px-3 py-2 rounded">
                     <div class="flex items-center gap-x-2">
                         <img src="{{asset('assets/about.png')}}"
                              class="w-[2.5rem] h-[2.5rem] rounded-full border border-blue-500"
                              alt="">
                         <h2>
                             {{$branch->ownerInfo?->branch[0]?->name}}</h2>
                     </div>
                     {{--                        <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>--}}
                 </a>
                   @endif
                @empty
                    <h1 class="text-gray-400">No Chat Found!</h1>
                @endforelse
            </div>

        </div>

    </main>
    <!-- Main modal -->
    <div id="Imagemodal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0  right-0 z-50 hidden justify-center pt-10 w-full px-4 pb-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t ">
                    <h3 class="text-xl font-semibold text-gray-900 ">
                        Feedback
                    </h3>
                    <button onclick="closeModal()" type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center "
                            data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form class="space-y-6" action="/feedback" method="POST">
                        @if (session()->has('error'))
                            <div class="flex items-center p-4 mb-4 text-sm  rounded-lg  bg-gray-800 text-red-400"
                                 role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium">The email you provided is not registered.</span>
                                </div>
                            </div>
                        @endif

                        @csrf
                        <input type="hidden" name="id" id="res_id">
                        <div class="relative z-0 w-full mb-6 group">

                            <textarea name="message" required
                                      class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 ppearance-none text-gray-700 border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"></textarea>
                            <label for="floating_first_name"
                                   class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Message</label>
                        </div>


                        <div>
                            <button type="submit"
                                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Send
                                Feedback
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
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

        const image = document.querySelector('#Imagemodal');
        const res_id = document.querySelector('#res_id');

        function show(e) {

            res_id.value = e.dataset.x;
            // viewImage.src =  e.children[0].src;
            image.classList.add('flex')
            image.classList.remove('hidden')
        }

        function closeModal() {
            image.classList.add('hidden')
            image.classList.remove('flex')

        }
    </script>
@endsection
