@extends('layouts.master') @section('master.content')

<div class="row">
	<div class="row-same-height">
		<div class="col-xs-10 col-xs-height">
			<h1>{{ Lang::get('strip.pendingTitle')}}</h1>
		</div>
		<div class="col-xs-2 col-xs-height col-bottom">
			<a href="{{URL::route('strip.create', [$comic_id])}}"
				title="strip.add"
				class='btn btn-sm btn-primary glyphicon glyphicon-plus'></a>
		</div>
	</div>
</div>
<br />
@if(Session::has('message'))
<p class="alert alert-info">{{ Session::get('message') }}</p>
@endif @if(empty($strips))
<!--TODO -->

@else
<div class="row">
	@foreach ($strips as $strip)
	<div class="col-sm-6 col-lg-4 padding-10">
		<div class="border thumbnail padding-10">
			<div class="caption">
				<h3 class="one-line">
					<a
						href="{{ route('strip.show',[ $strip->comic->id, $strip->id]) }}">{{
						($strip->title)? $strip->title : $strip->comic." ".$strip->id }}</a>
				</h3>
			</div>
			<a href="{{ route('strip.show',[ $strip->comic->id, $strip->id]) }}">{{
				HTML::image($strip->path, 'strip', ['class' => 'img-responsive
				img-rounded', 'style' => 'overflow:hidden; width:250px;
				height:250px; display:block; margin:0 auto;']) }}</a>

			<div class="caption">
				{{ Form::open(['method' => 'put', 'class'=>'form-horizontal', 'id'
				=> 'stripForm'.$strip->id]); }} {{ Form::hidden('_method', 'put',
				['id' => '_method']); }} {{ Form::hidden('id', $strip->id, ['id' =>
				$strip->id]); }}
				<!-- Small button group -->
				<div class="btn-group">
					<button class="btn btn-default btn-sm dropdown-toggle"
						type="button" data-toggle="dropdown" aria-expanded="false">
						Action <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a
							href="{{URL::route('strip.clean', [$strip->comic->id, $strip->id])}}">
								@lang('strip.pendingClean')</a></li>
						<li><a
							href="{{URL::route('strip.translate', [$strip->comic->id, $strip->id])}}">
								@lang('strip.pendingTranslate')</a></li>
						<li class="divider"></li>
						<!--<li><a href="" onclick="$('#stripForm{{ $strip->id }}').submit(); return false;"> @lang('strip.pendingApprobation') </a></li>-->
						<li><a href=""
							onclick="$('#_method').val('DELETE'); $('#stripForm{{$strip->id}}').attr('action', '{{ URL::route('strip.destroy', [$strip->comic->id, $strip->id]) }}'); $('#stripForm{{ $strip->id }}').submit(); return false;">
								@lang('base.delete') </a></li>
						<li><a
							href="{{URL::route('strip.edit', [$strip->comic->id, $strip->id])}}"
							title="@lang('strip.editLink')">@lang('strip.editLink')</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	@endforeach
</div>
@endif @stop