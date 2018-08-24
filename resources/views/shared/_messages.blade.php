@foreach(['danger','success','info','warning'] as $msg)
    @if(session()->has($msg))
        <div class="flash-messages">
            <p class="alert alert-{{ $msg }}">
                {{ session()->get($msg) }}
            </p>
        </div>
    @endif
@endforeach