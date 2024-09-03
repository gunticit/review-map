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
            document.getElementById('lat').value = latitude;
            document.getElementById('long').value = longitude;
            document.getElementById('place-id').value = place?.place_id;
            document.getElementById('place-name').innerHTML = place?.name;
            document.getElementById('place-address').innerHTML = place?.formatted_address !== undefined ? place?.formatted_address : '';
            document.getElementById('place-telephone').innerHTML = place?.formatted_phone_number !== undefined ? 'Số điện thoại: ' + place?.formatted_phone_number : '';
            document.getElementById('place-rate').innerHTML = place?.rating !== undefined ? 'Rating: ' + place?.rating + ' (' + place?.user_ratings_total + ' đánh giá)' : '';
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
                ${place?.rating !== undefined ? '(' + place?.user_ratings_total + ')' : ''}
            </div>
            <p>${place.formatted_address !== undefined ? place?.formatted_address : ''}</p>
            <p>${place.formatted_phone_number !== undefined ? 'Số điện thoại: ' + place?.formatted_phone_number : ''}</p>
            <div class="rating-row">
                ${place?.rating !== undefined ? '<h4>Đánh giá: <span id="avg-rating">' + place?.rating + '</span></h4>' : ''}
                <span>${place?.user_ratings_total !== undefined ? '(' + place?.user_ratings_total + ' lượt)' : ''}</span>
            </div>
            <div id="rating-desire-group">
                <input type="hidden" name="rating_google" id="rating-google" value="${place?.rating}"/>
                <input type="number" onclick="handleRatingDesire()" step="0.1" min="4.1" max="4.9" class="form-control" name="rating_desire" id="rating-desire"/>
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
    if($('body #rating-desire').val() == 0 || $('body #rating-desire').val() == null || $('body #rating-desire').val() == ''){
        $('body #rating-desire').addClass('border-error');
        $('body #rating-desire-group').append('<p class="alert text-danger">Vui lòng nhập giá trị mong muốn</p>');
    }else{
        $('body #rating-desire').removeClass('border-error');
        let rsTest = $('#avg-rating').text().trim();
        if($('body #rating-desire').val() < 4.1 && $('body #rating-desire').val() > Number(rsTest) && $('body #rating-desire').val() < 5) {
            $('body #rating-desire').val(4.1);
        } else if($('body #rating-desire').val() > 4.1 && $('body #rating-desire').val() < Number(rsTest) && $('body #rating-desire').val() < 5) {
            let rsDesire = Number(rsTest) + 0.1;
            $('body #rating-desire').val(rsDesire);
        }
        $('body #rating-desire-group').find('p').remove();
    }
}