@extends('layout')

@section('content')
<x-sidebar />
<div class="container" style="padding:20px">
    <a href="{{ route('community.index') }}" class="btn">&larr; Back to articles</a>

    <div style="margin-top:12px; background:white; padding:18px; border-radius:8px">
        @if($article->image_path)
            <img src="{{ asset('storage/'.$article->image_path) }}" style="width:100%; max-height:420px; object-fit:cover; border-radius:8px">
        @endif
        <h1 style="margin-top:12px">{{ $article->title }}</h1>
        <div style="color:#666; font-size:14px">By 
            @if($article->user)
                @php
                    $u = $article->user;
                    $profileIdentifier = $u->username ?: $u->id;
                @endphp
                <a href="{{ route('profile.show', $profileIdentifier) }}">{{ $u->username ?? $u->name }}</a>
            @else
                Unknown
            @endif
             • {{ $article->created_at->diffForHumans() }}

        </div>

        <div style="margin-top:16px; color:#333; line-height:1.6;">
            {!! $article->body !!}
        </div>
    </div>
</div>
@endsection