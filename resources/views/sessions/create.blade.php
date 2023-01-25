<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10">
            <h1 class="text-center font-bold text-xl">Login!</h1>
           <form method="POST" action="/login" class="mt-10">
                @csrf
                <x-panel>
                    <x-form.input name='email' type='email' autocomplete='username'/>
                    <x-form.input name='password' type='password' autocomplete='current-password'/>
                    <x-form.button>Log In</x-form.button>
                </x-panel>
            </form>
        </main>
    </section>
</x-layout>