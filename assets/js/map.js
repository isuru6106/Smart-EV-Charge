const defaultCenters = [];

function distanceKm(lat1, lon1, lat2, lon2) {

    const R = 6371;

    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;

    const a =
        Math.sin(dLat / 2) ** 2 +
        Math.cos(lat1 * Math.PI / 180) *
        Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) ** 2;

    return R * 2 * Math.atan2(
        Math.sqrt(a),
        Math.sqrt(1 - a)
    );
}

function recommendationScore(center, userLat, userLng) {

    const distance =
        distanceKm(
            userLat,
            userLng,
            Number(center.latitude),
            Number(center.longitude)
        );

    const availability =
        Number(center.available_slots) * 10;

    return availability - distance;
}

async function loadMap() {

    const mapElement =
        document.getElementById("map");

    if (!mapElement) return;

    const map = L.map("map").setView(
        [6.9271, 79.8612],
        11
    );

    L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
        {
            attribution: "&copy; OpenStreetMap"
        }
    ).addTo(map);

    let centers = defaultCenters;

    try {

        const response =
            await fetch(
                "../php/get_centers_map.php"
            );

        centers =
            await response.json();

        console.log("Centers:", centers);

    } catch (error) {

        console.log(error);

    }

    function render(userLat, userLng) {

        map.setView(
            [userLat, userLng],
            12
        );

        L.marker(
            [userLat, userLng]
        )
        .addTo(map)
        .bindPopup(
            "📍 Your Current Location"
        )
        .openPopup();

        const sortedCenters =
            centers
            .map(center => ({

                ...center,

                distance:
                    distanceKm(
                        userLat,
                        userLng,
                        Number(center.latitude),
                        Number(center.longitude)
                    ),

                score:
                    recommendationScore(
                        center,
                        userLat,
                        userLng
                    )

            }))
            .sort(
                (a, b) =>
                b.score - a.score
            );

        const nearestList =
            document.getElementById(
                "nearestList"
            );

        if (nearestList) {

            nearestList.innerHTML = "";

        }

        sortedCenters.forEach(
            (center, index) => {

            L.marker([
                Number(center.latitude),
                Number(center.longitude)
            ])
            .addTo(map)
            .bindPopup(`
                <b>${center.center_name}</b><br>
                ${center.address}<br>
                Available Slots:
                ${center.available_slots}/${center.total_slots}<br>
                Price:
                Rs. ${center.price_per_kwh}/kWh
            `);

            if (nearestList) {

                const card =
                    document.createElement(
                        "div"
                    );

                card.className =
                    "card";

                card.innerHTML = `
                    <h3>
                    ${index === 0 ?
                    "⭐ Recommended: "
                    : ""}
                    ${center.center_name}
                    </h3>

                    <p>
                    ${center.address}
                    </p>

                    <p>
                    Distance:
                    ${center.distance.toFixed(2)} km
                    |
                    Slots:
                    ${center.available_slots}
                    </p>

                    <p>
                    Price:
                    Rs.
                    ${center.price_per_kwh}/kWh
                    </p>

                    <a
                    class="btn"
                    href="book-slot.html?center_id=${center.center_id}">
                    Book This Center
                    </a>
                `;

                nearestList.appendChild(
                    card
                );
            }

        });

    }

    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(

            position => {

                render(
                    position.coords.latitude,
                    position.coords.longitude
                );

            },

            () => {

                render(
                    6.9271,
                    79.8612
                );

            }

        );

    } else {

        render(
            6.9271,
            79.8612
        );

    }

}

document.addEventListener(
    "DOMContentLoaded",
    loadMap
);