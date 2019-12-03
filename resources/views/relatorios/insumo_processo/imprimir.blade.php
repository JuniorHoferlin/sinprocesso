@extends('layouts.imprimir')

@section('conteudo')
    @include('relatorios.insumo_processo.listagem', ['imprimir' => true])
@endsection