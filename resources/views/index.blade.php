@extends('app')
@section('APP-CONTENT')
    <div class="row">
        {{-- <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="hopeUICarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#hopeUICarousel" data-bs-slide-to="0"
                                class="active"></button>
                            <button type="button" data-bs-target="#hopeUICarousel" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#hopeUICarousel" data-bs-slide-to="2"></button>
                        </div>

                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://ncr.bfp.gov.ph/wp-content/uploads/slider/cache/196addee76de6708aef257fcbd2231cf/FPM-2025.png"
                                    class="d-block w-100" alt="Slide 1">
                            </div>
                            <div class="carousel-item">
                                <img src="https://ncr.bfp.gov.ph/wp-content/uploads/slider/cache/16aaf8c1912e86496539d63502cff535/ncr-website-hero.png"
                                    class="d-block w-100" alt="Slide 2">
                            </div>
                            <div class="carousel-item">
                                <img src="https://ncr.bfp.gov.ph/wp-content/uploads/slider/cache/9d95267d436329b079ba5e24a62bc760/Planning-implementation-and-management-if-uct-system.png"
                                    class="d-block w-100" alt="Slide 3">
                            </div>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#hopeUICarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#hopeUICarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="user-post">
                        <a href="{{ asset('img/fsic.png') }}" data-fslightbox="fsic-gallery" data-type="image">
                            <img src="{{ asset('img/fsic.png') }}" alt="post-image" class="img-fluid">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
