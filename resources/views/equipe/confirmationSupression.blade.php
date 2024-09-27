@extends('layouts.app')

@section('title', ' - Mon équipe')

@section('content')

<p>Supression d'un membre</p>
<p>Etes vous sur de vouloir supprimer le membre $m->idmembre</p>


<form method="POST" action="{{ route('confirmationSupression', $m->idmembre) }}" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-small">supprimer le membre            
                            </form>

                            @endsection