@extends('layout.web')

@section('title', 'Livres')

@section('content')
    <div class="title">
        <h2 class="title">Liste des livres</h2>
    </div>
    <div class="row mx-3 mb-3 justify-content-around">
        @foreach($books as $book)
            <div class="col-3 mx-3">
                <div>{{ $book->title }}</div>
                <img class="cover" src="{{ $book->first_cover }}" alt="Page de couverture">
                @if(!$book->user)
                    <form method="POST" action="/borrow/{{ $book->id }}">
                        @csrf
                        <button type="submit" class="btn btn-success">Emprunter</button>
                    </form>
                @else
                    <div>
                        <button type="button" class="btn btn-light" disabled>Déjà emprunté</button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
