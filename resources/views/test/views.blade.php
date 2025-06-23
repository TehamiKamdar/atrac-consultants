@foreach ($exploded as $index => $e)
    @if($index == 0)
        <h1>{{ $e }}</h1>
    @elseif($index == 1)
        <h2>{{ $e }}</h2>
    @elseif($index == 2)
        <h3>{{ $e }}</h3>
    @endif
@endforeach
