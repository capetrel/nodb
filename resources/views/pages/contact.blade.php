@php
    $formBuilder = new \App\FormBuilder();
    if (isset($result['values'])) {
        $values = $result['values']->getValues();
    } else {
        $result['errors'] = null;
        $values = null;
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
        @if($page->content)
            <div class="content">
                {!! $page->content !!}
            </div>
        @endif

        @if(isset($result['success']))
            <div class="success-message">{{ $result['success'][0] }}</div>
        @elseif(!is_null($result['errors']))
            <div class="error-message">Veuillez corriger les erreurs dans le formulaire</div>
        @endif
        <form class="contact-form" action="" method="post">
            {!! $formBuilder->field($result['errors'], 'name', $values, 'Votre nom') !!}
            {!! $formBuilder->field($result['errors'], 'email', $values, 'Votre email') !!}
            {!! $formBuilder->field($result['errors'], 'message', $values, 'Votre message', ['type' => 'textarea']) !!}
            <button>Envoyer</button>
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