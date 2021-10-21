@extends('layout.web')

@section('title', 'Tableau de bord')

@section('content')
    <div class="title">
        <h2 class="title">Tableau de bord</h2>
    </div>
    <div class="row mx-3 mb-3 justify-content-around">
        <div class="col-5 ml-2">
            <h2>Utilisateurs en attente</h2>
            @foreach($users as $user)
                {{ $user->firstname }}
                <form method="POST" action="/admin/verify/{{ $user->id }}">
                    @csrf
                    <button class="btn btn-success" type="submit">Accepter</button>
                </form>
            @endforeach
        </div>
        <div class="col-5 ml-3">
            <h2 class="title">Livres empruntés</h2>
            @foreach($books as $book)
                <div>{{ $book->title }} depuis le {{ $book->borrowDate }}</div>
                <img class="cover" src="{{ $book->first_cover }}" alt="Page de couverture">
                <form method="POST" action="/admin/restore">
                    @csrf
                    <input name="book_id" type="hidden" value="{{ $book->id }}">
                    <input name="user_id" type="hidden" value="{{ $book->user_id }}">
                    <button class="btn btn-info" type="submit">Livre rendu</button>
                </form>
            @endforeach
        </div>
    </div>
@endsection
