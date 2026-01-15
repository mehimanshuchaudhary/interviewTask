@extends('layouts.app')

@section('content')
    <x-data-table :dataTable="$dataTable" title="User List" />
@endsection
