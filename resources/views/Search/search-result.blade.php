@if(count($members) > 0)
        @foreach($members as $member)
        <a href="{{ url('room/'.$member->id) }}">
            <li class="list-group-item">
            <img src="{{ $member->path_image ? asset('/' . $member->path_image) : 'https://via.placeholder.com/50' }} " width="30px" height ="30px">
                {{ $member->name }}</li></a>           
        @endforeach
    @else
        <li class="list-group-item">Không tìm thấy phòng!</li>
    @endif