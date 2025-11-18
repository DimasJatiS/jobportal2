<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->role === 'user')
        <div class="py-4 max-w
        <!-- Menampilkan pekerjaan Apakah diterima atau ditolak -->
-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Status Aplikasi Anda</h3>
                    @if($applications->count())
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">Lowongan</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($applications as $application)
                                    <tr>
                                        <td class="px-4 py-2 text-sm">{{ $application->job->title }}</td>
                                        <td class="px-4 py-2 text-sm">
                                            @if($application->status === 'Accepted')
                                                <span class="text-green-600 font-semibold">Diterima</span>
                                            @elseif($application->status === 'Rejected')
                                                <span class="text-red-600 font-semibold">Ditolak</span>
                                            @else
                                                <span class="text-yellow-600 font-semibold">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else

                        <p>Anda belum mengirimkan aplikasi untuk lowongan apapun.</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
    
</x-app-layout>
