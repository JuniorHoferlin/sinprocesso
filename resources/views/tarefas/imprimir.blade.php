@extends('layouts.imprimir')

@section('conteudo')
    @include('tarefas.listagem', ['imprimir' => true])
@endsection