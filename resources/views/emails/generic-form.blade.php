<h2>{{ $subjectLine }}</h2>
@foreach ($data as $key => $value)
    <p><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</p>
@endforeach