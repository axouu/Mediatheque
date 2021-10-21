@extends('layout.web')

@section('title', 'Confirmer')

@section('content')
    <div class="title">
        <h2 class="title">Confirmer les emprunts</h2>
    </div>
    <div class="row mx-3 mb-3 justify-content-around">
        @foreach($books as $book)
            <div class="col-3 mx-3">
                <div>{{ $book->title }}</div>
                <img class="cover" src="{{ $book->first_cover }}" alt="Page de couverture">
                <br>
                Demandé par {{ $book->user->firstname }} {{ $book->user->lastname }}
                <form method="POST" action="/admin/confirm/{{ $book->id }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Confirmer</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection
