@extends('layouts.website')

@section('title', 'FAQs | Effective Media')

@section('content')
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=2000&q=80');"></div>
        <div class="absolute inset-0 bg-[linear-gradient(115deg,rgba(92,21,20,0.9),rgba(92,21,20,0.75),rgba(23,23,23,0.66))]"></div>
        <div class="em-container relative py-16 lg:py-20">
            <x-ui.section-heading label="FAQs" title="Frequently Asked Questions" description="Answers extracted from Effective Media company profile FAQs." light="true" />
        </div>
    </section>

    <section class="em-container py-14 lg:py-20">
        <div class="grid gap-4 md:grid-cols-2">
            @foreach (($profileContent['faqs'] ?? []) as $faq)
                <div class="em-card em-card-accent p-5">
                    <h3 class="text-base font-bold text-[#5c1514]">{{ $faq['question'] }}</h3>
                    <p class="mt-2 text-sm text-[#4f4f4f]">{{ $faq['answer'] }}</p>
                </div>
            @endforeach
        </div>
    </section>
@endsection
