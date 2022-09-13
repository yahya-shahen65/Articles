@extends('layouts.master')
@section('css')
<!-- Interenal Accordion Css -->
<link href="{{URL::asset('assets/plugins/accordion/accordion.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Main</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Articles</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row opened -->
				<div class="row">
                    <div class="col-xl-12">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" >
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if (session()->has('add'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('add') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if (session()->has('not_allow'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('not_allow') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if (session()->has('edit'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('edit') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if (session()->has('delete'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('delete') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">the authors</h3>
                            </div>
                            <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20 mg-md-t-0">
                                <a class="modal-effect btn btn-primary" data-effect="effect-slide-in-bottom" data-toggle="modal" href="#modaldemo8">Add articles</a>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="card-body">
                                    @foreach ($users as $user)
                                    <?php $i=0 ?>
                                    <div id="accordion" class="w-100 br-2 overflow-hidden">
                                        <div class="">
                                            <div class="accor  bg-primary" id="headingThree3">
                                                <h4 class="m-0">
                                                    <a href="#collapseThree{{$user->id}}" class="collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="collapseThree">
                                                        {{$user->name . " " .$user->last_name}}<i class="si si-cursor-move ml-2"></i>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseThree{{$user->id}}" class="collapse b-b0 bg-white" aria-labelledby="headingThree" data-parent="#accordion">
                                                <div class="border p-3">
                                                    <table class="table mb-0 table-bordered border-top mb-0">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>title</th>
                                                            <th>body</th>
                                                            <th>image</th>
                                                            <th>date of creation</th>
                                                            <th>proccess</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($user->articles as $article)
                                                            <tr>
                                                                <td>{{++$i}}</td>
                                                                <td>{{$article->title}}</td>
                                                                <td>{{$article->body}}</td>
                                                                @if ($article->image)
                                                                <td><img src="{{URL::asset("$article->user_id/$article->title/$article->image")}}" alt="image"></td>
                                                                @else
                                                                <td>not uploded</td>
                                                                @endif
                                                                <td>{{$article->created_at->diffForHumans()}}</td>
                                                                <td>
                                                                    <a class="btn btn-sm btn-primary" href="{{route('articles.show',$article->id)}}" title="Show"><i class="icon ion-md-eye"></i></a>
                                                                    <a class="modal-effect btn btn-sm btn-info" data-effect="effect-slide-in-bottom" title="edit" data-toggle="modal" href="#modaldemo7{{$article->id}}"  title="edit"><i class="las la-pen"></i></a>
                                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-slide-in-bottom" title="delet" data-toggle="modal" href="#modaldemo9{{$article->id}}"><i class="las la-trash"></i></a>
                                                                </td>
                                                            </tr>
                                                            <div class="modal" id="modaldemo7{{$article->id}}">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content modal-content-demo">
                                                                        <div class="modal-header">
                                                                            <h6 class="modal-title">Edit article</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{route('articles.update','test')}}" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <div class="form-group">
                                                                                    <input id="id" type="hidden" name="id" class="form-control"
                                                                                        value="{{ $article->id }}">
                                                                                    <input id="img" type="hidden" name="img" class="form-control"
                                                                                        value="{{ $article->image }}">
                                                                                    <input type="text" class="form-control" id="inputName1" name="title" value={{$article->title}} placeholder="title">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" id="inputName2" value={{$article->body}} name="body" placeholder="body">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" id="inputName4" value={{$article->description}} name="description" placeholder="description">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <input type="file" class="form-control" id="inputName3" name="image" placeholder="image">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button class="btn ripple btn-primary" type="submit">Save changes</button>
                                                                                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal" id="modaldemo9{{$article->id}}">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                                id="exampleModalLabel">
                                                                                Delete article
                                                                            </h5>
                                                                            <button type="button" class="close" data-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('articles.destroy', 'test') }}" method="post">
                                                                                {{ method_field('Delete') }}
                                                                                @csrf
                                                                                Are you sure to delete ?
                                                                                <input id="id" type="hidden" name="id" class="form-control"
                                                                                    value="{{ $article->id }}">
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary"
                                                                                        data-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger">submit</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- row closed -->
                    <div class="modal" id="modaldemo8">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">Add new article</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" action={{route('articles.store')}} method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="inputName1" name="title" placeholder="title">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="inputName2" name="body" placeholder="body">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="inputName4" name="description" placeholder="description">
                                        </div>
                                        <div class="form-group">
                                                <input value="{{Auth::user()->id}}" type="hidden" name="user_id">
                                        </div>
                                        <div class="form-group">
                                            <input type="file" class="form-control" id="inputName3" accept="image/*" name="image">
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn ripple btn-primary" type="submit">Save changes</button>
                                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container closed -->
            </div>
            <!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--- Internal Accordion Js -->
<script src="{{URL::asset('assets/plugins/accordion/accordion.min.js')}}"></script>
<script src="{{URL::asset('assets/js/accordion.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endsection
