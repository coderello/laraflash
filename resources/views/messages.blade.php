@foreach (laraflash()->ready() as $message)
    @component('laraflash::components.message.skins.'.config('laraflash.message_skin'), $message->toArray())
    @endcomponent
    <br>
@endforeach