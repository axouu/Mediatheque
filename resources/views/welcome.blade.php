@extends('layout.web')

@section('title', 'Accueil')

@section('content')
    <div class="title">
        <h2 class="title">Livres disponibles</h2>
    </div>
    <div class="row mx-3 mb-3 justify-content-around">
        @foreach($books as $book)
            <div class="col-3 mx-3">
                <div>{{ $book->title }}</div>
                <img class="cover" src="{{ $book->first_cover }}" alt="Page de couverture">
            </div>
        @endforeach
    </div>
    @if(Session::has('message'))
        <div class="toast align-items-center text-white bg-success bottom-0 start-0 position-absolute"
             role="alert"
             aria-live="assertive"
             aria-atomic="true"
             data-bs-autohide="false"
        >
            <div class="d-flex">
                <div class="toast-body">
                    {{ Session::get('message') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close" id="closeToast"></button>
            </div>
        </div>
    @endif
    <script>
        @if(Session::has('message'))
            $('.toast').show();
            $('#closeToast').on('click', function () {
                $('.toast').hide();
            })
        @endif
    </script>
@endsection
