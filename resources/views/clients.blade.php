@extends('layouts.app')

@section('content')
  <Clients :items="{{ $clients }}"></Clients>
@endsection
