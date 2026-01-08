@extends('layouts.equip')
@section('title', "Detall de la Jugadora")

@section('content')
<x-jugadora
    :nom="$jugadora->nom"
    :equip="$jugadora->equip->nom"
    :dorsal="$jugadora->dorsal"
    :data_naixement="$jugadora->data_naixement"
    :foto="$jugadora->foto" />
@endsection