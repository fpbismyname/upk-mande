<section id="register-card">
    <fieldset class="fieldset bg-base-300 flex flex-1 flex-col p-8 rounded-box" x-data="{ formLogin: true }">
        <div class="my-6 flex flex-row flex-1 items-center">
            <div class="flex flex-1 flex-col">
                <h1 class="text-xl font-bold">Upk Mande</h1>
                <label>Register</label>
            </div>
            <div>
                <a href="/" class="btn btn-link">Kembali</a>
            </div>
        </div>
        <form action="{{ route('register') }}" method="POST" class="flex flex-col w-full gap-2">
            @csrf
            @foreach (App\Models\User::getFieldUser('register') as $field)
                <legend class="fieldset-legend">{{ $field['label'] }}</legend>
                <input type="{{ $field['type'] }}" class="input input-sm input-neutral w-full"
                    name="{{ $field['name'] }}" value="{{ old($field['name']) }}">
                @error($field['name'])
                    <p class="label text-error">{{ $message }}</p>
                @enderror
            @endforeach
            <button type="submit" class="btn btn-neutral my-4 btn-sm">Daftar</button>
        </form>
        <p class="self-center">
            <span>Sudah punya akun ? </span>
            <a class="underline " href="{{ route('login') }}">Login</a>
        </p>

    </fieldset>
</section>
