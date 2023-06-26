@extends('admin.layouts.header')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-book"></i> Edit Book</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
              <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
              <li class="breadcrumb-item"><a href="{{ route('books') }}">View Books</a></li>
            </ul>
        </div>

        <section class="editbook">
            <div class="tile">
                <div class="tile-body">
                    <div class="row cont_bg">
                    <!--<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">-->

                    <!--<img  class=" img-anim w-80" src="Assets/images/edit-amination.gif">-->

                    <!--</div>-->
                        @php  $bookid = Crypt::encrypt($book->id);   @endphp
                        <div class="col-md-4 col-4 mt-4">
                            <div class="icon-box text-center">
                                <a href="{{route('chapters', $bookid)}}" class="cst-cta-btn">
                                    <span><img src="{{ URL::asset('assets/images/chapter.png') }}" alt="" class="img-fluid i-wdth-20"></span>
                                    <h5>Add chapters</h5>
                                </a>
                            </div>
                        </div>
                        <!-- <div class="col-md-3 col-3 mt-3">
                            <div class="icon-box text-center">
                                <a href="{{route('audio-add', $bookid)}}" class="cst-cta-btn">
                                    <span><img src="{{ URL::asset('assets/images/audio-book.png') }}" alt="" class="img-fluid i-wdth-20"></span>
                                    <h5>Add Audio</h5>
                                </a>
                            </div>
                        </div> -->
                        <div class="col-md-4 col-4 mt-4">
                            <div class="icon-box text-center">

                                <a href="{{route('video-add', $bookid)}}" class="cst-cta-btn">
                                    <span><img src="{{ URL::asset('assets/images/video-tutorials.png') }}" alt="" class="img-fluid i-wdth-20"></span>
                                    <h5>Add Video</h5>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 col-4 mt-4">
                            <div class="icon-box text-center">
                                <a href="{{route('quizs', $bookid)}}" class="cst-cta-btn">
                                    <span><img src="{{ URL::asset('assets/images/quiz.png') }}" alt="" class="img-fluid i-wdth-20"></span>
                                    <h5>Add Quiz</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- inner section start -->

         @if($message = Session::get('success'))
             <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
               <strong>Success!</strong> {{ $message }}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close" >
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
         @endif

         @if($message = Session::get('error'))
              <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
               <strong>Error!</strong> {{ $message }}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close" >
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
         @endif

        <section class="book-form">
            <!-- tile inner space -->
            <div class="tile">
                <div class="tile-body">
                    <div id="app_content" class="app-container">
                        <!-- add book form start-->
                        
                        <form class="w-100" id="addbook-form" method="POST" action="{{route('book-update')}}" enctype="multipart/form-data">
                          @csrf
                            <!-- form row start at lower div -->
                            <div class=" cst-add-new-form row">
                                <!-- field col  start -->
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-head" for="exampletext">
                                            Book Title
                                        </label>
                                        <input class="form-control  @error('title') is-invalid @enderror" name="title" id="title" type="text" value="@if(!empty($book->title)){{old('title', $book->title)}}@endif" placeholder="Enter Book title"> 
                              
                                          @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                          @enderror
                                    </div>
                                </div>
                                <!-- field col end -->
                                <!-- field col  start -->
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-head" for="exampletext">
                                            Book Category
                                        </label>
                                        <div class="select-group h-40">
                                            <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                               <option label="Select Category" ></option>
                                                @if(count($categories) > 0)
                                                   @foreach($categories as $category)
                                                     @if ($category->id ==  $book->category )
                                                         <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                                     @else
                                                         <option value="{{ $category->id }}" >{{$category->name}}</option>
                                                     @endif
                                                   @endforeach
                                                @endif
                                             </select>
                                             @error('category')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                             @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- field col end -->
                            </div>
                            <!--field row for three column-->
                            <div class=" cst-add-new-form row">

                                 <!-- field col  start -->
                                 <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-head" for="exampletext">
                                            Author
                                        </label>
                                        <div class="select-group h-40">
                                            <select name="author" id="author" class="form-control @error('author') is-invalid @enderror">
                                               <option label="Select author"></option>
                                                @if(count($authors) > 0)
                                                   @foreach($authors as $author)
                                                     @if ($author->id ==  $book->author_name )
                                                         <option value="{{ $author->id }}" selected>{{ $author->name }}</option>
                                                     @else
                                                         <option value="{{ $author->id }}" >{{$author->name}}</option>
                                                     @endif
                                                   @endforeach
                                                @endif
                                             </select>
                                             @error('author')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                             @enderror
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- field col end --> 

                                <!-- field col start -->
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-head" for="exampletext">
                                            English fluency
                                        </label>
                                        <div class="select-group h-40">
                                            <select name="english_fluency" id="english_fluency" class="form-control @error('english_fluency') is-invalid @enderror">
                                               <option label="Select english_fluency"></option>
                                                @if(count($english_fluencys) > 0)
                                                   @foreach($english_fluencys as $english_fluency)
                                                     @if ($english_fluency->id ==  $book->english_fluency )
                                                         <option value="{{ $english_fluency->id }}" selected>{{ $english_fluency->name }}</option>
                                                     @else
                                                         <option value="{{ $english_fluency->id }}" >{{$english_fluency->name}}</option>
                                                     @endif
                                                   @endforeach
                                                @endif
                                             </select>
                                             @error('english_fluency')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                             @enderror
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- field col end -->

                                <!-- field col start -->
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-head" for="exampletext">
                                            English Accent
                                        </label>
                                        <div class="select-group h-40">
                                            <select name="english_accent" id="english_accent" class="form-control @error('english_accent') is-invalid @enderror">
                                               <option label="Select Accent"></option>
                                                @if(count($english_accents) > 0)
                                                   @foreach($english_accents as $english_accent)
                                                     @if ($english_accent->id ==  $book->english_accent )
                                                         <option value="{{ $english_accent->id }}" selected>{{ $english_accent->name }}</option>
                                                     @else
                                                         <option value="{{ $english_accent->id }}" >{{$english_accent->name}}</option>
                                                     @endif
                                                   @endforeach
                                                @endif
                                             </select>
                                              @error('english_accent')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                             @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- field col end -->

                                <!-- field col start -->
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-head" for="exampletext">
                                            Home Category
                                        </label>
                                        <div class="select-group h-40">
                                            <select name="home_category" id="home_category" class="form-control @error('home_category') is-invalid @enderror">
                                               <option label="Select Accent"></option>
                                                @if(count($home_categories) > 0)
                                                   @foreach($home_categories as $home_category)
                                                     @if ($home_category->id ==  $book->home_category )
                                                         <option value="{{ $home_category->id }}" selected>{{ $home_category->name }}</option>
                                                     @else
                                                         <option value="{{ $home_category->id }}" >{{$home_category->name}}</option>
                                                     @endif
                                                   @endforeach
                                                @endif
                                             </select>
                                              @error('home_category')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                             @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- field col end -->
                            </div>

                            <!-- form row end -->
                            <!-- form second row for word , level , genre , time , fluency field -->
                            <div class=" cst-add-new-form row">
                                <!-- 2nd form field -->
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-head" for="examplenumber">
                                            Total words
                                        </label>
                                        <input class="form-control  @error('total_words') is-invalid @enderror" name="total_words" min="0" value="@if(!empty($book->total_words)){{old('total_words', $book->total_words)}}@endif" id="total_words" type="number"  placeholder="Total Words Of Book"> 
                              
                                          @error('total_words')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                          @enderror
                                    </div>
                                </div>
                                <!-- end 2nd form field -->
                                <!-- 2nd form field -->
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                    <!--  2nd form field -->
                                    <div class="form-group">
                                        <label class="form-head" for="exampletext">
                                            Genre
                                        </label>
                                        <div class="select-group h-40">
                                            <select name="genre" id="genre" class="form-control @error('genre') is-invalid @enderror">
                                               <option label="Select genre"></option>
                                                @if(count($genres) > 0)
                                                   @foreach($genres as $genre)
                                                     @if ($genre->id ==  $book->genre )
                                                         <option value="{{ $genre->id }}" selected>{{ $genre->name }}</option>
                                                     @else
                                                         <option value="{{ $genre->id }}" >{{$genre->name}}</option>
                                                     @endif
                                                   @endforeach
                                                @endif
                                             </select>
                                             @error('genre')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                             @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- end 2nd form field -->
                                <!-- 2nd form field -->
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-head" for="exampletext">
                                            Total Time In Minutes
                                        </label>
                                        <input class="form-control  @error('total_time') is-invalid @enderror" name="total_time" value="@if(!empty($book->total_time)){{old('total_time', $book->total_time)}}@endif" id="total_time" min="0" type="number"  placeholder="Total Read Time"> 
                              
                                          @error('total_time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                          @enderror
                                    </div>
                                </div>
                                <!-- end 2nd form field -->
                                <!-- 2nd form field -->
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-head" for="exampletext">
                                            Level
                                        </label>
                                        <div class="select-group h-40">
                                            
                                            <select name="level" id="level" class="form-control @error('level') is-invalid @enderror">
                                               <option label="Select level"></option>
                                                @if(count($levels) > 0)
                                                   @foreach($levels as $level)
                                                     @if ($level->id ==  $book->level )
                                                         <option value="{{ $level->id }}" selected>{{ $level->name }}</option>
                                                     @else
                                                         <option value="{{ $level->id }}" >{{$level->name}}</option>
                                                     @endif
                                                   @endforeach
                                                @endif
                                             </select>
                                             @error('level')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                             @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- end 2nd form field -->
                            </div>
                            <!-- form second row end  -->
                            <!-- form third row sart -->
                            <div class=" cst-add-new-form row">
                                <!-- field col  start :: dropify-->
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-head" for="exampletext">
                                            Book Thumbnails
                                        </label>
                                        <input name="document" type="file" data-default-file="{{ URL::asset('/public/'.$book->book_thumbnail) }}" class="dropify @error('document') is-invalid @enderror" data-height="100" data-allowed-file-extensions="jpeg jpg png"/>
                                        @error('document')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                         @enderror
                                    </div>
                                    @error('document')
                                        <p style="color:#dc3545; font-size: 80%;" ><strong>{{ $message }}</strong></p>
                                    @enderror
                                </div>
                                <!-- field col  start :: dropify-->
                                <!-- mce :: text editor  -->
                                <div class="col-lg-9 col-sm-9col-md-9 col-xs-12 px-0 py-0">
                                    <div class="form-group">
                                        <label class="form-head" for="exampletext">
                                            Book Description
                                        </label>
                                        <textarea id="myTextarea" class="@error('content') is-invalid @enderror" name="content" >@if(!empty($book->book_description)){{old('book_description', $book->book_description)}}@endif</textarea>
                                        @error('content')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                         @enderror
                                    </div>
                                    @error('content')
                                        <p style="color:#dc3545; font-size: 80%;" ><strong>{{ $message }}</strong></p>
                                    @enderror
                                </div>
                                <!-- mce :: end text editor  -->
                            </div>
                            <!-- form third row End -->
                            
                             <div class="cst-add-new-form row">
                                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="showbookto" id="inlineRadio1" value="all_users" @php if($book->showbookto == 'all_users'){ echo 'checked'; }  @endphp>
                                            <label class="form-check-label form-head" for="inlineRadio1"> All Member</label>
                                        </div>
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="showbookto" id="inlineRadio2" value="paid_users" @php if($book->showbookto == 'paid_users'){ echo 'checked'; }  @endphp>
                                            <label class="form-check-label form-head" for="inlineRadio2"> Paid Member</label>
                                        </div>
                                         @error('showbookto')
                                        <p style="color:#dc3545; font-size: 80%;" ><strong>{{ $message }}</strong></p>
                                    @enderror
                                    </div>
                                </div>
                                <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
                                    <!--toggle for status-->
                                    <div class="form-group">
                                        <div class="toggle">
                                          <label>
                                            <input type="checkbox" name="status" @php if($book->status == 'active'){ echo 'checked'; }  @endphp ><span class="button-indecator" ><span>Please select the status of the book (Active/inactive)</span>
                                           </span></label>
                                        </div>
                                    </div>
                                    <!--toggle status end-->

                                </div>
                            </div>

                            <!--toggle for status-->
                            
                            <!--toggle status end-->
                            <input type="hidden" name="document_old" value="{{$book->book_thumbnail}}">
                            <input type="hidden" name="bookid" value="{{$book->id}}">
                            <!-- :: submit button -->
                            <div class="form-group terms mt-2 mb-2">
                                <input type="submit" class="btn btn-info w-100" id=""></input>
                            </div>
                            <!-- :: end submit button -->
                        </form>
                        <!-- add book form up end -->
                    </div>
                </div>
            </div>
            <!-- tile inner space up end -->
        </section>
    </main>
   

@endsection
@section('scripts') 

<script src="https://cdn.tiny.cloud/1/l0xp8n0asjxeoofeo9h30icll510jblob20r38r92ecoyw00/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea#myTextarea'
  });
</script>

<!-- <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-webcomponent@2/dist/tinymce-webcomponent.min.js"></script> -->
<script src="{{ URL::asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/wooenglish_assets_js_dropify.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/pace.min.js') }}"></script>
<script>
    $('.dropify').dropify();
</script>
@endsection