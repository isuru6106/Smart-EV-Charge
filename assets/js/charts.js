document.addEventListener("DOMContentLoaded", () => {

    /* Revenue Chart */

    const revenueChart = document.getElementById("revenueChart");

    if (revenueChart) {

        fetch("../php/get_chart_data.php")
        .then(response => response.json())
        .then(data => {

            new Chart(revenueChart, {
                type: "line",
                data: {
                    labels: data.days,
                    datasets: [{
                        label: "Revenue (Rs.)",
                        data: data.revenue,
                        tension: 0.4,
                        borderWidth: 3
                    }]
                }
            });

        });

    }

    /* Booking Chart */

    const bookingChart = document.getElementById("bookingChart");

    if (bookingChart) {

        fetch("../php/get_booking_chart.php")
        .then(response => response.json())
        .then(data => {

            new Chart(bookingChart, {
                type: "bar",
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: "Bookings",
                        data: data.data
                    }]
                }
            });

        });

    }

    /* Port Status Chart */

    const portChart = document.getElementById("portChart");

    if (portChart) {

        fetch("../php/get_port_status.php")
        .then(response => response.json())
        .then(data => {

            new Chart(portChart, {
                type: "doughnut",
                data: {
                    labels: [
                        "Available",
                        "Occupied"
                    ],
                    datasets: [{
                        data: [
                            data.available,
                            data.occupied
                        ]
                    }]
                }
            });

        });

    }

    /* Rating Chart */

    const ratingChart = document.getElementById("ratingChart");

    if (ratingChart) {

        fetch("../php/get_rating_data.php")
        .then(response => response.json())
        .then(data => {

            const rating = data.rating || 0;

            new Chart(ratingChart, {
                type: "radar",
                data: {
                    labels: [
                        "Speed",
                        "Cleanliness",
                        "Availability",
                        "Price",
                        "Support"
                    ],
                    datasets: [{
                        label: "Center Rating",
                        data: [
                            rating,
                            rating,
                            rating,
                            rating,
                            rating
                        ]
                    }]
                }
            });

        });

    }

});

document.addEventListener("DOMContentLoaded", () => {

    fetch("../php/get_admin_chart.php")
    .then(response => response.json())
    .then(data => {

        new Chart(
            document.getElementById("revenueChart"),
            {
                type: "line",
                data: {
                    labels: data.days,
                    datasets: [{
                        label: "Revenue",
                        data: data.revenue,
                        borderWidth: 3,
                        tension: 0.4
                    }]
                }
            }
        );

    });

    fetch("../php/get_admin_booking_chart.php")
    .then(response => response.json())
    .then(data => {

        new Chart(
            document.getElementById("bookingChart"),
            {
                type: "bar",
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: "Bookings",
                        data: data.data
                    }]
                }
            }
        );

    });

});