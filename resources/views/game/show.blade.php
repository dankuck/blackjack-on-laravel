@extends('layout')

@section('content')
    game {{ $game }}

    <div class="row">
        <div class="deck">
            @for ($i = $game->deck->card_count; $i > 0; $i--)
                <card card='BACK' style="position: absolute; left: {{ $i * 5 }}px;"></card>
            @endfor
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <h3>Dealer's Hand</h3>
            @foreach ($game->dealer_hand as $i => $card)
                <card card="{{ $i == 0 ? $card : 'BACK' }}"></card>
            @endforeach
        </div>
        <div class="col-6">
            <h3>Player's Hand</h3>
            <div>
                @foreach ($game->player_hand as $card)
                    <card card="{{ $card }}"></card>
                @endforeach
            </div>
            <div>
                <form class="inline" action="/game/{{ $game->id }}/hit" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary">Hit</button>
                </form>
                <form class="inline" action="/game/{{ $game->id }}/stand" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary">Stand</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('style')
.deck {
    position: relative;
    min-height: 200px;
}

form.inline {
    display: inline-block;
}
@endsection
