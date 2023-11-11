@extends('layouts/admin')


@section('content')
    <x-admin_aside />

    <div class="p-4 sm:ml-64">
        <div class="p-4 ">
            <!-- Breadcrumb -->
            <nav class="flex px-5 py-3 text-gray-700 border  rounded-lg bg-gray-800 border-gray-700" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/admin/dashboard"
                            class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white">
                            <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ml-1 text-sm font-medium  md:ml-2 text-gray-100">Branch</span>
                        </div>
                    </li>

                </ol>
            </nav>

            <main class="pt-10">
                <Branch owners="{{ $owners }}"></Branch>


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left  text-gray-400">
                        <thead class="text-xs  uppercase  bg-gray-700 text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Branch Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Branch Photo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Owner
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Branch Location
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Branch Number
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
                            @forelse ($branches as $branch)
                                <tr class=" border-b bg-gray-900 border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
                                        {{ $branch->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <img src="{{ $branch->photo }}" class="h-[4rem] w-[4rem]" loading="lazy"
                                            alt="">
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $branch->ownerInfo->firstname .' '.$branch->ownerInfo->lastname }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $branch->location }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $branch->number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($branch->status)
                                            <h1>active</h1>
                                        @else
                                            <h1>inactive</h1>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <branch_edit owners="{{ $owners }}" data="{{ $branch }}">

                                        </branch_edit owners="{{ $owners }}">

                                    </td>
                                </tr>
                            @empty
                            @endforelse


                        </tbody>
                    </table>
                    <div class="py-5 px-1">
                        {{ $branches->links('pagination::tailwind') }}
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

        navBtn.addEventListener('click', function() {
            console.log(d.classList.toggle('-translate-x-full'))
        })
    </script>
@endsection
