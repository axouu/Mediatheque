@extends('layout.web')

@section('title', 'S\'inscrire')

@section('content')
    <div style="text-align: center">
        <h2>S'inscrire</h2>
    </div>
    <div class="mx-5 my-2">
        <form method="POST" action="{{ $_GET['type'] == 'employee' ? '/admin' : '' }}/register">
            @csrf
            <div class="mb-3">
                <label for="emailInput" class="form-label">Adresse Mail</label>
                <input name="email" type="email" class="form-control" id="emailInput">
            </div>
            <div class="mb-3">
                <label for="passwordInput" class="form-label">Mot de passe</label>
                <input name="password" type="password" class="form-control" id="passwordInput">
            </div>
            <div class="mb-3">
                <label for="confirmInput" class="form-label">Confirmation du mot de passe</label>
                <input name="confirm" type="password" class="form-control" id="confirmInput">
            </div>
            @if($_GET['type'] == 'user')
                <div class="mb-3">
                    <label for="firstnameInput" class="form-label">Prénom</label>
                    <input name="firstname" type="text" class="form-control" id="firstnameInput">
                </div>
                <div class="mb-3">
                    <label for="lastnameInput" class="form-label">Nom</label>
                    <input name="lastname" type="text" class="form-control" id="lastnameInput">
                </div>
                <div class="mb-3">
                    <label for="addressInput" class="form-label">Adresse</label>
                    <input name="address" type="text" class="form-control" id="addressInput">
                </div>
            @endif
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
@endsection
