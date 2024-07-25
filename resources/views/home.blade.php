@extends('layouts.app')

@section('content')
    @include('modals.inbox')
    <!-- Display success messages -->
    @if (session('success'))
        <div class="container text-center">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif
    <!-- Display error messages -->
    @if ($errors->any())
        <div class="container">
            <div class="alert alert-danger">
                <h4>Errors</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="col-12 mx-auto row justify-content-around">
            @foreach ($users as $user)
                <div class="col-md-6">
                    <div class="card mb-2">
                        <div class="card-header">
                            <h4 class="m-0">{{ $user->name }}</h4>
                        </div>
                        <div class="card-body">
                            @include('components.message_box', ['user' => $user, 'users' => $users])
                        </div>
                        @php
                            $now = \Carbon\Carbon::now();
                            $nonExpiredMessages = $user->messages->filter(function ($message) use ($now) {
                                return is_null($message->expiry) ||
                                    $now->lessThan(\Carbon\Carbon::parse($message->expiry));
                            });
                        @endphp
                        <button class="text-center btn btn-primary {{ $nonExpiredMessages->isEmpty() ? 'disabled' : '' }}"
                            data-bs-toggle="modal" data-bs-target="#form-message-modal" data-user-id="{{ $user->id }}">
                            <i class="fa fa-envelope"></i> Messages Inbox ({{ $nonExpiredMessages->count() }})
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Fade out the .alert-success div after 5 seconds (5000 milliseconds)
            $(".alert-success").delay(2000).fadeOut("slow");

            // Handle the click event of the button
            $('[data-bs-toggle="modal"]').click(function() {
                // Get the user id from the data attribute
                var userId = $(this).data('user-id');

                // Find the user's messages
                var user = @json($users).find(user => user.id === userId);
                var messages = user.messages.map(
                    message => {
                        var expiryInMinutes;
                        if (message.expiry == null) {
                            expiryInMinutesText = 'Once opened will expire in 3 minutes.';
                        } else {
                            var currentTime = new Date();
                            var expiryTime = new Date(message.expiry);
                            expiryInMinutes = Math.round((expiryTime - currentTime) / 60000);
                            expiryInMinutesText = 'Expires in about ' + expiryInMinutes + ' minutes';
                        }
                        // Convert the created_at timestamp to a Date object
                        var createdAt = new Date(message.created_at);

                        // Calculate the difference between the current time and the created_at time in minutes
                        var minutesAgo = Math.round((new Date() - createdAt) / 60000);

                        // Check if the message has expired
                        if (expiryInMinutes <= 0) {
                            // If the message has expired, do not add the card
                            return '';
                        } else {
                            // If the message has not expired, add the card
                            return '<div class="card m-1 p-2">' +
                                '<div>' +
                                (expiryInMinutes != null ? 'Opened about ' + (3 - expiryInMinutes) +
                                    ' minutes ago.' : 'Unopened') +
                                '</div>' +
                                '<div>' +
                                expiryInMinutesText +
                                '</div>' +
                                '<h5>' + user.name + ' sent you a secret message</h5>' +
                                'Created about ' + minutesAgo + ' minutes ago ' +
                                '<button class="btn btn-primary btn-sm open-message-button" onclick=open_message("' +
                                message.id +
                                '")>Open Message</button>' +
                                '</div>';
                        }
                    }
                ).join('');

                // Update the modal content
                $('#user-messages').html(messages);
            });
        });

        function open_message(message_id) {
            $(event.target).closest('.card').hide();
            $('.open-message-button').attr('disabled', true)
            $.ajax({
                url: '/decrypt-message/' + message_id,
                method: 'GET',
                success: function(response) {
                    // Update the modal content with the decrypted message
                    $('#decrypted-messages').show();
                    $('#decrypted-messages').html(
                        '<small><strong>Encrypted Message</strong></small>' +
                        response.encryptedMessage +
                        '<hr class="my-2">' +
                        '<small><strong>Decrypted Message</strong></small>' +
                        response.decryptedMessage
                    );
                    setTimeout(function() {
                        $('#decrypted-messages').hide();
                        $('.open-message-button').attr('disabled', false)
                    }, 3000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle any errors
                    console.error(textStatus, errorThrown);
                }
            });
        };
    </script>
@endsection
