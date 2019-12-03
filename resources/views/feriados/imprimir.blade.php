@extends('layouts.imprimir')

@section('conteudo')
    @include('feriados.listagem', ['imprimir' => true])
@endsection