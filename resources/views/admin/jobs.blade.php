<x-app-layout>
    <div class="container mx-auto text-center mt-10 text-white">
        <h1 class="text-3xl font-bold mb-4">Admin Job Management</h1>
        <p>Welcome, {{ Auth::user()->name }} (Role: {{ Auth::user()->role }})</p>
    </div>
</x-app-layout>
