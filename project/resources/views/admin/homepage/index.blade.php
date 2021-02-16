@extends('layouts.admin')

@section('styles')
  <link href="{{asset('assets/admin/drofify/css/drofify.demo.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/admin/drofify/css/drofify.min.css')}}" rel="stylesheet" />
@endsection

@section('scripts')
  <script src="{{asset('assets/admin/drofify/js/drofify.min.js')}}"></script>
  <script src="{{asset('assets/admin/drofify/js/more.js')}}"></script>
@endsection

@section('content')  
          <input type="hidden" id="headerdata" value="BANNER">
          <div class="content-area">
            <div class="mr-breadcrumb">
              <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">Change Home Page Content</h4>
                    <ul class="links">
                      <li>
                        <a href="{{ route('admin.dashboard') }}">Dashboard </a>
                      </li>
                      <li>
                        <a href="javascript:;">Home Page Settings</a>
                      </li>
                      <li>
                        <a href="{{ route('admin-featuredbanner-index') }}">Home Page Content</a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
            <div class="product-area">
              <div class="row">
                @php
                  $get_shopping=array_search('shopping', array_column($metas->toArray(), 'meta_name'));
                  $get_merchant=array_search('merchant', array_column($metas->toArray(), 'meta_name'));
                  $get_reseller=array_search('reseller', array_column($metas->toArray(), 'meta_name'));
              
                @endphp
                <div class="col-lg-12">
                  <div class="card-group">
                    <div class="card">
                      <img src="{{ asset('assets/admin/meta/'.$metas[$get_shopping]['meta_value']) }}" class="card-img-top" alt="{{$metas[$get_shopping]['meta_title']}}" style="min-height: 200px; max-width: 300px">
                      <div class="card-body">
                        <h4 class="card-title">{{$metas[$get_shopping]['meta_title']}}</h4>
                        <p class="card-text text-justify">{{$metas[$get_shopping]['meta_content']}}</p>
                      </div>
                      <div class="card-footer">
                       <span class="text-danger" data-toggle="modal" data-target="#shopping"><i class="fas fa-edit"></i></span>
                      </div>
                    </div>
                    <div class="card">
                      <img src="{{ asset('assets/admin/meta/'.$metas[$get_merchant]['meta_value']) }}" class="card-img-top" alt="{{$metas[$get_merchant]['meta_title']}}" style="min-height: 200px; max-width: 300px">
                      <div class="card-body">
                        <h4 class="card-title">{{$metas[$get_merchant]['meta_title']}}</h4>
                        <p class="card-text text-justify">{{$metas[$get_merchant]['meta_content']}}</p>
                      </div>
                      <div class="card-footer">
                          <span class="text-danger" data-toggle="modal" data-target="#merchantModal"><i class="fas fa-edit"></i></span>
                      </div>
                    </div>
                    <div class="card">
                     <img src="{{ asset('assets/admin/meta/'.$metas[$get_reseller]['meta_value']) }}" class="card-img-top" alt="{{$metas[$get_reseller]['meta_title']}}" style="min-height: 200px; max-width: 300px">
                     <div class="card-body">
                       <h4 class="card-title">{{$metas[$get_reseller]['meta_title']}}</h4>
                       <p class="card-text text-justify">{{$metas[$get_reseller]['meta_content']}}</p>
                     </div>
                     <div class="card-footer">
                         <span class="text-danger" data-toggle="modal" data-target="#resellarModal"><i class="fas fa-edit"></i></span>
                     </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

{{-- ADD / EDIT MODAL --}}

    <div class="modal fade" id="shopping" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">             
      <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="submit-loader">
              <img  src="{{asset('assets/images/rasel/loader.gif')}}" alt="">
          </div>
        <div class="modal-header">
        <h4 class="modal-title">Change Shopping Content</h4>
        
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.change.shopping',$metas[$get_shopping]['id']) }}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                          <h4 class="heading">Image</h4>
                      </div>
                    </div>
                    <div class="col-lg-8">
                     <input type="file" id="input-file-now" class="dropify" data-default-file="{{ asset('assets/admin/meta/'.$metas[$get_shopping]['meta_value']) }}" name="meta_value" />
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                          <h4 class="heading">Title</h4>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <input type="text" class="input-field" name="meta_title" value="{{$metas[$get_shopping]['meta_title']}}" required="">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                          <h4 class="heading">Content</h4>
                      </div>
                    </div>
                    <div class="col-lg-8">
                    <textarea class="input-field" rows="5" cols="60" required="" name="meta_content">{{$metas[$get_shopping]['meta_content']}}</textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                      </div>
                    </div>
                    <div class="col-lg-8">
                     <input type="submit" name="" value="Change" class="btn btn-secondary">
                    </div>
                  </div>

                </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>
</div>


{{-- ADD / EDIT MODAL --}}

    <div class="modal fade" id="merchantModal" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">             
      <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="submit-loader">
              <img  src="{{asset('assets/images/rasel/loader.gif')}}" alt="">
          </div>
        <div class="modal-header">
        <h4 class="modal-title">Change Shopping Content</h4>
        
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.change.merchant',$metas[$get_merchant]['id']) }}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                          <h4 class="heading">Image</h4>
                      </div>
                    </div>
                    <div class="col-lg-8">
                     <input type="file" id="input-file-now" class="dropify" data-default-file="{{ asset('assets/admin/meta/'.$metas[$get_merchant]['meta_value']) }}" name="meta_value" />
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                          <h4 class="heading">Title</h4>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <input type="text" class="input-field" name="meta_title" value="{{$metas[$get_merchant]['meta_title']}}" required="">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                          <h4 class="heading">Content</h4>
                      </div>
                    </div>
                    <div class="col-lg-8">
                    <textarea class="input-field" rows="5" cols="60" required="" name="meta_content">{{$metas[$get_merchant]['meta_content']}}</textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                      </div>
                    </div>
                    <div class="col-lg-8">
                     <input type="submit" name="" value="Change" class="btn btn-secondary">
                    </div>
                  </div>

                </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>
</div>

{{-- ADD / EDIT MODAL --}}

    <div class="modal fade" id="resellarModal" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">             
      <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="submit-loader">
              <img  src="{{asset('assets/images/rasel/loader.gif')}}" alt="">
          </div>
        <div class="modal-header">
        <h4 class="modal-title">Change Shopping Content</h4>
        
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.change.reseller',$metas[$get_reseller]['id']) }}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                          <h4 class="heading">Image</h4>
                      </div>
                    </div>
                    <div class="col-lg-8">
                     <input type="file" id="input-file-now" class="dropify" data-default-file="{{ asset('assets/admin/meta/'.$metas[$get_reseller]['meta_value']) }}" name="meta_value" />
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                          <h4 class="heading">Title</h4>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <input type="text" class="input-field" name="meta_title" value="{{$metas[$get_reseller]['meta_title']}}" required="">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                          <h4 class="heading">Content</h4>
                      </div>
                    </div>
                    <div class="col-lg-8">
                    <textarea class="input-field" rows="5" cols="60" required="" name="meta_content">{{$metas[$get_reseller]['meta_content']}}</textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="left-area">
                      </div>
                    </div>
                    <div class="col-lg-8">
                     <input type="submit" name="" value="Change" class="btn btn-secondary">
                    </div>
                  </div>

                </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>
</div>


{{-- DELETE MODAL ENDS --}}

@endsection    

@section('scripts')

@endsection   