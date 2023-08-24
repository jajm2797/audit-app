@extends('layouts.app', ['is_product' => false])

@section('content')
    @include('layouts.headers.cards',[
        'userAudits' => $userAudits,
        'userFinds' => $userFinds,
        'userFindsResolved' => $userFindsResolved
    ])

        <!--@include('layouts.footers.auth')-->
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
