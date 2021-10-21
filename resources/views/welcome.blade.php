@extends('layout.web')

@section('title', 'Accueil')

@section('content')
    <p>
        Bonjour à tous
    </p>
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
