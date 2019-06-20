@extends('layouts.app')

@section('meta')
<meta name="author" content="Matt Stauffer">
<meta name="description" content="Your dev blog - delivered! GistLog allows you to publish your blog posts via simple GitHub gists.">
<meta name="robots" content="index, follow">

<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="GistLog - Your dev blog delivered">
<meta itemprop="description" content="Your dev blog - delivered! GistLog allows you to publish your blog posts via simple GitHub gists.">

<!-- Open Graph data -->
<meta property="og:title" content="GistLog - Your dev blog delivered">
<meta property="og:type" content="product">
<meta property="og:image" content="{{ asset('img/gistlog-og.png') }}">
<meta property="og:url" content="{{ Request::url() }}">
<meta property="og:description" content="Your dev blog - delivered! GistLog allows you to publish your blog posts via simple GitHub gists.">
<meta property="og:site_name" content="GistLog">
@endsection

@section('styles')
<link href="/css/landing.css" rel="stylesheet">
@endsection

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-5xl font-hairline text-blue-darkest mb-2">Your Dev Blog Delivered</h1>
    <h2 class="text-2xl text-grey tracking-normal mb-10">Publish your first post in 55 seconds</h2>
    <a href="/posts/create" class="btn btn-cta">Get Started</a>
</div>

<div class="z-0 mt-4">
    <div class="img-cover blue-overlay" style="background-image: url('/img/main-bg.jpg')" title="Dev Blog - {{ config('app.name') }}"></div>
</div>

    @include('landing.instructions')
    @include('landing.features')
@endsection
