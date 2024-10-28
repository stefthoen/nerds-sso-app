<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>
    <div class="bg-white">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white p-6 text-gray-900">
                    {{ __("Here are a list of your clients:") }}
                    @foreach($clients as $client)
                        <div class="py-3 text-gray-900">
                            <h3 class="text-lg text-gray-500">{{ $client->name }}</h3>
                            <p>{{ $client->id }}</p>
                            <p>{{ $client->redirect }}</p>
                            <p>{{ $client->secret }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="/oauth/clients" method="POST">
                        <div class="mt-2 flex flex-col">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="Client name"></input>
                        </div>
                        <div class="mt-2 flex flex-col">
                            <label class="mt-2" for="redirect">Redirect</label>
                            <input type="text" name="redirect" placeholder="https://my-url.com/callback"></input>
                        </div>
                        <div class="mt-4">
                            @csrf
                            <button type="submit">Create Client</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
