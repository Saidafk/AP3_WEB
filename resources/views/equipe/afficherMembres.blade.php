


@extends('layouts.app')

@section('title', ' - Liste des membres')

@section('custom-css')
    <link href="/css/home.css" rel="stylesheet"/>
@endsection

@section('content')


                        <table>
                            @foreach($equipes as $unElement)
                            <tr>
                            <td>{{$unElement->nom}}</td>
                            </tr>
                            @endforeach
                        </table>
                        
                        @endsection

   