@extends('layouts.imprimir')

@section('conteudo')
    @include('relatorios.andamento_tarefas.listagem', ['imprimir' => true])
@endsection