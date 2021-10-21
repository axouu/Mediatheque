@extends('layout.web')

@section('title', 'Ajouter un livre')

@section('content')
    <div style="text-align: center">
        <h2>Ajouter un livre</h2>
    </div>
    <div class="mx-5 my-2">
        <form method="POST" action="/admin/books/add">
            @csrf
            <p class="text-danger">{{ $errors->first('message') }}</p>
            <div class="mb-3">
                <label for="titleInput" class="form-label">Titre</label>
                <input name="title" value="{{ old('title') }}" type="text" class="form-control" id="titleInput">
            </div>
            <div class="mb-3">
                <label for="descriptionInput" class="form-label">Description</label>
                <textarea name="description" value="{{ old('description') }}" type="text" class="form-control" id="descriptionInput" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="authorInput" class="form-label">Auteur</label>
                <input name="author" value="{{ old('author') }}" type="text" class="form-control" id="authorInput">
            </div>
            <div class="mb-3">
                <label for="coverInput" class="form-label">Url de la première de couverture</label>
                <input name="first_cover" value="{{ old('first_cover') }}" type="text" class="form-control" id="coverInput">
            </div>
            <div class="mb-3">
                <label for="dateInput" class="form-label">Date de publication</label>
                <input name="publication_date" value="{{ old('publication_date') }}" type="text" class="form-control" id="dateInput" aria-describedby="publication_help">
                <div id="publication_help" class="form-text">Format : AAAA-MM-JJ</div>
            </div>
            <div class="mb-3">
                <label for="genreInput" class="form-label">Genre</label>
                <input name="genre" value="{{ old('genre') }}" type="text" class="form-control" id="genreInput">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
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
