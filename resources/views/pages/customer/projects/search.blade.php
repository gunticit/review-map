@if($projects)
    @foreach($projects as $project)
        <tr>
            <td width="15" style="padding: 5px">
                <input type="checkbox" class="form-check-input" id="check_{{ $project->id }}">
            </td>
            <td width="35">{{ $project->id }}</td>
            <td class="list-table-title">
                <a href="{{ route('project.edit', ['id' => $project->id]) }}">{{ $project->name }}</a>
            </td>
            <td class="list-table-link-map">
                <a class="btn" target="_blank" href="https://www.google.com/maps/embed/v1/place?key={{env('GOOGLE_MAP_API_KEY')}}&q=place_id:{{$project->place_id}}" role="button">
                    <span class="material-symbols-outlined">link</span>
                </a>
            </td>
            <td class="list-table-progree">
                <a class="{{ checkStatus($project->status)['className'] }}">{{ checkStatus($project->status)['labelStatus'] }}</a>
            </td>
            <td class="list-table-status">
                @if($project->status == 1)
                    <a href="javascript:void(0)" style="display: flex;" val-status="{{ $project->status }}" val-id="{{ $project->id }}" class="btn btn-outline-warning btn-change-status" role="button">
                        <span class="material-symbols-outlined">motion_photos_paused</span> <span>Tạm dừng</span>
                    </a>
                @elseif($project->status == 4)
                    <a href="javascript:void(0)" style="display: flex;" val-status="{{ $project->status }}" val-id="{{ $project->id }}" class="btn btn-outline-success btn-change-status" role="button">
                        <span class="material-symbols-outlined"> play_arrow </span> <span>Tiếp tục</span> 
                    </a>
                @elseif($project->status == 5)
                    <a href="{{ route('page.order.project', ['id' => $project->id]) }}" style="display: flex;" val-status="{{ $project->status }}" val-id="{{ $project->id }}" class="btn btn-outline-primary" role="button">
                        <span class="material-symbols-outlined"> payments </span> <span>Thanh toán</span>
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
@endif
<script>
    $('body').on('click', '.pagination a', function(event) {
        event.preventDefault();
        event.stopPropagation();
        var page = $(this).attr('href').split('page=')[1];
        let rs_search = $('body #inputSearch').val();
        fetch_data(keyword,page);
    });

    function fetch_data(keyword,page) {
        $.ajax({
            url: "{{ route('project.search') }}",
            method: "get",
            data: {
                name: keyword,
                page: page
            }
            success: function(data) {
                $('#list-project').html(data);
            }
        });
    }
</script>