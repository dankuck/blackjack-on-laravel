@extends('layout')

@section('content')
    game {{ $game }}

    @for ($i = $game->deck->remainingCards->count(); $i > 0; $i--)
        <card card='BACK'></card>
    @endfor
@endsection
