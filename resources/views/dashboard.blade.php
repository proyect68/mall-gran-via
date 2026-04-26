@extends('layouts.app-authenticated')

@section('title', 'Dashboard - Mall Gran Vía')

@section('styles')
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .welcome-box {
        background: white;
        border-radius: 20px;
        padding: 60px 40px;
        text-align: center;
        box-shadow: 0 15px 50px rgba(0,0,0,0.1);
    }

    .welcome-box h1 {
        color: #3735af;
        font-size: 36px;
        margin-bottom: 16px;
    }

    .welcome-box p {
        color: #666;
        font-size: 18px;
        margin-bottom: 30px;
    }

    .welcome-emoji {
        font-size: 80px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .welcome-box {
            padding: 40px 20px;
        }

        .welcome-box h1 {
            font-size: 28px;
        }
    }
</style>
@endsection

@section('content')
<main class="dashboard-container">

    <div class="welcome-box">
        <div class="welcome-emoji">👋</div>

        <h1>¡Bienvenido a tu Dashboard!</h1>

        <p>Este es tu espacio personal en Mall Gran Vía.</p>

        <p style="color: #999; font-size: 14px;">
            Pronto añadiremos más funcionalidades aquí.
        </p>
    </div>

</main>
@endsection
