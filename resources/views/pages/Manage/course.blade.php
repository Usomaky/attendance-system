<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="">
                <h1 class="text-2xl font-bold md:text-4xl">Courses</h1>

                <div>
                    <x-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>/
                    <x-link :href="route('manageCourse')" :active="request()->routeIs('manageCourse')">
                        {{ __('Course') }}
                    </x-nav-link>
                </div>

                <div class="flex justify-end my-6">
                    <x-add-button x-data="" class=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Add New Course') }}</x-add-button>

                    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
                        <form method="post" action="{{ route('course.store') }}" class="p-6" x-data="{ submitting: false }"
                            x-on:submit="submitting = true">
                            @csrf
                            {{-- @method('delete') --}}

                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Add Course') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Add courses for students to learn and for facilitators to teact.') }}
                            </p>
                            {{-- Full Name --}}
                            <div class="mt-6">
                                <x-input-label for="name" value="{{ __('Course Title') }}" class="" />

                                <x-text-input id="name" value="{{ old('name') }}" name="name" type="text"
                                    class="block w-3/4 mt-1 uppercase" placeholder="{{ __('Title') }}" />

                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="flex justify-end mt-6">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-add-button type="submit"
                                    x-bind:class="submitting ? 'opacity-50 cursor-not-allowed' :
                                        'bg-blue-500 ms-3 hover:bg-blue-500/70 active:bg-blue-700 focus:ring-blue-500'">
                                    {{ __('Add Course') }}
                                </x-add-button>
                            </div>
                        </form>
                    </x-modal>
                </div>
                @if (count($courses) < 1)
                    <p class="text-lg text-center text-gray-800">Courses are not available yet.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">S/N</th>
                                <th scope="col">Course Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr class="capitalize">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="uppercase">{{ $course->name }}</td>
                                    <td class="uppercase">{{ $course->status }}</td>
                                    <td>
                                        <!-- Example actions (edit, delete, etc.) -->
                                        {{-- <form action="{{ route('course.destroy', $course) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center gap-1 hover:text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class=" size-6 hover:text-red-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                                <span>Delete</span>
                                            </button>
                                        </form> --}}
                                        <div>

                                            <button class="flex space-x-2 items-center hover:text-red-500" x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion')">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class=" size-6 hover:text-red-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                                <span>{{ __('Delete') }}</span>

                                            </button>
                                            <x-modal name="confirm-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                                <form method="post" action="{{ route('course.destroy', $course) }}"
                                                    class="p-6">
                                                    @csrf
                                                    @method('delete')

                                                    <h2 class="text-lg font-medium text-gray-900">
                                                        {{ __('Are you sure you want to delete this course?') }}
                                                    </h2>

                                                    <p class="mt-1 text-sm text-gray-600">
                                                        {{ __('Once this course is deleted, all of its resources and data will be permanently deleted.') }}
                                                    </p>

                                                    <div class="mt-6 flex justify-end">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            {{ __('Cancel') }}
                                                        </x-secondary-button>

                                                        <x-danger-button class="ms-3">
                                                            {{ __('Delete Course') }}
                                                        </x-danger-button>
                                                    </div>
                                                </form>
                                            </x-modal>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
