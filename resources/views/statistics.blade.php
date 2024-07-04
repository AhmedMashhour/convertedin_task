<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistics') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="container mx-auto p-4">

                    <h1 class="text-2xl font-bold mb-4">Statistics</h1>
                    <table class="min-w-full bg-white border-collapse">
                        <thead>
                        <tr>
                            <th class="py-2 px-4 border">ID</th>
                            <th class="py-2 px-4 border">User</th>
                            <th class="py-2 px-4 border">Total Tasks</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($statistics as $statistic)
                            <tr>
                                <td class="py-2 px-4 border">{{ $statistic->id }}</td>
                                <td class="py-2 px-4 border">{{ $statistic->user->name }}</td>
                                <td class="py-2 px-4 border">{{ $statistic->total_tasks }}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
