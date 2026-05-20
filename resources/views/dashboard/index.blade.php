@extends('layouts.app')

@section('title', 'Mi panel')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>Mi panel</h1>

        <a
            href="{{ route('photos.create') }}"
            class="btn btn-dark"
        >
            Subir foto
        </a>

    </div>
<div class="container py-4">

    @include('dashboard.partials.stats')

    @include('dashboard.partials.photos')

    @include('dashboard.partials.orders')

</div>

@endsection