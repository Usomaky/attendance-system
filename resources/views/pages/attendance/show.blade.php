<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Mark Attendance
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Attendance Form -->
                    <form method="POST" action="{{ route('attendance.mark', ['courseId' => $cours->id]) }}" class="mb-3">
                        @csrf
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Student Name
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Present
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Absent
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($students as $student)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $student->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Present" id="present_{{ $student->id }}" required>
                                            <label for="present_{{ $student->id }}" class="ml-2">Present</label>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Absent" id="absent_{{ $student->id }}" required>
                                            <label for="absent_{{ $student->id }}" class="ml-2">Absent</label>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">
                                Submit
                            </button>
                        </div>
                    </form>

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif



                </div>
            </div>
        </div>
    </div>
</x-app-layout>
