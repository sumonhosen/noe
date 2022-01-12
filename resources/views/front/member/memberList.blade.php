@extends('front.layouts.master')
@php
    $page_title="Our Members"
@endphp
@section('head')
    @include('meta::manager', [
        'title' => $page_title.' - ' . ($settings_g['title'] ?? ''),
    ])
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>

<style>
    .board-img {
        height: 200px;
    }
</style>
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
<div class="page_wrap">
    <div class="container-md">
        <div class="py-5">
            <div class="container">
                {{-- <div class="row justify-content-center mb-4">
                    <div class="col-md-7 text-center">
                        <h5 class="boardsec_title text-uppercase">Our Members</h5>
                    </div>
                </div> --}}
                <div class="row justify-content-center">

                    @foreach($members as $member)

                        <div class="col-md-2 mb-1">
                            <!-- Row -->
                            <div class="row">
                                @if($member->profile_path)
                                <div class="board-img col-md-12" >
                                    <img src="{{$member->profile_path}}" alt="wrapkit" class="img-responsive center-block d-block mx-auto rounded-sm" />
                                </div>
                                @endif
                                <div class="col-md-12 text-center">
                                    <div class="pt-2">
                                        <h6 class="team-title">{{ $member->first_name.' '.$member->last_name }}</h6>
                                        <p class="designation">{{ $member->memberType?$member->memberType->name:'' }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Row -->
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- <div class="card-body table-responsive">

            <table class="table table-bordered table-sm" id="dataTable">
                <thead>
                <tr>
                    <th scope="col" class="text-center">SL.</th>
                    <th scope="col" class="text-center">Name</th>
                    <th scope="col" class="text-center">Email</th>
                    <th scope="col" class="text-center">Member Type</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($members as $key=>$member)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td class="text-center">{{ $member->first_name.' '.$member->last_name }}</td>
                            <td class="text-center">{{ $member->email }}</td>
                            <td class="text-center">{{ $member->memberType?$member->memberType->name:'' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>



    </div> --}}
</div>

@endsection

@section('footer')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>

    <script>
        $(document).ready( function () {
            $('#dataTable').DataTable({
                order: [[0, "asc"]],
            });
        });
    </script>
@endsection
