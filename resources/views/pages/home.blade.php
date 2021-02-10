@extends('layouts.site')

@push('css')
    @if(getEnvValue('APP_ENV') === 'local')
        <link rel="stylesheet" href="<?= asset('/css/test.css') ?>">
    @else
        <link rel="stylesheet" href="<?= asset('/css/test.min.css') ?>">
    @endif
@endpush

@section('content')
    <section class="intro">
        {!! $page->content !!}
    </section>

    <section class="works">
        @foreach($page->clients as $infos)
            <div class="card">
                <div class="card_header">
                    <a href="/clients/{{ $infos['client'] }}">
                        <h3>{!! $infos['nom'] !!}</h3>
                    </a>
                </div>
                <div class="card_body">
                    <p>{!! $infos['contenu'] !!}</p>
                </div>
            </div>
        @endforeach
    </section>
@endsection

@push('scripts')
    @if(getEnvValue('APP_ENV') === 'local')
        <script type="text/javascript" src="{{ asset('js/test.js') }}"></script>
    @else
        <script type="text/javascript" src="{{ asset('js/test.js') }}"></script>
    @endif
@endpush