@extends('layouts.imprimir')

@section('conteudo')
    @include('tipo_processo.listagem', ['imprimir' => true])
@endsection