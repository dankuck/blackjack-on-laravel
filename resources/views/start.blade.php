@extends('layout')

@section('content')
<div class="row">
    <div class="col-12">
        <form action="/game" method="POST">
            <button type="submit" class="btn btn-primary">Start New Game</button>
        </form>
    </div>
</div>
@endsection
