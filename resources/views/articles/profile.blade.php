@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{$user->name . " " . $user->last_name}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ MY Articles</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                <div class="row row-sm">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body h-100">
                                <div class="row row-sm ">
                                    <div class="details col-xl-7 col-lg-12 col-md-12 mt-4 mt-xl-0">
                                        <h4 class="product-title mb-1">Account owner is {{$user->name . " " . $user->last_name}}</h4>
                                        <p class="text-muted tx-13 mb-1">Eamil is {{$user->email}}</p>
                                        <br>
                                        <h6 class="price">Address is {{$user->address}}</h6>
                                        <p>Date Of Birth is {{$user->date_of_birth}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                        @foreach ($user->articles as $article)
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body h-100">
                                    <div class="row row-sm ">
                                        <div class="details col-xl-7 col-lg-12 col-md-12 mt-4 mt-xl-0">
                                            <h4 class="product-title mb-1">{{$article->title}}</h4>
                                            <p class="text-muted tx-13 mb-1">{{$article->created_at->diffForHumans()}}</p>
                                            <br>
                                            <h6 class="price">{{$article->body}}</h6>
                                            <p>{{$article->description}}</p>
                                        </div>
                                        <div class=" col-xl-5 col-lg-12 col-md-12">
                                            <div class="preview-pic">
                                                @if ($article->image)
                                                    <div id="pic-{{Auth::user()->id}}"><img src="{{URL::asset("$article->user_id/$article->title/$article->image")}}" alt="image"/></div>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection
