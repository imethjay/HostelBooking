let map;
let infowindow;

function initMap() {
    const center = { lat: 6.822096107487801, lng: 80.04137978096055 };
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: center,
    });
    infowindow = new google.maps.InfoWindow();

    // Add markers for all properties
    const propertyElements = document.querySelectorAll('.l-name');
    propertyElements.forEach(function (element) {
        const mapLink = element.dataset.maplink;
        const latLng = getLatLngFromMapLink(mapLink);
        if (latLng) {
            addMarker(latLng, element);
        } else {
            console.error('Invalid map link:', mapLink);
        }

        // Add click event listener to the l-name element
        element.addEventListener('click', function () {
            google.maps.event.trigger(this.marker, 'click');
        });
    });
}

function getLatLngFromMapLink(mapLink) {
    const parts = mapLink.split(',');
    if (parts.length !== 2) {
        console.error('Invalid map link format:', mapLink);
        return null;
    }

    const lat = parseFloat(parts[0]);
    const lng = parseFloat(parts[1]);

    if (isNaN(lat) || isNaN(lng)) {
        console.error('Invalid latitude or longitude value:', mapLink);
        return null;
    }

    return { lat, lng };
}

function addMarker(latLng, propertyElement, description) {
    const marker = new google.maps.Marker({
        position: latLng,
        map: map,
    });

    // Store the marker object in the propertyElement
    propertyElement.marker = marker;

    marker.addListener("click", () => {
        const pname = propertyElement.textContent;
        const paddress = propertyElement.nextElementSibling.nextElementSibling.children[0]?.textContent || '';
        const pmobile = propertyElement.nextElementSibling.nextElementSibling.children[1]?.textContent || '';
        const pprice = propertyElement.nextElementSibling.textContent;

        const content = document.createElement("div");
        content.classList.add("info-window-content");

        const nameElement = document.createElement("h3");
        nameElement.classList.add("property-name");
        nameElement.textContent = pname;
        content.appendChild(nameElement);

        const addressElement = document.createElement("h4");
        addressElement.classList.add("property-address");
        addressElement.textContent = `Address: ${paddress}`;
        content.appendChild(addressElement);

        const mobileElement = document.createElement("h4");
        mobileElement.classList.add("property-mobile");
        mobileElement.textContent = `Mobile: ${pmobile}`;
        content.appendChild(mobileElement);

        const priceElement = document.createElement("h4"); // New element for property price
        priceElement.classList.add("property-price");
        priceElement.textContent = `Price: ${pprice}`;
        content.appendChild(priceElement);

        infowindow.setContent(content);
        infowindow.open(map, marker);
    });
}