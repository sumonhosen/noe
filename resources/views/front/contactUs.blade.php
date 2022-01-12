@extends('front.layouts.master')
@section('head')
    @include('meta::manager', [
        'title' => 'Contact Us'
    ])
@endsection

@section('master')
    <!-- Start Page Header Section -->
    <section class="bg-page-header">
        <div class="page-header-overlay">
            <div class="container">
                <div class="row">
                    <div class="page-header">
                        <div class="page-title">
                            <h2>contact info</h2>
                        </div>
                        <!-- .page-title -->
                        <div class="page-header-content">
                            <ol class="breadcrumb">
                                <li><a href="index.html">Home</a></li>
                                <li>Contact</li>
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
    <section class="bg-contact-us">
        <div class="container">
            <div class="row">
                <div class="contact-us">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="contact-title">Get in Touch</h3>
                            <form action="#" method="POST" class="contact-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="nameId" name="name" placeholder="Full Name">
                                        </div>
                                        <!-- .form-group -->
                                    </div>
                                    <!-- .col-md-6 -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="emailId" name="email" placeholder="Email Address">
                                        </div>
                                    </div>
                                    <!-- .col-md-6 -->
                                </div>
                                <!-- .row -->
                                <div class="form-group">
                                    <input type="text" class="form-control" id="subjectId" name="subject" placeholder="Subject">
                                </div>
                                <textarea class="form-control text-area" rows="3" placeholder="Message"></textarea>
                                <button type="submit" class="btn btn-default">Send Email</button>
                            </form>
                        </div>
                        <div class="col-lg-4">
                            <h3 class="contact-title">Contact Info</h3>
                            <ul class="contact-address">
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div class="contact-content">
                                        <p>{{$settings_g['street'] ?? ''}}</p>
                                        <p>{{$settings_g['city'] ?? ''}}-{{$settings_g['zip'] ?? ''}}, {{$settings_g['state'] ?? ''}}, {{$settings_g['country'] ?? ''}}</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="fas fa-phone-alt"></i>
                                    <div class="contact-content">
                                        <p>{{$settings_g['mobile_number'] ?? ''}}</p>
                                        <p>{{$settings_g['tel'] ?? ''}}</p>
                                    </div>
                                </li>
                                <li>
                                    <i class="fas fa-envelope-open-text"></i>
                                    <div class="contact-content">
                                        <p>{{$settings_g['email'] ?? ''}}</p>
                                    </div>
                                </li>
                            </ul>
                            <!-- .contact-address -->

                            <ul class="list-group list-group-horizontal contact-social-icon mb-0 pb-0">
                                <li><a href="#" target="_blank" class="btn-social btn-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#" target="_blank" class="btn-social btn-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#" target="_blank" class="btn-social btn-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                                <li><a href="#" target="_blank" class="btn-social btn-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                <li><a href="#" target="_blank" class="btn-social btn-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            </ul>

                        </div>
                    </div>
                    <!-- .row -->
                </div>
                <!-- .contact-us -->
            </div>
            <!-- .row -->
        </div>
        <!-- .container -->
    </section>
@endsection
