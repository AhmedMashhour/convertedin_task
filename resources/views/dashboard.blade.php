<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="container mx-auto p-4">

                    <h1 class="text-2xl font-bold mb-4">Tasks</h1>
                    <div class="flex items-center justify-between">
                    <table class="min-w-full bg-white border-collapse">
                        <thead>
                        <tr>
                            <th class="py-2 px-4 border">ID</th>
                            <th class="py-2 px-4 border">Title</th>
                            <th class="py-2 px-4 border">Description</th>
                            <th class="py-2 px-4 border">Assigned By</th>
                            <th class="py-2 px-4 border">Assigned TO</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td class="py-2 px-4 border">{{ $task->id }}</td>
                                <td class="py-2 px-4 border">{{ $task->title }}</td>
                                <td class="py-2 px-4 border">{{ $task->description }}</td>
                                <td class="py-2 px-4 border">{{ $task->assigned_to->name }}</td>
                                <td class="py-2 px-4 border">{{ $task->assigned_to->name }}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="mt-4">
                        {{ $tasks->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
