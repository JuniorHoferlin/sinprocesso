@extends('layouts.imprimir')

@section('conteudo')
    @include('areas.listagem', ['imprimir' => true])
@endsection