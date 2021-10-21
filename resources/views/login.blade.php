@extends('layout.web')

@section('title', 'Connexion')

@section('content')
    <div style="text-align: center">
        <h2>Se connecter</h2>
    </div>
    <div class="mx-5 my-2">
        <form method="POST" action="/admin/login" id="loginForm">
            @csrf
            <div class="row mx-2">
                <div class="form-check col-2">
                    <input class="form-check-input" type="radio" name="userRole" id="radioEmployee" value="1">
                    <label class="form-check-label" for="radioEmployee">
                        Utilisateur
                    </label>
                </div>
                <div class="form-check col-2">
                    <input class="form-check-input" type="radio" name="userRole" id="radioUser" checked value="2">
                    <label class="form-check-label" for="radioUser">
                        Employé
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="emailInput" class="form-label">Adresse Mail</label>
                <input name="email" type="email" class="form-control" id="emailInput">
            </div>
            <div class="mb-3">
                <label for="passwordInput" class="form-label">Mot de passe</label>
                <input name="password" type="password" class="form-control" id="passwordInput">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberCheck" name="remember">
                <label class="form-check-label" for="rememberCheck">Se souvenir de moi</label>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
    @if(Session::has('message'))
        <div class="toast align-items-center text-white bg-danger bottom-0 start-0 position-absolute"
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
        $('input:radio[name="userRole"]').change(function () {
            console.log($(this).val());
            if ($(this).val() === '1') {
                $("#loginForm").attr('action', '/login');
            } else if ($(this).val() === '2') {
                $("#loginForm").attr('action', '/admin/login');
            } else {
                console.log("error, wrong value :", $(this).val());
            }
        });
    </script>
@endsection
