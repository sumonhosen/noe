@extends('front.layouts.master')
@section('head')
    @include('meta::manager', [
        'title' => ($settings_g['title'] ?? env('APP_NAME')) . ' - ' . ($settings_g['slogan'] ?? '')
    ])

    <link rel="stylesheet" href="{{asset('front/css/owl.carousel.min.css')}}">

    <style>
        #container {
            position:relative;
        }

        #img2 {
            position: absolute;
            top: 5px;
        }
    </style>
@endsection

@section('master')
    <!-- Slider -->
    <section class="slider_and_navbar slider_section">
        <div class="slider_section">
            <div class="slideshow_container">
                @foreach ($sliders as $key => $slider)
                    <div class="mySlides">
                        @if($slider->slider_type==1)
                            <img src="{{$slider->img_paths['original']}}" alt="{{$slider->text_1}}">
                        @elseif($slider->slider_type==2)
                            <video class="img-fluid" autoplay loop muted>
                                <source src="{{ $slider->video_path }}" type="video/mp4" />
                            </video>

                            <!-- <iframe class="embed-responsive-item" autoplay width="100%" height="800px" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>-->
                            <!-- <iframe class="elementor-background-video-embed" frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" title="YouTube video player"
                            width="100%" height="800px" src="https://www.youtube.com/embed/BY5JR5YwD00?controls=0&amp;rel=0&amp;playsinline=1&amp;enablejsapi=1&amp;origin=https%3A%2F%2Fstylezworld.com&amp;widgetid=1" id="widget2"
                            style="width: 1903px; height: 1070.44px;"></iframe>-->
                        @endif

                        {{-- <div class="slider_content_wrap">
                            <div class="container {{($key % 2) ? 'text-right' : ''}}">
                                <div class="slider_content {{($key % 2) ? 'text-right d-inline-block' : ''}}">
                                    <h2>{{$slider->text_1}}</h2>
                                    <span class="sc_border"></span>
                                    <br>
                                    <p class="text-light d-none d-md-block">{!!$slider->description!!}</p>
                                    @if($slider->button_1_text && $slider->button_1_url)
                                        <a href="{{$slider->button_1_url}}" class="btn_slider">{{$slider->button_1_text}} <i class="fas fa-arrow-right"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div> --}}
                    </div>
                @endforeach
                <!-- Carousel wrapper -->

                <div class="slider_dot_container">
                    @foreach ($sliders as $key => $slider)
                        <span class="dot" onclick="currentSlide('{{$key + 1}}')"></span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Slider End -->

    @if(count($home_sections))
        @foreach($home_sections as $key=>$sec)
            @if($sec->section_design_type_id==1)
                <section class="content_section_1 py-5" style="background: {{$sec->background_color}}">
                    <div class="container-fluid">
                        <div class="container">
                            <div class="content_sec1 pt-0 pb-0 pt-md-5 pb-md-5">
                                <div class="row">
                                    @if($sec->text_align ==1)
                                        <div class="col-md-6">
                                            <div class="{{$sec->is_image_inner_border?'img_inner_border':''}} card-img-wrap">
                                                <img class="img-fluid " src="{{ $sec->img_paths['original'] }}" alt="">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="content_sec1_content">
                                            <div class="sec1_top_border"></div>

                                            <h3 class="sec_title text-uppercase">{{ $sec->title }}</h3>
                                            <h3 style="font-weight: 700">{{ $sec->sub_title }}</h3>

                                            <div class="section_content">
                                                {!! \Illuminate\Support\Str::limit($sec->short_description,800) !!}
                                            </div>

                                            <a href="{{ $sec->button_url??route('single.home.page',$sec->id) }}" class="animated-button6 bt_back nav">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                {{ $sec->button_name??'Read More' }}
                                            </a>
                                        </div>
                                    </div>
                                    @if($sec->text_align ==2)
                                        <div class="col-md-6">
                                            <div class="card-img-wrap">
                                                <img class="img-fluid" src="{{ $sec->img_paths['original'] }}" alt="">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                {{--text and card section end--}}

                {{--publication section start--}}
            @elseif($sec->section_design_type_id==2 && count($news)>0)
                <div style="background: {{$sec->background_color}}" class="pb-5">
                    <div class="mb-2 pt-5 pb-5">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 offset-min-1">
                                    @if($sec->section_name_is_show)
                                        <h2>{{ $sec->section_name }}</h2>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="content_section_4 px-0 px-md-5" style="background: {{$sec->background_color}}">
                        <div class="container">
                            <div class="row row-cols-1 row-cols-md-3 g-4 pb-5">
                                @foreach($news->take($sec->col) as $new)
                                    <div class="col-sm-{{$sec->col==3?'4':'3'}} mb-3 mb-md-0">
                                        <div class="card">
                                            <div class="{{$sec->is_image_inner_border?'img_inner_border':''}} card-img-wrap">
                                                <img src="{{ $new->img_paths['small'] }}" class="card-img-top" alt="...">
                                            </div>
                                            <div class="card-body overlap_content">
                                                <h5 class="card-title" style="min-height: 60px">{{$new->title}}</h5>
                                                <p class=""><i>Posted on</i> <span class="text-danger">{{ \Carbon\Carbon::parse($new->created_at)->format('j F, Y') }}</span> </p>
                                                <div class="card-text">
                                                    {!! \Illuminate\Support\Str::limit($new->short_description,150) !!}
                                                </div>
                                                <div>
                                                    <a href="{{route('news.single',$new->id)}}" class="animated-button6 bt_back nav mt-2">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        Read More
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    <div class="text-center">
                        <a href="{{ route('news.all') }}" class="button tn_load_more_btn button_view_all mt-0">View All</a>
                    </div>
                </div>


                {{--news section end--}}

                {{--contribution section start--}}
            @elseif($sec->section_design_type_id==3 && count($fund_raisers)>0)
                <div style="background: {{$sec->background_color}}">
                    <div class="p-5 mb-2">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 offset-min-1">
                                    @if($sec->section_name_is_show)
                                        <h2>{{ $sec->section_name }}</h2>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="content_section_5" style="background: {{$sec->background_color}}">
                        <div class="container-fluid">
                            <div class="container">
                                <div class="row row-cols-1 row-cols-md-3 g-4 pb-5">
                                    @foreach($fund_raisers->take($sec->row * $sec->col) as $fund)
                                        <div class="col-md-{{$sec->col==3?'4':'3'}}">
                                            <div class="card mb-3 mb-md-0">
                                                <div class="{{$sec->is_image_inner_border?'img_inner_border':''}} overflow-hidden thumb card-img-wrap">
                                                    <img src="{{ $fund->img_paths['small'] }}" class="card-img-top" alt="...">
                                                </div>

                                                <div class="card-body">
                                                    @if($fund->targeted_fund)
                                                        <div class="raised">
                                                            <span class="raised_title"> Raised {{$fund->targeted_fund}}</span> <span class="raised_font">Raised {{$fund->targeted_fund}}</span>
                                                        </div>
                                                    @endif
                                                    @php
                                                        $percentage = 0;
                                                        if($fund->donations){
                                                            $collect_fund = $fund->donations->where(['payment_status'=>'succeeded'])->sum('amount');
                                                            if($fund->targeted_fund>0 && $collect_fund>0){
                                                                $percentage = ($fund->targeted_fund/$collect_fund)/100;
                                                             }
                                                        }
                                                    @endphp
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-success active" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                            {{ $percentage }} %
                                                        </div>
                                                    </div>
                                                    <div class="card_content">
                                                        <h5 class="card-title">{{ $fund->title }}</h5>
                                                        <div class="card-text">
                                                            {!! \Illuminate\Support\Str::limit($fund->short_description,150) !!}
                                                        </div>
                                                    </div>

                                                    <a href="{{ route('donate',$fund->id) }}" class="animated-button6 bt_back nav ml-1 mt-2">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        Donate Now
                                                    </a>
                                                </div>
                                                {{-- <div>
                                                    <a href="{{ route('donate',$fund->id) }}" class="animated-button6 bt_back nav ml-1">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        Donate Now
                                                    </a>
                                                </div> --}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- <div class="text-center pb-4">
                                    <a href="" class="button">SEE ALL</a>
                                </div>-->
                            </div>
                        </div>
                    </section>
                    <div class="text-center">
                        <a href="{{route('donation.program')}}" class="button tn_load_more_btn button_view_all mt-0">View All</a>
                    </div>
                </div>
                {{--contribution section end--}}

                {{--Vote/half paralax section start--}}

            @elseif($sec->section_design_type_id==4 && count($votes) > 0)
                <section class="content_section_3 m-0" style="background: {{$sec->background_color}}" id="app">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="feedback_parallax" style="background-image: url('{{$sec->img_paths['original'] ?? asset("front/assets/css/survey-testing.png")}}')">
                                <div class="text-center">
                                    <div>
                                        @if($sec->section_name_is_show)
                                            <h3>{{ $sec->title }}</h3>
                                            <h4>{{ $sec->sub_title }}</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                                <div class="content_sec3_content">
                                    {{-- <div class="sec1_top_border"></div>
                                    <h2 class="text-upercase">Survay</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque alias iure delectus doloremque dicta sunt nisi quos eligendi porro, vero quia consequuntur corrupti accusamus. In molestias distinctio, velit laborum modi voluptatem aliquam
                                        explicabo ex fugiat ipsum ipsa porro dolorem asperiores voluptas iste laboriosam? Enim molestias veritatis eligendi ipsum atque placeat.</p>
                                    <a href="#" class="continue_reading">CONTINUE READING  <i class="fa fa-arrow-right"></i></a> --}}

                                    <div id="carouselExampleIndicators" class="carousel slide" data-interval="false" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($votes as $key=>$vote)
                                                <div class="carousel-item {{$key==0?'active':'' }}">
                                                    <vote-create app_url="{{env('APP_URL')}}" :vote="{{$vote}}" ip="{{Request::ip()}}" img_path="{{$vote->img_paths['small']}}" answers="{{$vote->voteAnswer}}" user_id="{{auth()->check()?auth()->id():null }}"></vote-create>
                                                </div>
                                            @endforeach
                                        </div>

                                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </section>
                {{--Vote/half paralax section end--}}

                {{--full parallax section start--}}
            @elseif($sec->section_design_type_id==5)
                <section class="has-bg-img text-center" >
                    <div class="parallax" {{$sec->is_image_inner_border?'img_inner_border':''}}" style="background-image: url('{{$sec->img_paths['original'] ?? asset("front/assets/css/survey-testing.png")}}')">
                     <div class="parallax-content">
                            <h5 class="pt-5 p-2"> {{ $sec->title }}</h5>
                            <h6> {{ $sec->sub_title }}</h6>
                            @if ($sec->short_description)
                             <div class="bg-custom">{!! $sec->short_description !!}</div>
                            @endif
                            <a href="{{ $sec->button_url??route('single.home.page',$sec->id) }}" class="animated-button6 bt_back nav">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                {{ $sec->button_name??'Read More' }}
                            </a>
                        </div>


                            {{-- <a href="{{$sec->button_url}}" class="btn btn-outline-success btn-sm animated_btn nav">
                                <span class="ab_bg_left"></span>
                                <span class="btn-text-wrap"><span class="btn-text">
                                                <span class="visibility-hidden">.</span><span class="btn-text-up">
                                                                            {{$sec->button_name}}
                                                                        </span></span></span>
                                <span class="ab_bg_right"></span>
                            </a> --}}
                    </div>

                </section>
                {{--full parallax section end--}}

                {{--event section start--}}
            @elseif($sec->section_design_type_id == 6 && count($events) >0)
                <div class="upcoming_events" style="background: {{$sec->background_color}}">
                    <div class="container">
                        <div class="ue_wrap">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="upcoming_events_items owl-carousel">
                                        @foreach ($events as $event)
                                            <div class="ue_owl_item">
                                                <a href="{{route('event',$event->id)}}" class="ue_box d-block">
                                                    <div class="thumb card-img-wrap event_image_container">
                                                        <div class="event_image_wrap">
                                                            <img src="{{ $event->img_paths['small'] }}" alt="" class="whp">
                                                        </div>

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

                                        {{-- @for($i=0; $i<count($events); $i = $i+2)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <a href="{{route('event',$events[$i]->id)}}" class="ue_box d-block">
                                                        <div class="thumb card-img-wrap event_image_container">
                                                            <div class="event_image_wrap">
                                                                <img src="{{ $events[$i]->img_paths['small'] }}" alt="" class="whp">
                                                            </div>

                                                            <div class="ue_date">
                                                                {{\Illuminate\Support\Carbon::parse($events[$i]->date)->format('M')}}
                                                                <br>
                                                                {{\Illuminate\Support\Carbon::parse($events[$i]->date)->format('d')}}
                                                            </div>
                                                        </div>

                                                        <div class="ue_title">{{$events[$i]->title }}</div>
                                                    </a>
                                                </div>
                                                @php
                                                    $j=$i;
                                                    $j = count($events) > ($j+1)?($j+1):0;
                                                @endphp
                                                @if(count($events) > ($i+1))
                                                <div class="col-md-6">
                                                    <a href="{{route('event',$events[$j]->id)}}" class="ue_box d-block">
                                                        <div class="thumb card-img-wrap event_image_container">
                                                            <div class="event_image_wrap">
                                                                <img src="{{ $events[$j]->img_paths['small'] }}" alt="" class="whp">
                                                            </div>

                                                            <div class="ue_date">
                                                                {{\Illuminate\Support\Carbon::parse($events[$j]->date)->format('M')}}
                                                                <br>
                                                                {{\Illuminate\Support\Carbon::parse($events[$j]->date)->format('d')}}
                                                            </div>
                                                        </div>
                                                        <div class="ue_title">{{$events[$j]->title }}</div>
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                        @endfor --}}
                                    </div>
                                </div>

                                <div class="col-md-4" >
                                    <div class="ue_right_text" style="background: {{$sec->background_color}}">
                                        <h2 class="ue_section_title">{{ $sec->section_name }}</h2>
                                        <p class="ue_section_content">{!! $sec->short_description !!}</p>
                                    </div>
                                    <a href="{{route('event.all')}}" class="ue_button">See All <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--event section end--}}

                {{--board member section start--}}
            @elseif($sec->section_design_type_id == 7 && count($executive_members) >0)
                {{--
                <section class="our-webcoderskull padding-lg">
                    <div class="container">
                        <div class="row heading heading-icon">
                            @if($sec->section_name_is_show)
                                <h2>{{ $sec->section_name }}</h2>
                            @endif
                        </div>
                        <div class="row">
                            @foreach($executive_members as $member)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="cnt-block equal-hight" style="height: 349px;">
                                        <figure><img src="{{$member->img_paths['original']}}" class="img-responsive" alt=""></figure>
                                        <h3 style="height: 50px;">
                                            <a href="#">{{ $member->name }}</a>
                                        </h3>
                                        <p>{{ $member->designation }}</p>
                                        <ul class="follow-us clearfix">
                                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                --}}

                <div class="py-5" style="background: {{$sec->background_color}}">
                    <div class="container">
                        <div class="row justify-content-center mb-4">
                            <div class="col-md-7 text-center">
                                @if($sec->section_name_is_show)
                                    <h5 class="boardsec_title text-uppercase">{{ $sec->section_name }}</h5>
                                    <h6 class="boardsec_subtitle">{{ $sec->sub_title}}</h6>
                                @endif

                            </div>
                        </div>
                        <div class="row justify-content-center">
                            @foreach($executive_members as $member)
                            <div class="col-md-4 mb-12">
                                <!-- Row -->
                                <div class="row">
                                    <div class="board-img col-md-12">
                                        <img src="{{$member->img_paths['medium']}}" alt="wrapkit" class="img-responsive center-block d-block mx-auto rounded-lg" />
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <div class="pt-2">
                                            <h6 class="team-title">{{ $member->name }}</h6>
                                            <p class="designation">{{ $member->designation }}</p>
                                            <div class="team-description">
                                                <p> {!! \Illuminate\Support\Str::limit($member->description,120) !!}</p>
                                            </div>
{{--                                            <ul class="list-inline">--}}
{{--                                                <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="icon-social-facebook"></i></a></li>--}}
{{--                                                <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="icon-social-twitter"></i></a></li>--}}
{{--                                                <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="icon-social-instagram"></i></a></li>--}}
{{--                                                <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="icon-social-behance"></i></a></li>--}}
{{--                                            </ul>--}}
                                        </div>
                                    </div>
                                </div>
                                <!-- Row -->
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{--board member section end--}}

                {{--executive member section start--}}
            @elseif($sec->section_design_type_id == 8 && count($general_members) >0)
                {{--
                <section class="our-webcoderskull padding-lg">
                    <div class="container">
                        <div class="row heading heading-icon">
                            @if($sec->section_name_is_show)
                                <h2>{{ $sec->section_name }}</h2>
                            @endif
                        </div>
                        <div class="row justify-content-center">
                            @foreach($general_members as $member)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="cnt-block equal-hight" style="height: 349px;">
                                        <figure><img src="{{$member->img_paths['original']}}" class="img-responsive" alt=""></figure>
                                        <h3 style="height: 50px;">
                                            <a href="#">{{ $member->name }}</a>
                                        </h3>
                                        <p>{{ $member->designation }}</p>
                                        <ul class="follow-us clearfix">
                                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                --}}
                <div class="py-5" style="background: {{$sec->background_color}}">
                    <div class="container">
                        <div class="row justify-content-center mb-4">
                            <div class="col-md-7 text-center">
                                @if($sec->section_name_is_show)
                                    <h5 class="boardsec_title text-uppercase">{{ $sec->section_name }}</h5>
                                    <h6 class="boardsec_subtitle">{{ $sec->sub_title}}</h6>
                                @endif

                            </div>
                        </div>
                        <div class="row justify-content-center">
                            @foreach($general_members as $member)
                                <div class="col-md-3 mb-12">
                                    <!-- Row -->
                                    <div class="row">
                                        <div class="board-img col-md-12">
                                            <img src="{{$member->img_paths['small']}}" alt="wrapkit" class="img-responsive center-block d-block mx-auto rounded-lg" />
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <div class="pt-2">
                                                <h6 class="team-title">{{ $member->name }}</h6>
                                                <p class="designation">{{ $member->designation }}</p>
                                                <div class="team-description">
                                                    <p> {!! \Illuminate\Support\Str::limit($member->description,80) !!}</p>
                                                </div>
{{--                                                <ul class="list-inline">--}}
{{--                                                    <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="icon-social-facebook"></i></a></li>--}}
{{--                                                    <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="icon-social-twitter"></i></a></li>--}}
{{--                                                    <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="icon-social-instagram"></i></a></li>--}}
{{--                                                    <li class="list-inline-item"><a href="#" class="text-decoration-none d-block px-1"><i class="icon-social-behance"></i></a></li>--}}
{{--                                                </ul>--}}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row -->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{--executive member section end--}}

                {{--gallery section start --}}
            @elseif($sec->section_design_type_id == 9 && count($gallery_categories) >0)
                <section class="event-area mb-5 mt-5" style="background: {{$sec->background_color}}">
                    <div class="container">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            @foreach ($gallery_categories as $key => $gallery_category)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{$key == 0 ? 'active' : ''}} tab_nav_text" id="pills-{{$gallery_category->id}}-tab" data-toggle="pill" href="#pills-{{$gallery_category->id}}" role="tab" aria-controls="pills-{{$gallery_category->id}}" aria-selected="true">{{$gallery_category->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content " id="pills-tabContent">
                            @foreach ($gallery_categories as $key => $gallery_category)
                                <div class="tab-pane fade show {{$key == 0 ? 'active' : ''}}" id="pills-{{$gallery_category->id}}" role="tabpanel" aria-labelledby="pills-{{$gallery_category->id}}-tab">
                                    <div class="row mb-4">
                                        @foreach ($gallery_category->GalleryImages() as $galleryImage)
                                            @php
                                                if(file_exists(public_path("uploads/gallery/medium/$galleryImage->image"))){
                                                    $img = asset("uploads/gallery/small/$galleryImage->image");
                                                }else{
                                                    $img = asset('img/no-image.png');
                                                }
                                            @endphp
                                            <div class="col-sm-3">
                                                <!-- Rotating card -->
                                                <div class="card-wrapper">
                                                    <div id="card-2" class="card card-rotating text-center">
                                                        <!--Front Side-->
                                                        <div class="face front">
                                                            <!-- Image-->
                                                            <div class="view overlay card-img-wrap gallery">
                                                                <img class="card-img-top img-fluid" src="{{ $img }}" alt="Example photo">
                                                                <a>
                                                                    <div class="mask rgba-white-slight"></div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <!--Front Side-->
                                                    </div>
                                                </div>
                                                <!-- Rotating card -->
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="view-btn text-center mt-2 ">
                                        <div class="text-center">
                                            <a href="{{route('gallery.all')}}" class="button tn_load_more_btn button_view_all mt-0">View All</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
    @endif
