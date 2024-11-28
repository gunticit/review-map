function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: latitude, lng: longitude},
        zoom: 16
    });

    var input = document.getElementById('search-places');
    var searchBox = new google.maps.places.SearchBox(input);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];

        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }

            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };
            const latLng = place.geometry.location;
            let latitude = latLng.lat();
            let longitude = latLng.lng();
            document.getElementById('lat').value = latitude ?? null;
            document.getElementById('long').value = longitude ?? null;
            document.getElementById('place-id').value = place?.place_id ?? null;
            document.getElementById('place-name').innerHTML = place?.name ?? '';
            document.getElementById('place-address').innerHTML = place?.formatted_address !== undefined ? place?.formatted_address : '';
            document.getElementById('place-telephone').innerHTML = place?.formatted_phone_number !== undefined ? 'Số điện thoại: ' + place?.formatted_phone_number : '';
            document.getElementById('place-rate').innerHTML = place?.rating !== undefined ? 'Rating: ' + place?.rating + ' (' + place?.user_ratings_total + ' đánh giá)' : 'Rating: Chưa có đánh giá';
            document.getElementById('info-map-reviews').innerHTML = `
            <h3>${place.name}</h3>
            <div class="list-star">
                ${place?.rating !== undefined ? '<span>' + place?.rating + '</span>' : ''}
                <p>
                    <i class="fa fa-star active"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </p>
                ${place?.rating !== undefined ? '(' + place?.user_ratings_total + ')' : '(0)'}
            </div>
            <p>${place.formatted_address !== undefined ? place?.formatted_address : ''}</p>
            <p>${place.formatted_phone_number !== undefined ? 'Số điện thoại: ' + place?.formatted_phone_number : ''}</p>
            <div class="rating-row">
                ${place?.rating !== undefined ? '<h4>Đánh giá: <span id="avg-rating">' + place?.rating + '</span></h4>' : ''}
                <p>${place?.user_ratings_total !== undefined ? '(<span id="rating-total">' + place?.user_ratings_total + '<span> lượt)' : 'Đánh giá: (<span id="rating-total">0<span> lượt)'}</p>
            </div>
            <div id="rating-desire-group">
                <input type="hidden" name="rating_google" id="rating-google" value="${place?.rating !== undefined ? place?.rating : 0}"/>
                <input type="text" onchange="handleRatingDesire()" step="0.1" min="4.1" max="4.9" class="form-control" name="rating_desire" id="rating-desire"/>
            </div>
            `;
            const stars = document.querySelectorAll('.list-star .fa-star');
            stars.forEach(star => {
                if (star.classList.contains('active')) {
                    star.classList.remove('active');
                }
            });
            for (let i = 0; i < Math.floor(place?.rating); i++) {
                i = Math.floor(i);
                stars[i].classList.add('active');
            }
            markers.push(new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: latLng
            }));

            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
}


function handleRatingDesire() {
    $('body #rating-desire-group .alert').remove();
    $('body #rating-desire-group p.text-danger').remove();
    $('body #suggest').remove();
    let rating_desire = $('body #rating-desire').val();
    let rsTest = $('body #avg-rating').text().trim(); // Điểm google trả về
    if(!rsTest){
        rsTest = 0;
    }
    rsTest = parseFloat(rsTest).toFixed(1);
    if (rating_desire.includes(',')) {
        rating_desire = rating_desire.replace(',', '.');
    }
    rating_desire = parseFloat(rating_desire);
    if (!isNaN(rating_desire)) {
        $('body #rating-desire').val(rating_desire.toFixed(1));
    } 
    if(rating_desire == 0 || rating_desire == null || rating_desire == ''){
        $('body #rating-desire').addClass('border-error');
        $('body #rating-desire-group').append('<p class="text-danger">Vui lòng nhập giá trị mong muốn</p>');
    }else{
        $('body #rating-desire').removeClass('border-error');
        if(rating_desire < 4.1 && rsTest < 4.1) {
            $('body #rating-desire').val(4.1);
            $('#rating-desire-group').append('<p class="text-danger">Trung bình đánh giá phải cao hơn hoặc bằng trung bình đánh giá hiện tại.</p>');
        }else if(rating_desire < 4.1 && rsTest > 4.1) {
            $('body #rating-desire').val(rsTest);
        }
        if(rating_desire > 4.9) {
            $('body #rating-desire').val(4.9);
            $('#rating-desire-group').append('<p class="text-danger">Đã đạt giới hạn tối đa của trung bình đánh giá.</p>');
        }
        if(rating_desire >= 4.1 && rating_desire <= 4.9) {
            if(rating_desire > rsTest) {
                $('body #rating-desire').val(rating_desire);
                let point = 0;
                let trvbd = $('body #rating-total').text().trim(); //zxc
                trvbd = parseFloat(trvbd);
                let dvbd = parseFloat(rsTest);
                let rvmm = parseFloat(rating_desire);
                let total_rvmm = ((rvmm - dvbd) * trvbd) / (5 - rvmm);
                var package = '';
                if(parseInt(total_rvmm) > 0 && parseInt(total_rvmm) <= 10){
                    package = '<span style="font-weight: bold">RIVI10 - 45.000 VND/đánh giá - 10 lượt đánh giá</span>';
                }
                if(parseInt(total_rvmm) > 0 && parseInt(total_rvmm) <= 10){
                    package = '<span style="font-weight: bold">RIVI50 - 35.000 VND/đánh giá - 50 lượt đánh giá</span>';
                }
                if(parseInt(total_rvmm) > 50 && parseInt(total_rvmm) <= 100){
                    package = '<span style="font-weight: bold">RIVI100 - 30.000 VND/đánh giá - 100 lượt đánh giá</span>';
                }
                if(parseInt(total_rvmm) > 100){
                    package = '<span style="font-weight: bold">RIVI200 - 25.000 VND/đánh giá - 200 lượt đánh giá</span>';
                }
                $('#rating-desire-group').append(`
                    <div id="suggest">
                        <p style="display: flex;gap: 5px;margin-top: 5px;"><span style="margin-top: 5px;color: #e6be00;font-weight: bold;" class="material-symbols-outlined">wb_sunny</span> Số lượng đánh giá cần thiệt để đạt ${rating_desire} sao là ${parseInt(total_rvmm)} đánh giá. Nếu bạn vẫn muốn tiếp tục, vui lòng chọn gói review cao hơn.</p>
                        <p>Gói review đề xuất: ${package ?? 'Chưa có gói nào phù hợp'}</p>
                    </div>
                `);
            }else{
                $('body #rating-desire').val(rsTest);
                $('#rating-desire-group').append('<p class="text-danger">Trung bình đánh giá phải cao hơn hoặc bằng trung bình đánh giá hiện tại.</p>');
            }
        }
    }
}