@php
    $title = $title ?? '';
    $form = $formConfig ?? [];
    $data = isset($datas) ? $datas->toArray() : [];
    $back = url()->current() === url()->previous() ? route('admin-dashboard') : url()->previous();
@endphp

<x-app title="{{ $title }}">
    <x-ui.admin-sidebar title="{{ $title }}" :routeName="$routeName">
        <div class="bg-base-300 p-8 rounded-xl flex flex-col">
            <form action="{{ route($routeSubmit, [GeneralHelper::SnakeCase($routeName) => $data['id']]) }}" method="POST"
                class="flex flex-col flex-1 gap-4">
                @if ($form)
                    <fieldset class="fieldset w-full rounded-xl gap-4">
                        @method('PUT')
                        @csrf
                        @foreach ($form as $col)
                            @if ($col['type'] === 'number' || $col['type'] === 'text' || $col['type'] === 'email' || $col['type'] === 'password')
                                @if ($col['name'] === 'password')
                                    <div x-data="{ resetPass: false }" class="flex flex-col gap-4">
                                        <label class="label">
                                            <input type="checkbox" class="checkbox checkbox-sm" x-model="resetPass"
                                                name="reset-{{ $col['name'] }}">
                                            Reset Password ?
                                        </label>
                                        <input x-show="resetPass" type="{{ $col['type'] }}" name="{{ $col['name'] }}"
                                            class="input input-sm input-neutral w-full" placeholder="Password baru" />
                                        @error($col['name'])
                                            <p class="label">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @else
                                    <input type="{{ $col['type'] }}" name="{{ $col['name'] }}"
                                        class="input input-sm w-full"
                                        placeholder="{{ GeneralHelper::UpperCase($col['label']) }}"
                                        value="{{ $data[$col['name']] }}" />
                                    @error($col['name'])
                                        <p class="label">{{ $message }}</p>
                                    @enderror
                                @endif
                            @endif
                            @if ($col['type'] === 'select')
                                <select name="{{ $col['name'] }}" class="select w-full">
                                    <option value="" disabled selected>Pilih {{ $col['label'] }}</option>
                                    @foreach ($col['option'] as $key => $value)
                                        <option value="{{ $key }}"
                                            @if ($key === $datas[$col['name']]) selected @endif>
                                            {{ GeneralHelper::UpperCase($value) }}</option>
                                    @endforeach
                                </select>
                                @error($col['name'])
                                    <p class="label">{{ $message }}</p>
                                @enderror
                            @endif
                        @endforeach
                    </fieldset>
                @endif
                <div class="flex flex-1 gap-2 self-center">
                    <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                    <a href="{{ $back }}" class="btn btn-sm btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </x-ui.admin-sidebar>
</x-app>
