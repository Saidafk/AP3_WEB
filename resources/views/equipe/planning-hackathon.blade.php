@extends('layouts.app')

@section('title', 'Atelier')

<!-- Assurez-vous que jQuery est chargé avant FullCalendar -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Moment.js pour la gestion des dates -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet"/>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>


@section('custom-css')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet"/>
@endsection

@section('content')
<div class="container mt-5">
    <h2>Planning des Ateliers - Hackathon : {{ $hackathon->thematique }}</h2>

    <!-- Calendrier -->
    <div id="calendar"></div>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                events: [
                    @foreach ($ateliers as $atelier)
                        {
                            title: "{{ $atelier->titre }}",  // Titre de l'atelier
                            start: "{{ $atelier->date_debut }}",  // Date et heure de début
                            end: "{{ $atelier->date_fin }}",  // Date et heure de fin
                            description: "{{ $atelier->description }}",  // Description de l'atelier
                            url: "/planning-hackathon/info/{{$atelier->id_atelier}}",  // Lien pour consulter les détails de l'atelier
                        },
                    @endforeach
                ],
                eventClick: function(event) {
                    if (event.url) {
                        window.location = event.url; // Rediriger vers la page des détails de l'atelier
                        return false;  // Empêche l'action par défaut
                    }
                },
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'month', // Vue par défaut (mois, semaine, jour)
            });
        });
    </script>
</div>
@endsection
