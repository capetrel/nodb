@php
    $formBuilder = new \App\FormBuilder();
    $data = (isset($_POST) && !empty($_POST)) ? $_POST : null;

@endphp
@extends('layouts.site')

@push('css')
    @if(getEnvValue('APP_ENV') === 'local')
        <link rel="stylesheet" href="<?= asset('/css/test.css') ?>">
    @else
        <link rel="stylesheet" href="<?= asset('/css/test.min.css') ?>">
    @endif
@endpush

@section('content')
    <section class="contact">
        <form class="contact-form" action="" method="post">
            {!! $formBuilder->field($data, 'name', null, 'Votre nom') !!}
            {!! $formBuilder->field($data, 'email', null, 'Votre email') !!}
            {!! $formBuilder->field($data, 'message', null, 'Votre message', ['type' => 'textarea']) !!}
            <button class="btn btn-primary right">Envoyer</button>
        </form>
    </section>
@endsection

@push('scripts')
    @if(getEnvValue('APP_ENV') === 'local')
        <script type="text/javascript" src="{{ asset('js/test.js') }}"></script>
    @else
        <script type="text/javascript" src="{{ asset('js/test.js') }}"></script>
    @endif
@endpush