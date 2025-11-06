@extends('layouts.app')
@section('title', "Detall del Partit")

@section('content')
<x-partit :local="$partit['local']" :visitant="$partit['visitant']" :data="$partit['visitant']" :resultat="$partit['resultat']" />
@endsection