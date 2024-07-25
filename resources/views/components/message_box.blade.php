<div class="card p-2 border border-dark">
    <form action="{{ route('send_message') }}">
        {{-- hidden sender_id --}}
        <input type="hidden" name="sender_user_id" value="{{ $user->id }}">
        <select class="form-select mb-3" name="recipient_user_id" required>
            <option value="" selected disabled>-- Select Recipient --</option>
            @foreach ($users as $user_item)
                @if ($user->id != $user_item->id)
                    <option value="{{ $user_item->id }}">{{ $user_item->name }}</option>
                @endif
            @endforeach
        </select>
        <textarea class="form-control mb-3" name="message" id="" rows="5" placeholder="Write secret message to send" required></textarea>
        <button class="btn btn-success btn-sm col-12" type="submit">Send Message <i class="fas fa-paper-plane"></i></button>
    </form>
</div>
