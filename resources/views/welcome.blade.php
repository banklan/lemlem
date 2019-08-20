@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    <!-- <welcome></welcome> -->
    <router-view></router-view>
@endsection