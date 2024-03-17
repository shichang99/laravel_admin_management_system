<p>This is member page</p>

<p>Current user is {{ auth()->user()->name }}</p>

<form id="logout-form" action="{{ route('web.logout') }}" method="POST">
    @csrf
    <input type="submit" value="Logout">
</form>

<!-- Example data in foreach -->
@foreach ( $data['my_data'] as $md )
<p>{{ $md }}</p>
@endforeach

<!-- Example Language -->
<div>{{ __( 'ms.home_1' ) }}</div>

<!-- Switch Language -->
<div>
    <a href="{{ Helper::baseUrl() }}/lang/en">English</a>
    <a href="{{ Helper::baseUrl() }}/lang/zh">中文</a>
</div>