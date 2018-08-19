@extends('layout')

@section('content')
    game {{ $game }}

    <div class="row">
        @for ($i = $game->deck->card_count; $i > 0; $i--)
            <card card='BACK'></card>
        @endfor
    </div>
@endsection
