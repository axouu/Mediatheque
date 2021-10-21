@extends('layout.web')

@section('title', 'Ajouter un livre')

@section('content')
    <div style="text-align: center">
        <h2>Ajouter un livre</h2>
    </div>
    <div class="mx-5 my-2">
        <form method="POST" action="/admin/books/add">
            @csrf
            <div class="mb-3">
                <label for="titleInput" class="form-label">Titre</label>
                <input name="title" type="text" class="form-control" id="titleInput">
            </div>
            <div class="mb-3">
                <label for="descriptionInput" class="form-label">Description</label>
                <textarea name="description" type="text" class="form-control" id="descriptionInput" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="authorInput" class="form-label">Auteur</label>
                <input name="author" type="text" class="form-control" id="authorInput">
            </div>
            <div class="mb-3">
                <label for="coverInput" class="form-label">Url de la première de couverture</label>
                <input name="first_cover" type="text" class="form-control" id="coverInput">
            </div>
            <div class="mb-3">
                <label for="dateInput" class="form-label">Date de publication</label>
                <input name="publication_date" type="text" class="form-control" id="dateInput">
            </div>
            <div class="mb-3">
                <label for="genreInput" class="form-label">Genre</label>
                <input name="genre" type="text" class="form-control" id="genreInput">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
@endsection
