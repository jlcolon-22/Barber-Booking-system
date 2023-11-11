@extends('layouts.app')



@section('content')
    <x-frontend_header />


    <main class="bg-[url('/assets/bg3.jpeg')]  bg-cover bg-center  min-h-[100svh] origin-bottom items-center z-50 ">

        <section class=" px-10 py-10">


            <div class="max-w-4xl flex items-center h-auto lg:h-screen flex-wrap mx-auto my-32 lg:my-0">

                <!--Main Col-->
                <div id="profile"
                    class="w-full lg:w-3/5 rounded-lg lg:rounded-l-lg lg:rounded-r-none shadow-2xl bg-black opacity-90 mx-6 lg:mx-0">


                    <div class="p-4 md:p-12 text-center lg:text-left">
                        <!-- Image for mobile view-->
                        <div class="block lg:hidden rounded-full shadow-xl mx-auto -mt-16 h-48 w-48 bg-cover bg-center"
                            style="background-image: url({{ asset($branch->photo) }})"></div>

                        <h1 class="text-3xl font-bold pt-8 lg:pt-0">{{ $branch->name }}</h1>
                        <div class="mx-auto lg:mx-0 w-4/5 pt-3 border-b-2 border-green-500 opacity-25"></div>
                        <p class="pt-4 text-base font-bold flex items-center justify-center lg:justify-start">
                            <svg class="h-4 fill-current text-green-700 pr-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M9 12H1v6a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-6h-8v2H9v-2zm0-1H0V5c0-1.1.9-2 2-2h4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1h4a2 2 0 0 1 2 2v6h-9V9H9v2zm3-8V2H8v1h4z" />
                            </svg> {{ $owner->firstname . ' ' . $owner->lastname . ' ' }} <span class="text-gray-400 font-light">
                                (owner)</span>
                        </p>
                        <p class="pt-2 text-gray-600 text-xs lg:text-sm flex items-center justify-center lg:justify-start">
                            <svg class="h-4 fill-current text-green-700 pr-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm7.75-8a8.01 8.01 0 0 0 0-4h-3.82a28.81 28.81 0 0 1 0 4h3.82zm-.82 2h-3.22a14.44 14.44 0 0 1-.95 3.51A8.03 8.03 0 0 0 16.93 14zm-8.85-2h3.84a24.61 24.61 0 0 0 0-4H8.08a24.61 24.61 0 0 0 0 4zm.25 2c.41 2.4 1.13 4 1.67 4s1.26-1.6 1.67-4H8.33zm-6.08-2h3.82a28.81 28.81 0 0 1 0-4H2.25a8.01 8.01 0 0 0 0 4zm.82 2a8.03 8.03 0 0 0 4.17 3.51c-.42-.96-.74-2.16-.95-3.51H3.07zm13.86-8a8.03 8.03 0 0 0-4.17-3.51c.42.96.74 2.16.95 3.51h3.22zm-8.6 0h3.34c-.41-2.4-1.13-4-1.67-4S8.74 3.6 8.33 6zM3.07 6h3.22c.2-1.35.53-2.55.95-3.51A8.03 8.03 0 0 0 3.07 6z" />
                            </svg> {{ $branch->location }}
                        </p>
                        <p class="pt-2 text-gray-600 text-xs lg:text-sm flex items-center justify-center lg:justify-start">
                            <svg class="h-4 fill-current text-green-700 pr-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm7.75-8a8.01 8.01 0 0 0 0-4h-3.82a28.81 28.81 0 0 1 0 4h3.82zm-.82 2h-3.22a14.44 14.44 0 0 1-.95 3.51A8.03 8.03 0 0 0 16.93 14zm-8.85-2h3.84a24.61 24.61 0 0 0 0-4H8.08a24.61 24.61 0 0 0 0 4zm.25 2c.41 2.4 1.13 4 1.67 4s1.26-1.6 1.67-4H8.33zm-6.08-2h3.82a28.81 28.81 0 0 1 0-4H2.25a8.01 8.01 0 0 0 0 4zm.82 2a8.03 8.03 0 0 0 4.17 3.51c-.42-.96-.74-2.16-.95-3.51H3.07zm13.86-8a8.03 8.03 0 0 0-4.17-3.51c.42.96.74 2.16.95 3.51h3.22zm-8.6 0h3.34c-.41-2.4-1.13-4-1.67-4S8.74 3.6 8.33 6zM3.07 6h3.22c.2-1.35.53-2.55.95-3.51A8.03 8.03 0 0 0 3.07 6z" />
                            </svg> {{ $branch->email }}
                        </p>
                        <p class="pt-2 text-gray-600 text-xs lg:text-sm flex items-center justify-center lg:justify-start">
                            <svg class="h-4 fill-current text-green-700 pr-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm7.75-8a8.01 8.01 0 0 0 0-4h-3.82a28.81 28.81 0 0 1 0 4h3.82zm-.82 2h-3.22a14.44 14.44 0 0 1-.95 3.51A8.03 8.03 0 0 0 16.93 14zm-8.85-2h3.84a24.61 24.61 0 0 0 0-4H8.08a24.61 24.61 0 0 0 0 4zm.25 2c.41 2.4 1.13 4 1.67 4s1.26-1.6 1.67-4H8.33zm-6.08-2h3.82a28.81 28.81 0 0 1 0-4H2.25a8.01 8.01 0 0 0 0 4zm.82 2a8.03 8.03 0 0 0 4.17 3.51c-.42-.96-.74-2.16-.95-3.51H3.07zm13.86-8a8.03 8.03 0 0 0-4.17-3.51c.42.96.74 2.16.95 3.51h3.22zm-8.6 0h3.34c-.41-2.4-1.13-4-1.67-4S8.74 3.6 8.33 6zM3.07 6h3.22c.2-1.35.53-2.55.95-3.51A8.03 8.03 0 0 0 3.07 6z" />
                            </svg> {{ $branch->number }}
                        </p>








                        <a onclick="closeFeedback()" class="text-yellow-400 underline mt-2">view feedback</a>

                    </div>

                </div>

                <!--Img Col-->


                <div class="w-full lg:w-2/5">
                    <!-- Big profile image for side bar (desktop) -->
                    <img src="{{ asset($branch->photo) }}"
                        class="rounded-none hover:backdrop-brightness-200 cursor-pointer min-h-[30rem] bg-red-500 object-cover lg:rounded-lg shadow-2xl hidden lg:block">
                    <!-- Image from: http://unsplash.com/photos/MP0IUfwrn0A -->

                </div>


            </div>

            <div class="px-10 py-10 bg-black bg-opacity-90">
                <h1 class="">Certificates</h1>
                <div class="flex gap-4 overflow-x-auto max-w-full py-2">
                    @forelse($owner->certificates as $certificate)

                        <div class="min-h-[10rem] max-h-[10rem] cursor-pointer hover:opacity-80 transition-all ease-in-out duration-400" onclick="show(this)">
                            <img class="min-h-[10rem] max-h-[10rem]  max-w-full min-w-[10rem] object-cover origin-top rounded-lg"
                                src="{{ $certificate->photo }}" loading="lazy" alt="">
                        </div>


                    @empty
                    @endforelse

                </div>
            </div>


            <div class="px-10 py-10 mt-10 bg-black bg-opacity-90">
                <h1 class="underline font-bold">Branch Offers</h1>
                <section class="flex flex-wrap justify-center mt-6 gap-5">

                    @forelse($owner->posts as $post)
                        <div
                            class=" h-fit max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <div class=" min-h-[16rem] max-h-[16rem] overflow-hidden relative">
                                <a type="button">
                                    <img class=" h-full rounded-t-lg object-cover origin-top-left  w-full"
                                        src="{{ asset($post->photo) }}" alt="product image" loading="lazy" />
                                </a>
                            </div>
                            <div class="px-5 pb-5 pt-2">
                                <h2 class="text-blue-500">{{ '#' . $post->category }}</h2>
                                <a type="button">
                                    <h5 class="text-lg font-semibold tracking-tight text-gray-900 dark:text-white">
                                        {{ $post->name }}</h5>
                                </a>

                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-3xl font-bold text-gray-900 dark:text-white">₱{{ $post->price }}</span>
                                    {{--  --}}
                                    <a href="/reservation?name={{ $post->name }}&q={{ $post->id }}"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Book</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h1 class="text-red-500">- No Offer</h1>
                    @endforelse

                </section>
            </div>

        </section>

    </main>



  <!-- Main modal -->
  <div id="Imagemodal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0  right-0 z-50 hidden justify-center pt-10 w-full px-4 pb-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Certificate
                  </h3>
                  <button onclick="closeModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Close modal</span>
                  </button>
              </div>
              <!-- Modal body -->
              <div class="p-6 space-y-6">
                 <img id="viewImage" src="{{ asset('assets/bg1.jpg') }}" loading="laxy" alt="">
              </div>

          </div>
      </div>
  </div>

  <div id="feedbackModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0  right-0 z-50 hidden flex justify-center pt-10 w-full px-4 pb-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Feedbacks
                  </h3>
                  <button onclick="closeFeedback()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Close modal</span>
                  </button>
              </div>
              <!-- Modal body -->
              <div class="p-6 space-y-6 max-h-[30rem] overflow-y-auto">
                    
                    @forelse($branch->feedbacks as $feedback)
                    <article class="border-b border-gray-500">
                        <div class="flex items-center mb-4 space-x-4" >
                            <img class="w-10 h-10 rounded-full" src="{{asset($feedback->userInfo->profile)}}" alt="">
                            <div class="space-y-1 font-medium dark:text-white">
                                <p>{{ $feedback->userInfo->firstname.' '.$feedback->userInfo->lastname}}</p>
                            </div>
                        </div>
                      
                        <footer class="mb-5 text-sm text-gray-500 dark:text-gray-400"><p>Date: <time datetime="{{$feedback->created_at}}">{{\Carbon\Carbon::parse($feedback->created_at)->toDateString()}}</time></p></footer>
                        <p class="mb-2 text-gray-500 dark:text-gray-400">{{$feedback->message}}</p>
                      
                      
                       
                    </article>
                    @empty


                    @endforelse

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
        const viewImage = document.querySelector('#viewImage');
       function show(e){

        viewImage.src =  e.children[0].src;
        image.classList.add('flex')
            image.classList.remove('hidden')
        }
        function closeModal(){
            image.classList.add('hidden')
            image.classList.remove('flex')

        }
        const feedback = document.querySelector('#feedbackModal');
          function closeFeedback(){
            feedback.classList.toggle('hidden')
 

        }
    </script>
@endsection
