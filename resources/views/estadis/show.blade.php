@extends('layouts.app')
@section('title', "Detall de l'Estadi")

@section('content')
<x-estadi :nom="$estadi['nom']" :ciutat="$estadi['ciutat']" :capacitat="$estadi['capacitat']" :equip_principal="$estadi['equip_principal']" />
@endsection