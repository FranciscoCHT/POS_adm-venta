@extends('layouts.admin')

@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Importar productos mediante Excel
			</h3>
		</div>

		<div class="">
			<form action="{{ url('local/estadistica/im')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
						<label for="file">Excel</label>
						<input type="file" name="file"  class="form-control" >
					</div>
				</div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Cargar</button>
					</div>
				</div>
			</form>
		<div>
		
	</div>

	<div>
		
	</div>

@endsection