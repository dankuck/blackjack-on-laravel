@extends('layout')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="deck">
                @for ($i = $game->deck->card_count; $i > 0; $i--)
                    <card card='BACK' style="position: absolute; left: {{ $i * 5 }}px;"></card>
                @endfor
            </div>
        </div>
    </div>
    @if ($game->winner)
        <h3 class="alert alert-primary" role="alert">
            @if ($game->winner == 'PLAYER')
                Player Wins!
            @elseif ($game->winner == 'DEALER')
                Dealer Wins
            @elseif ($game->winner == 'TIE')
                No winner
            @endif
        </h3>
    @endif
    @if ($game->deck->is_done)
        <h3 class="alert alert-secondary" role="alert">
            The game is over. 
            Player won {{ $game->player_wins }} time{{ $game->player_wins == 1 ? '' : 's' }}.
            Dealer won {{ $game->dealer_wins }} time{{ $game->dealer_wins == 1 ? '' : 's' }}.
        </h3>
    @endif
    <div class="row">
        <div class="col-6">
            <h3>Dealer's Hand</h3>
            @foreach ($game->dealer_hand as $i => $card)
                <card card="{{ $i > 0 && !$game->winner ? 'BACK' : $card }}"></card>
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
                @if ($game->deck->is_done)
                    <!-- No buttons -->
                @elseif ($game->winner)
                    <form class="inline" action="/game/{{ $game->id }}/deal" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">Deal</button>
                    </form>
                @else
                    <form class="inline" action="/game/{{ $game->id }}/hit" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">Hit</button>
                    </form>
                    <form class="inline" action="/game/{{ $game->id }}/stand" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">Stand</button>
                    </form>
                @endif
                <form class="inline" action="/game" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-secondary">Start New Game</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('style')
.deck {
    position: relative;
    min-height: 150px;
}

form.inline {
    display: inline-block;
}
@endsection
