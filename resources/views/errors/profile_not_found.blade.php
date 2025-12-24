@extends('layout')

@section('content')
<x-sidebar />
<div class="container" style="padding:40px">
    <div style="background:white;padding:24px;border-radius:8px">
        <h2>Profil tidak ditemukan</h2>
        <p>Maaf, kami tidak menemukan profil untuk identifier: <strong>{{ $identifier }}</strong>.</p>
        @if($authUser)
            <p>Anda sedang masuk sebagai <strong>{{ $authUser->name }}</strong>. Mungkin Anda ingin membuka <a href="{{ route('profile.show', $authUser->username ?: $authUser->id) }}">profil Anda</a>?</p>
        @else
            <p>Jika Anda yakin link ini seharusnya valid, coba login atau kembali ke <a href="/">beranda</a>.</p>
        @endif
        <p style="margin-top:12px"><a href="/">&larr; Kembali ke beranda</a></p>
    </div>
</div>
@endsection