@php
    $title = $title ?? '';
    $form = $formConfig ?? [];
@endphp
<x-app title="{{ $title }}">
    <x-ui.admin-sidebar title="{{ $title }}">
        <div class="bg-base-300 p-8 rounded-xl flex flex-col">
            <form action="{{ route($routeSubmit) }}" method="POST" class="flex flex-col flex-1 gap-4">
                @if ($form)
                    <fieldset class="fieldset w-full rounded-xl gap-4">
                        @csrf
                        @foreach ($form as $col)
                            @if ($col['type'] === 'number' || $col['type'] === 'text' || $col['type'] === 'email' || $col['type'] === 'password')
                                <div class="flex flex-col  gap-2">
                                    <input type="{{ $col['type'] }}" name="{{ $col['name'] }}"
                                        class="input input-sm input-neutral w-full"
                                        placeholder="{{ GeneralHelper::UpperCase($col['label']) }}"
                                        value="{{ old($col['name']) }}" />
                                    @error($col['name'])
                                        <p class="label text-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                            @if ($col['type'] === 'select')
                                <div class="flex flex-col  gap-2">
                                    <select name="{{ $col['name'] }}" class="select w-full">
                                        <option value="" disabled selected>Pilih {{ $col['label'] }}</option>
                                        @foreach ($col['option'] as $key => $value)
                                            <option value="{{ $key }}"
                                                @if (old($col['name']) === $key) selected @endif>
                                                {{ GeneralHelper::UpperCase($value) }}</option>
                                        @endforeach
                                    </select>
                                    @error($col['name'])
                                        <p class="label text-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        @endforeach
                    </fieldset>
                @endif
                <div class="flex flex-1 gap-2 self-center">
                    <button class="btn btn-sm btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </x-ui.admin-sidebar>
</x-app>