@endsection

@section('footer')
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js " integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB " crossorigin="anonymous "></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js " integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13 " crossorigin="anonymous "></script>
    <script src="//code.jquery.com/jquery-3.1.1.min.js"></script> --}}

    <script type="text/javascript" src="{{asset('back/js/app.js')}}"></script>
    <script src="{{asset('front/assets/js/owl.carousel.min.js')}}"></script>

    <script>
        // Slider
        var slideIndex = 1;
        var slider_timeout;
        function currentSlide(n) {
            slideIndex = n;
            showSlides();
        }
        showSlides();
        function showSlides() {
            clearTimeout(slider_timeout);
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (slideIndex > slides.length){
                slideIndex = 1;
            }
            if (slideIndex < 1) {
                slideIndex = slides.length;
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].classList.remove("active");
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].classList.add("active");
            dots[slideIndex-1].className += " active";
            slideIndex++;
            slider_timeout = setTimeout(showSlides, 5000);
        }
        var myNav = document.getElementById('nav_id');
        window.onscroll = function () {
            if (document.body.scrollTop >= 100 || document.documentElement.scrollTop >=100) {
                myNav.classList.add("nav-colored");
                myNav.classList.remove("nav-transparent");
            }
            else {
                myNav.classList.add("nav-transparent");
                myNav.classList.remove("nav-colored");
            }
        };


        $(".upcoming_events_items").owlCarousel({
            loop: true,
            margin: 30,
            autoplay: true,
            autoplayHoverPause: true,
            responsiveClass: true,
            nav: true,
            slideBy: 3,
            responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 1,
                nav: true
            },
            1000: {
                items: 2,
                nav: true,
            }
            }
        });
    </script>
@endsection


