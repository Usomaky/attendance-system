<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Student') }}
        </h2>
    </x-slot>

    <div class="py-2 lg:py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="">
                <h1 class="text-4xl font-bold md:text-4xl">Student</h1>

                <div>
                    <x-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>/
                    <x-link :href="route('manageStudent')" :active="request()->routeIs('manageStudent')">
                        {{ __('Student') }}
                    </x-nav-link>
                </div>

                <div class="flex justify-end my-6">
                    <x-add-button x-data="" class=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Add New Student') }}</x-add-button>

                    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
                        <form method="post" action="{{ route('student.store') }}" class="p-6"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            {{-- @method('delete') --}}

                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Add Student') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Create an account for the student.') }}
                            </p>
                            {{-- Full Name --}}
                            <div class="mt-6">
                                <x-input-label for="name" value="{{ __('Full Name') }}" class="" />

                                <x-text-input id="name" value="{{ old('name') }}" name="name" type="text"
                                    class="block w-3/4 mt-1" placeholder="{{ __('E.g John Doe') }}" />

                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            {{-- Email --}}
                            <div class="mt-6">
                                <x-input-label for="email" value="{{ __('Email Address') }}" class="" />

                                <x-text-input value="{{ old('email') }}" id="email" name="email" type="email"
                                    class="block w-3/4 mt-1" placeholder="{{ __('e.g johndoe@gmail.com') }}" />

                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            {{-- Course --}}
                            <div class="mt-6">
                                <x-input-label for="course" value="{{ __('Course') }}" class="" />

                                <select class="w-3/4 uppercase" name="course" id="course">
                                    @foreach ($courses as $course)
                                        <option class="uppercase" value="{{ $course->id }}">{{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('course')" class="mt-2" />
                            </div>
                            {{-- Password --}}
                            <div class="mt-6">
                                <x-input-label for="password" value="{{ __('Password') }}" class="" />

                                <x-text-input id="password" name="password" type="password" class="block w-3/4 mt-1"
                                    placeholder="{{ __('Password') }}" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="flex justify-end mt-6">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-add-button type="submit"
                                    x-bind:class="submitting ? 'opacity-50 cursor-not-allowed' :
                                        'bg-blue-500 ms-3 hover:bg-blue-500/70 active:bg-blue-700 focus:ring-blue-500'">
                                    {{ __('Create Account') }}
                                </x-add-button>
                            </div>
                        </form>
                    </x-modal>
                </div>
                @if (count($students) < 1)
                    <p class="text-lg text-center text-gray-800">No student found.</p>
                @else
                    <div class="w-full overflow-x-scroll lg:w-auto lg:overscroll-none">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">S/N</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Course of Study</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr class="capitalize">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td class="lowercase">{{ $student->email }}</td>
                                        <td>{{ $student->role }}</td>
                                        <td>{{ $student->course->name }}</td>
                                        <td>
                                            <!-- Example actions (edit, delete, etc.) -->
                                            {{-- <form action="{{ route('student.destroy', $student) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex items-center gap-1 hover:text-red-500">
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

                                                <button class="flex space-x-2 items-center hover:text-red-500"
                                                    x-data=""
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
                                                    <form method="post"
                                                        action="{{ route('student.destroy', $student) }}"
                                                        class="p-6">
                                                        @csrf
                                                        @method('delete')

                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            {{ __('Are you sure you want to delete this student?') }}
                                                        </h2>

                                                        <p class="mt-1 text-sm text-gray-600">
                                                            {{ __('Once this student is deleted, all of their resources and data will be permanently deleted.') }}
                                                        </p>

                                                        <div class="mt-6 flex justify-end">
                                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                                {{ __('Cancel') }}
                                                            </x-secondary-button>

                                                            <x-danger-button class="ms-3">
                                                                {{ __('Delete Student') }}
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
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
