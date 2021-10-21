@extends('layout.web')

@section('title', 'Mes emprunts')

@section('content')
    <div class="title">
        <h2 class="title">Mes emprunts</h2>
    </div>
    <div class="row mx-3 mb-3 justify-content-around">
        @foreach($books as $book)
            <div class="col-3 mx-3">
                <div>{{ $book->title }}</div>
                <img class="cover" src="{{ $book->first_cover }}" alt="Page de couverture">
                <div>
                    @if($book->confirmed)
                        Emprunté le {{ $book->borrowDate }}
                    @else
                        Reservé
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
