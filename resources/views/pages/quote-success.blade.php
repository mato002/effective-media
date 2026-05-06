@extends('layouts.website')

@section('title', 'Quote Request Sent | Effective Media')

@section('content')
    <section class="em-container py-20 text-center">
        <div class="mx-auto max-w-2xl rounded-xl border border-[#e6cdb8] bg-white p-8 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Success</p>
            <h1 class="mt-3 text-3xl font-bold text-[#5c1514]">Your Quote Request Has Been Received</h1>
            <p class="mt-4 text-sm text-[#5e5e5e]">Our sales team will review your campaign requirements and get back to you with a recommendation and quotation.</p>
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="{{ route('home') }}" class="em-btn-secondary">Back to Home</a>
                <a href="https://wa.me/254725646642?text=Hi%20Effective%20Media%2C%20I%20just%20submitted%20a%20quote%20request.%20Please%20share%20next%20steps." class="em-btn-primary" target="_blank" rel="noopener noreferrer" data-track-event="whatsapp_clicked">Talk to Sales on WhatsApp</a>
            </div>
        </div>
    </section>
@endsection
