@extends('layouts.app')

@section('content')
    @include('layouts.admin-navbar')
    <!-- <h1>Admin Home</h1> -->
    <router-view></router-view>
@endsection
