@extends('layouts.index')

@section('title', 'AlgebraBox | The greatest cloud storage')

@section('content')
<div class="row">
  <ol class="breadcrumb">
    <li class="active">Home</li>
  </ol>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="list-group">
			<a href="#" class="list-group-item list-group-item-info" data-toggle="modal" data-target="#createDir">Create New Directory</a>
			<a href="#" class="list-group-item list-group-item-info">Upload Files</a>
		</div>
	</div>
	<div class="col-md-9">
		<table class="table table-hover">
			<tr>
				<th>Name</th>
				<th>Action</th>
			</tr>
			@if($directories)
				@foreach($directories as $directory)
				<tr>
					<td>
						<a href="{{ route('home.directories', str_replace('/', '', strstr($directory, '/'))) }}"><b>
						<span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> &nbsp; 
						{{ ucfirst(str_replace('/', '', strstr($directory, '/'))) }}</b></a>
					</td>
					<td></td>
				</tr>
				@endforeach
			@endif
			@if($files)
				@foreach($files as $file)
				<tr>
					<td>
						<a href="#">
						<span class="glyphicon glyphicon-file" aria-hidden="true"></span> &nbsp; 
						{{ ucfirst(str_replace('/', '', strstr($file, '/'))) }}</a>
					</td>
					<td></td>
				</tr>
				@endforeach
			@endif
		</table>
	</div>
</div>

<!-- Create directory modal-->
<div class="modal fade" id="createDir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form method="POST" action="{{ route('directory.create') }}">
			{{ csrf_field() }}
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Create New Directory</h4>
		  </div>
		  <div class="modal-body">
			<div class="form-group {{ ($errors->has('dir_name')) ? 'has-error' : '' }}">
				<label for="dir_name">Directory name</label>
				<input type="text" class="form-control" id="dir_name" name="dir_name" placeholder="Enter directory name">
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
@stop