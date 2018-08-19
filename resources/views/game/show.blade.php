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
            @foreach ($game->dealer_hand as $card)
                <card card="{{ $card }}"></card>
            @endforeach
        </div>
        <div class="col-6">
            <h3>Player's Hand</h3>
            @foreach ($game->player_hand as $card)
                <card card="{{ $card }}"></card>
            @endforeach
        </div>
    </div>
@endsection

@section('style')
.deck {
    position: relative;
    min-height: 200px;
}
@endsection
