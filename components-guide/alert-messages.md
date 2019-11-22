### Alert messages

1. **View**: *messages.blade.php*

```html
@if(count($errors) > 0)
	<ul class="alert alert-danger alert-dismissible fade show">
		@foreach($errors->all() as $e)
			<li>{{$e}}</li>
		@endforeach
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</ul>
@endif

@if(session('success'))
	<div class="alert alert-success alert-dismissible fade show">
		{{session('success')}}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
@endif

@if(session('error'))
	<div class="alert alert-danger alert-dismissible fade show">
		{{session('error')}}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
@endif
```

2. **Resources/lang/** - copy the **en** file, change it to your language and in **validation.php** translate the messages

3. **Include** 

```php
@include('messages')
```

4. **Show message** - from the controller

```php
return back()->with('error', 'Error message');
```