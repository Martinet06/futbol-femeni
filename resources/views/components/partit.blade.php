@props(['equipLocal', 'equipVisitant', 'data_partit', 'golLocal', 'golVisitant'])

<div class="partit border rounded-lg shadow-md p-4 bg-white max-w-md mx-auto">
    <p><strong>{{ $equipLocal }}</strong> {{ $golLocal }} - {{ $golVisitant }} <strong>{{ $equipVisitant }}</strong></p>
    <p><strong>Data:</strong> {{ $data_partit }}</p>
    <a href="{{ route('partits.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded mt-2 inline-block">
        Tornar al llistat
    </a>
</div>