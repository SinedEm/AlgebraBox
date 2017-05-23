@extends('layouts.index')

@section('title', 'AlgebraBox | The greatest cloud storage')

@section('content')

<div class="row">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @php
        $pathCreate = '';
		 $pathCreate1 = '';
        if($bc){
            $count = count($bc);
            for ($i=0; $i < $count ; ++$i) {
                $pathCreate .= $bc[$i].'/';
			}
            for ($i=0; $i < $count-1 ; ++$i) {
				$pathCreate1 .= $bc[$i].'/';
        @endphp
                <li class="breadcrumb-item"><a href="{{ route('home.directory.directories', $pathCreate1) }}">{{  $bc[$i] }}</a></li>

        @php
            }
        @endphp
            <li class="breadcrumb-item active">{{ $bc ? end($bc) : '' }}</li>
        @php
        }
        @endphp

  </ol>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="list-group">
			<a href="#" class="list-group-item list-group-item-info" data-toggle="modal" data-target="#createDir">Create New Directory</a>
			<a href="#" class="list-group-item list-group-item-info" data-toggle="modal" data-target="#upload">Upload Files</a>
		</div>
	</div>
	<div class="col-md-9">
		<table class="table table-hover">
			<tr>
				<th>Name</th>
				<th>Action</th>
			</tr>

            @if ($directories)
                @foreach ($directories as $directory)
                @php
                    $dir_array = explode('/', $directory);
                    $count = count($dir_array);
                    $path = '';
                    for ($i=1; $i < $count ; $i++) {
                        $path .= $dir_array[$i].'/';
                    }
                @endphp
                <tr>
                    <td>
                        <a href="{{ route('home.directory.directories', $path) }}"><b>
						<span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> &nbsp;
						{{ ucfirst(end($dir_array)) }}</b></a>
                    </td>
                    <td>
                        <a href="{{ route('directory.delete', $path) }}" role="button" class="btn btn-danger btn-small action_confirm" data-method="delete" data-token="{{ csrf_token() }}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                    </td>
                </tr>
                @endforeach
            @endif
            @if ($files)
                @foreach ($files as $file)
                <tr>
                    <td>
                        <a href="#"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> &nbsp;
                    	{{ ucfirst(str_replace('/', '', strstr($file, '/'))) }}</a>
                    </td>
                    <td>

                    </td>
                </tr>
                @endforeach
            @elseif (!($directories | $files))
                <tr>
                    <td>
                        <span class="align-middle"><b>Prazna mapa!</b></span>
                    </td>
                    <td>
                    </td>
                </tr>
            @endif

		</table>
	</div>
</div>

<!-- Create directory modal-->
<div class="modal fade" id="createDir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

		<form method="POST" action="{{ route('directory.directories.create', $pathCreate) }}">
			{{ csrf_field() }}
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Create New Directory {{ $pathCreate }}</h4>

		  </div>
		  <div class="modal-body">
			<div class="form-group {{ ($errors->has('dir_name')) ? 'has-error' : '' }}">
				<label for="dir_name">Directory name</label>

				<input type="text" class="form-control" id="dir_name" name="dir_name" placeholder="Enter directory name" required autofocus>

			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Create</button>
		  </div>
		</form>
    </div>
  </div>
</div>

<!-- Upload files modal-->
<div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form method="POST" action="{{ route('files.upload') }}" enctype="multipart/form-data">
			{{ csrf_field() }}
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Upload Files</h4>
		  </div>
		  <div class="modal-body">
			<div class="form-group {{ ($errors->has('dir_name')) ? 'has-error' : '' }}">
				<label for="files">Files</label>
				<input type="file" id="files" name="files[]" required multiple>

			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Upload</button>
		  </div>
		</form>
    </div>
  </div>
</div>
@stop