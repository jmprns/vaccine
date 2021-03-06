@extends('layouts.app')

{{-- HTML Title --}}
@section('html-title')

@endsection


{{-- VENDOR CSS --}}
@section('css-top')
<link href="{{asset('vendor/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('vendor/datatables/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- CUSTOM CSS --}}
@section('css-bot')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/croppie/croppie.css') }}">
@endsection

{{-- Page Title --}}
@section('page-title')
Non-Vaccinated Dogs in Brgy. {{ $brgy->name }}
@endsection

{{-- Bread Crumb --}}
@section('breadcrumb')
<li>
    Site
</li>
<li>
{{ $brgy->name }}
</li>
@endsection


{{-- Main Content --}}
@section('main-content')
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">
               Brgy. {{ $brgy->name }}
            </h4>
            <p class="text-muted font-13 m-b-30">
                
            </p>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="book-name"><strong>Select Barangay:</strong></label>
                            <select class="form-control brgy-select" name="owner" required onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                    <option value="/site/nvacc/0">See All</option>
                                @foreach($brgys as $brgy)
                                    <option value="/site/nvacc/{{ $brgy->id }}" @if($brgy->id == $bid) selected @endif>Brgy. {{ $brgy->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <table id="datatable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Purok</th>
                    <th>Owner's Name</th>
                    <th>Contact Number</th>
                    <th>Dogs's Name</th>
                    <th>Breed</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Color</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @php($x = 1)
                    @foreach($dogs as $dog)
                        <tr>
                            <td>{{ $x++ }}</td>
                            <td>{{ $dog->purok->name }}</td>
                            <td>{{ $dog->owner->name }}</td>
                            <td>{{ $dog->owner->cp }}</td>
                            <td>{{ $dog->name }}</td>
                            <td>{{ $dog->breed }}</td>
                            <td>{{ $dog->age }}</td>
                            <td>
                                @if($dog->gender == 1)
                                    Male
                                @else
                                    Female
                                @endif
                            </td>
                            <td>{{ $dog->color }}</td>
                            <td>
                                <a href="/site/edit/{{ $dog->id }}" class="btn btn-icon btn-xs waves-effect btn-warning m-b-5"> <i class="fa fa-pencil"></i> Edit</a>
                                <button onclick="deleteDog('{{ $dog->id }}')" class="btn btn-icon btn-xs waves-effect btn-danger m-b-5"> <i class="fa fa-trash-o"></i> Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Add Profile for Brgy. {{ $brgy->name }}</b></h4>
            <p class="text-muted font-13 m-b-30"></p>
            <div class="row">
                <div class="col-sm-6">
                    <form method="POST" action="/site">
                        <input type="hidden" name="brgy" value="{{ $brgy->id }}">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="book-name"><strong>Owner's Name:</strong></label>
                                <select class="form-control owner-select" name="owner" required>
                                    @foreach($owners as $owner)
                                        <option value="{{ $owner->id }}">{{ $owner->name }} - {{ $owner->purok->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="book-name"><strong>Dog Name:</strong></label>
                                <input type="text" class="form-control" id="book-name" placeholder="Dog's Name" name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="book-author"><strong>Breed:</strong></label>
                                <input type="text" class="form-control" id="book-author" placeholder="Breed" name="breed" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="book-name"><strong>Age:</strong></label>
                                <input type="number" class="form-control" id="book-name" placeholder="Age" name="age" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="book-author"><strong>Gender:</strong></label>
                                <select class="form-control" name="gender">
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="book-name"><strong>Vaccine Status</strong></label>
                                <select class="form-control" name="status" required>
                                    <option value="1">Vaccinated</option>
                                    <option value="2">Not Vaccinated</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="book-name"><strong>Color</strong></label>
                                <input type="text" class="form-control" id="book-name" placeholder="Color" name="color" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="book-name"><strong>Image</strong></label>
                                <input type="hidden" id="crop-image" value="" name="image">
                                <input type="file" name="upload_image" id="upload_image" accept="image/*" data-buttonbefore="true" class="filestyle">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-purple waves-effect waves-light">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Image Cropper -->
<div id="uploadimageModal" class="modal" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload & Crop Image</h4>
        </div>
        <div class="modal-body">
          <div class="row">
       <div class="col-md-12 text-center">
        <div id="image_demo"></div>
       </div>
    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success crop_image">Crop</button>
        </div>
     </div>
    </div>
</div><!-- /.modal -->

  <!-- DOG IMAGE Modal-->
  <div class="modal fade" id="modal-dog-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="text-center">
              <img id="dog-img" src="{{ asset('img/bg-pattern.png') }}" width="300px" height="300px" class="rounded" alt="...">
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection


{{-- VENDOR JS --}}
@section('js-top')
<script src="{{ asset('vendor/croppie/croppie.min.js') }}"></script>
<script src="{{ asset('vendor/croppie/exif.js') }}"></script>

<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap.js')}}"></script>
<script src="{{ asset('vendor/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/select2/js/select2.min.js') }}" type="text/javascript"></script>
@endsection

{{-- Js Script --}}
@section('js-bot')
<script type="text/javascript">
$(document).ready(function () {
    $('#datatable').dataTable();
    $(".select2").select2();
    $(".owner-select").select2();
    $(".brgy-select").select2();

    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width:150,
            height:150,
            type:'square' //circle
        },
        boundary:{
            width:300,
            height:300
        }
    });

    $('#upload_image').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event) {
        $image_crop.croppie('bind', {
            url: event.target.result
        }).then(function(){
          console.log('jQuery bind complete');
        });
        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal').modal('show');
    });

    $('.crop_image').click(function(event){
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport',
            format: 'jpeg'
        }).then(function(response){
            console.log(response);
            $('#crop-image').val(response);
            $('#uploadimageModal').modal('toggle');
        })
    });
});

function showImage(src){
  $("#dog-img").attr("src", '{{ asset('img/dogs') }}/'+src);
  $("#modal-dog-image").modal('show');
}

function deleteDog(id)
{
    swal({
        title: "Delete this dog profile?",
        text: "You will not be able to recover this information!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-warning',
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function () {
        window.location = '/site/delete/'+id;
    });
}
</script>
@endsection