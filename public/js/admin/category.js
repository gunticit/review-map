$(document).ready(function() {
    $('#parent').select2( {
        theme: 'bootstrap-5',
        ajax: {
            url: "{{ route('categories.list') }}",
            dataType: "json",
            type: "GET",
            data: function (params) {
                var queryParameters = {
                    name: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                if(data.data.data && data.data.data.length > 0){
                    return {
                        results: $.map(data.data.data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                            })
                    };
                }
                return {
                    results: [
                        {
                            text: 'Không có kết quả',
                            id: ''
                        }
                    ]
                }
            },
            results: function (data) {
                if(data.data.data && data.data.data.length > 0){
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }
                return {
                    results: [
                        {
                            text: 'Không có kết quả',
                            id: ''
                        }
                    ]
                }
            }
        }
    } );
})