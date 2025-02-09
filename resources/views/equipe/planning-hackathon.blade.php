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
<link href="{{ asset('css/planning-atelier.css') }}" rel="stylesheet"/> 
@endsection

@section('content')
<div class="container mt-5">
    <h2>Planning des Ateliers - Hackathon : {{ $hackathon->thematique }}</h2>

    <!-- Calendrier -->
    <div id="calendar"></div>

    <script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            events: [
                @foreach ($events as $event)
                    {
                        title: "{{ $event['title'] }}",  // Titre de l'atelier
                        start: "{{ $event['start'] }}",  // Date de début de l'atelier
                        end: "{{ $event['end'] }}",      // Date de fin de l'atelier
                        description: "{{ $event['description'] }}",  // Description de l'atelier
                        url: "{{ $event['url'] }}", // URL pour les détails de l'atelier
                    },
                @endforeach
            ],
            eventClick: function(event) {
                if (event.url) {
                    window.location.href = event.url; // Redirige vers la page des détails de l'atelier
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
