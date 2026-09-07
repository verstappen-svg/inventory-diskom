@extends('layouts.app')

@section('title', 'Notifikasi')

@section('page-title', 'Notifikasi')

@section('content')

<div style="
    background: white;
    padding: 25px;
    border-radius: 12px;
">

    <h2 style="margin-top: 0;">
        Semua Notifikasi
    </h2>

    @forelse($notifications as $notification)

        <a
            href="{{ route('notifikasi.read', $notification->id) }}"
            style="
                display: block;
                padding: 15px;
                border-bottom: 1px solid #eee;
                text-decoration: none;
                color: #333;
                background: {{ !$notification->dibaca ? '#f0f7ff' : '#fff' }};
            "
        >

            <strong>
                {{ $notification->judul }}
            </strong>

            <p style="margin: 5px 0;">
                {{ $notification->pesan }}
            </p>

            <small style="color: #999;">
                {{ $notification->created_at->diffForHumans() }}
            </small>

        </a>

    @empty

        <p style="color: #999;">
            Belum ada notifikasi.
        </p>

    @endforelse

</div>

@endsection