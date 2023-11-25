<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Messages</h1>

{{--    <form action="{{ route( 'messages.store' ) }}" method="POST">--}}
{{--        @csrf--}}
        <input type="hidden" name="csrf" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{ auth()->user()->id ?? null }}">
        <input type="text" name="body"> <br>
        <button>Message</button>
{{--    </form>--}}

    <hr>


    <div class="messages">
        @foreach( $messages as $message )
            <div>
                User: {{ $message->user->name ?? 'Anonymous' }} | Message: {{ $message->body }} | {{ $message->created_at ? $message->created_at->diffForHumans() : "" }}
            </div>
        @endforeach
    </div>

    @vite( [ 'resources/js/app.js' ] )
    <script>
        let csrf = document.querySelector( 'input[name=csrf]' )
        let user_id = document.querySelector( 'input[name=user_id]' )
        let body = document.querySelector( 'input[name=body]' )
        let button = document.querySelector( 'button' )
        let messages = document.querySelector( '.messages' )

        button.addEventListener( 'click', () => {



            let message_body = {
                body: body.value,
                user_id: user_id.value,
            }




            fetch( '/messages', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrf.value
                },
                body: JSON.stringify( message_body )
            })
                .then( res => res.json() )
                .then( body => {
                    // body.value = ''
                    // console.log( body.body )
                    // let div = document.createElement( 'div' )
                    // div.innerHTML = `User: ${body.body.user_id ?? 'Anonymous'} | Message: ${body.body.body} | ${body.body.created_at}`
                    //
                    // messages.appendChild( div )
                })

            body.value = ''
        })

        setTimeout( () => {
            window.Echo.channel( 'messages_channel' )
                .listen( '.mes', body => {
                    console.log( 'sup', body )

                    let div = document.createElement( 'div' )
                    div.innerHTML = `User: ${body.user_id ?? 'Anonymous'} | Message: ${body.body} | ${body.created_at}`

                    messages.appendChild( div )
                })
        }, 200 )
    </script>
</body>
</html>
