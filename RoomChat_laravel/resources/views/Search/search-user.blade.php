@if(count($users) > 0)
        @foreach($users as $user)
        <a href="{{ url('user/'.$user->id) }}">
            <li class="list-group-item">
            <img src="{{ $user->path_image ? asset('/' . $user->path_image) : 'https://via.placeholder.com/50' }} " width="30px" height ="30px">
                {{ $user->name }}</li></a>           
        @endforeach
    @else
        <li class="list-group-item">Không tìm thấy người dùng!</li>
    @endif