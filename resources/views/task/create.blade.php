<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Task
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                               Crete Task
                            </h2>

                        </header>

{{--                        @if(isset($errors))--}}
{{--                            @dd($errors)--}}

{{--                        @endif--}}

                        <form method="post" action="{{ route('tasks.store') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('post')

                            <div>
                                <x-input-label for="title" :value="__('task.title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" autocomplete="title" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('task.description')" />
                                <x-text-area id="description" name="description" type="text" class="mt-1 block w-full" autocomplete="description" />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="assigned_to" :value="__('task.assigned_to')" />
                                <select id="assigned_to"  name="assigned_to_id"  class="mt-1 block w-full select2" autocomplete="assigned to" >
                                    <option value="">Select a user</option>
                                    @foreach($users as $id => $name)
                                        <option value="{{$id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('assigned_to_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="assigned_by" :value="__('task.assigned_by')" />
                                <select id="assigned_by"  name="assigned_by_id"  class="mt-1 block w-full select2" autocomplete="assigned by" >
                                    <option value="">Select a admin</option>
                                    @foreach($admins as $id => $name)
                                        <option value="{{$id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('assigned_by_id')" class="mt-2" />
                            </div>


                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'description-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>

                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            function initializeAdminSelect2(selector) {
                $('#assigned_by').select2({
                    placeholder: 'Select an option',
                    ajax: {
                        url: '/search',  // Your search route
                        dataType: 'json',
                        data: function (params) {
                            console.log(params)
                            return {
                                name: params.term,
                                role: 'admin'
                            };
                        },
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        id: item.id,
                                        text: item.name  // Adjust based on your data structure
                                    };
                                })
                            };
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    }
                });
                $(selector).on('select2:open', function() {
                    let select2SearchField = $('.select2-container--open .select2-search__field');
                    select2SearchField.focus();
                });
            }

            function initializeUserSelect2(selector) {
                $('#assigned_to').select2({
                    placeholder: 'Select an option',
                    ajax: {
                        url: '/search',  // Your search route
                        dataType: 'json',
                        data: function (params) {
                            console.log(params)
                            return {
                                name: params.term,
                                role: 'user'
                            };
                        },
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        id: item.id,
                                        text: item.name  // Adjust based on your data structure
                                    };
                                })
                            };
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    }
                });
                $(selector).on('select2:open', function() {
                    let select2SearchField = $('.select2-container--open .select2-search__field');
                    select2SearchField.focus();
                });
            }
            // // Initialize Select2 for both select inputs
            initializeUserSelect2('#assigned_to');
            initializeAdminSelect2('#assigned_by');
        });
    </script>
</x-app-layout>
