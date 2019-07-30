@extends('student.layouts.frontend.app')

@section('title','All Question')

@push('css')
    <link href="{{ asset('assets/frontend/css/home/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/frontend/css/home/responsive.css') }}" rel="stylesheet">
    <style>
        .favorite_posts{
            color: blue;
        }
    </style>
@endpush

@section('content')
<div class="main-slider">
        <div class="swiper-container position-static" data-slide-effect="slide" data-autoheight="false"
             data-swiper-speed="500" data-swiper-autoplay="10000" data-swiper-margin="0" data-swiper-slides-per-view="4"
             data-swiper-breakpoints="true" data-swiper-loop="true" >
            <div class="swiper-wrapper">

               @foreach($tags as $tag)
                    <div class="swiper-slide">
                        <a class="slider-tag" href="{{ route('student.view.question',$tag->slug) }}">
                            <div class="blog-image"><img src="{{asset('images/tag/'.$tag->image)}}" alt="{{ $tag->name }}"></div>

                            <div class="category">
                                <div class="display-table center-text">
                                    <div class="display-table-cell">
                                        <h3><b>{{ $tag->name }}</b></h3>
                                    </div>
                                </div>
                            </div>

                        </a>
                    </div><!-- swiper-slide -->
                @endforeach

            </div><!-- swiper-wrapper -->

        </div><!-- swiper-container -->

    </div><!-- slider -->   
   
 <div class="container mt-2">
        <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
             <form class="form-inline" action="{{ route('question.search') }}" method="get">
                    <div class="md-form my-0 mr-auto">
                        <input class="form-control mr-sm-2" name="search" type="text" placeholder="Search your favorite topics" aria-label="Search">
<!--                <button class="src-btn" type="submit"><i class="ion-ios-search-strong"></i></button>-->
                    </div>
                </form>
        </div>
    </div>
</div>

    <section class="blog-area section">
        <div class="container">

            <div class="row">

                @foreach($questions as $question)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                @foreach($question->tags as $key=>$tag)
                                @if ($loop->first)
                                <div class="blog-image"><img src="{{asset('images/tag/'.$tag->image)}}" alt="{{ $question->title }}"></div>
                                @endif
                                @endforeach
                                <a class="avatar" href=""><img src="{{asset('images/profile/'.\App\Models\User::where('id',$tag->user_id)->first()->image)}}" alt="Profile Image"></a>

                                <div class="blog-info">

<!--                                    <h4 class="title"><a href="{{ route('student.question_details',$question->slug) }}"><b>{{ $question->title }}</b></a></h4>-->
                                   
                                   
                                    @foreach($tags as $tag)
                                    <h5>
                                        @foreach($question->tags as $questionTag )
                                        {{ $questionTag->id == $tag->id ? '' :'' }}
                                        @endforeach
                                    </h5>
                                    @endforeach
                                    <h3> <a href="{{ route('student.question_details',$question->slug) }}"><b>{{ $questionTag->name }}</b></a></h3>
                                    <h4><a href="{{ route('student.question_details',$question->slug) }}"> {{ $question->course_code }}</a></h4>
                                    <a href="{{ route('student.question_details',$question->slug) }}"> {{ $question->passing_year }}</a>
                                    <h5 class="title"><small>post by </small><a href="{{ route('student.question_details',$question->slug) }}"> <span class="bagge bg-blue">{{ $question->user->name }}</span></a></h5>

                                    <ul class="post-footer">

                                       <li>
                                           <a href=""><i class="ion-heart"></i></a>

                                                
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-chatbubble"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-eye"></i>{{ $question->view_count }}</a>
                                        </li>
                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                @endforeach

            </div><!-- row -->

            
            {{ $questions->links() }}
<!--            <a class="load-more-btn" href="#"><b>LOAD MORE</b></a>-->

        </div><!-- container -->
    </section><!-- section -->
@endsection

@push('js')

@endpush