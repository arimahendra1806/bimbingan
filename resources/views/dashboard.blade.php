@extends('layouts.minia.header')

@if (Auth::check() && Auth::user()->role == 'koordinator')
    @include('koordinator.dashboard')
@elseif(Auth::check() && Auth::user()->role == 'kaprodi')
    @include('kaprodi.dashboard')
@elseif(Auth::check() && Auth::user()->role == 'admin')
    @include('admin.dashboard')
@elseif(Auth::check() && Auth::user()->role == 'dosen')
    @include('dosen.dashboard')
@elseif(Auth::check() && Auth::user()->role == 'mahasiswa')
    @include('mahasiswa.dashboard')
@endif
