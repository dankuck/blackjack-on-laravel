@extends('layout')

@section('content')

    @foreach (['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'] as $face)
        @foreach (['S', 'C', 'H', 'D'] as $suit)
            <card card="{{ $face }}{{ $suit }}"></card>
        @endforeach
    @endforeach
    <card card="BACK"></card>

@endsection
