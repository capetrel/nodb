@php
    $formBuilder = new \App\FormBuilder();
    if(isset($_POST) && !empty($_POST)) {
        dd($_POST);
    }

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
            {!! $formBuilder->field('name', null, 'Votre nom') !!}
            {!! $formBuilder->field('email', null, 'Votre email') !!}
            {!! $formBuilder->field('message', null, 'Votre message', ['type' => 'textarea']) !!}
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