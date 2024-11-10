@extends('layouts.app')

@section('title', ' - API admin')

@section('content')
    <div class="d-flex flex-column justify-content-center min-vh-100 align-items-center">
        <div class="card col-xl-7  col-lg-9 col-md-10 col-12">
            <div class="card-body">
                <h5 class="card-title">
                Sélectionner un atelier à modifier
            </h5>

            <form method="POST" action="{{ route('traiterSelectionAtelier') }}">
                @csrf

                <div>
                    <label for="id_atelier">Sélectionner un atelier</label>
                    <select name="id_atelier" id="id_atelier" required>
                        <option value="">-- Choisir un atelier --</option>
                        @foreach($atelier as $a)
                            <option value="{{ $a->id_atelier }}">{{ $a->titre }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit">Afficher les détails</button>
            </form>
        </div>
    </div>
</div>
@endsection
