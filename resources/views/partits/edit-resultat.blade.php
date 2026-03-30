<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Resultat del Partit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if (session('success'))
                        <div class="bg-green-100 text-green-700 p-4 mb-4 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('partits.update', $partit) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                {{ $partit->equipLocal->nom }} vs {{ $partit->equipVisitant->nom }}
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="gols_local" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ $partit->equipLocal->nom }} - Gols
                                    </label>
                                    <input 
                                        type="number" 
                                        name="gols_local" 
                                        id="gols_local" 
                                        min="0"
                                        value="{{ old('gols_local', $partit->gols_local) }}"
                                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    >
                                    @error('gols_local')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="gols_visitant" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ $partit->equipVisitant->nom }} - Gols
                                    </label>
                                    <input 
                                        type="number" 
                                        name="gols_visitant" 
                                        id="gols_visitant" 
                                        min="0"
                                        value="{{ old('gols_visitant', $partit->gols_visitant) }}"
                                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    >
                                    @error('gols_visitant')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Guardar Resultat') }}
                            </button>
                            <a href="{{ route('partits.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
