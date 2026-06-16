@extends('layouts.app')

@section('title', 'Mi panel')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="display-5 fw-bold mb-0">
            Mi panel
        </h1>


        <div class="d-flex gap-2">

            <a
                href="{{ route('albums.create') }}"
                class="btn btn-dark"
            >
                Nuevo álbum
            </a>


            <a
                href="{{ route('photos.create') }}"
                class="btn btn-outline-dark"
            >
                Subir una foto
            </a>


            <a
                href="{{ route('photos.bulk-create') }}"
                class="btn btn-outline-dark"
            >
                Subir fotos
            </a>

        </div>

    </div>


    @include('dashboard.partials.stats')

    @include('dashboard.partials.photos')

    @include('dashboard.partials.albums')

    @include('dashboard.partials.orders')

</div>

@endsection