
@include('layout.header', ['bodyclass' => $bodyclass ?? ''])

@yield('content')

@include('layout.footer')
