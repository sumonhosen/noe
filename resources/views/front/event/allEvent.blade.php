@extends('front.layouts.master')
@php
    $page_title="Events"
@endphp
@section('head')
    @include('meta::manager', [
        'title' => 'Events - ' . ($settings_g['slogan'] ?? '')
    ])
@endsection

@section('master')
<!-- Start Page Header Section -->
<section class="bg-page-header-common">
    <div class="page-header-overlay py-4">
        <div class="container">
            <div >
                <div class="page-header">
                    <div class="page-title text-center">
                        <h2 class="text-center">{{$page_title}}</h2>
                    </div>
                    <!-- .page-title -->
                    <div class="page-header-content text-center">
                        <ol class="breadcrumb">
                            <li><a href="/">Home</a></li>
                            <li>{{$page_title}}</li>
                        </ol>
                    </div>
                    <!-- .page-header-content -->
                </div>
                <!-- .page-header -->
            </div>
            <!-- .row -->
        </div>
        <!-- .container -->
    </div>
    <!-- .page-header-overlay -->
</section>
<!-- End Page Header Section -->
    <div>
        <div class="container">
            <div class="row">
                @foreach($events as $event)
                    <div class="col-md-4">
                        <a href="{{route('event',$event->id)}}" class="ue_box d-block">
                            <div class="thumb">
                                <img src="{{ $event->img_paths['small'] }}" alt="" class="whp">

                                <div class="ue_date">
                                    {{\Illuminate\Support\Carbon::parse($event->date)->format('M')}}
                                    <br>
                                    {{\Illuminate\Support\Carbon::parse($event->date)->format('d')}}
                                </div>
                            </div>

                            <div class="ue_title">{{$event->title }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
