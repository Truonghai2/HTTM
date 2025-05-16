const pusher = new Pusher("64f3bc283eae501448bc", {
    cluster: "ap1",
    forceTLS: true,
});

function formatDateTime(dt) {
    if (!dt) return '';
    const date = new Date(dt);
    if (isNaN(date.getTime())) return dt;
    const pad = n => n.toString().padStart(2, '0');
    return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())} ${pad(date.getHours())}:${pad(date.getMinutes())}:${pad(date.getSeconds())}`;
}

const channel = pusher.subscribe("vehicle-channel");
channel.bind("vehicle-updated", function(data) {

    document.getElementById('license_plate').textContent = data.license_plate || '';
    document.getElementById('vehicle_type').textContent = data.vehicle_type || '';
    document.getElementById('time').textContent = formatDateTime(data.time);
    document.getElementById('check_out_time').textContent = data.check_out_time ? formatDateTime(data.check_out_time) : 'Chưa có';
    document.getElementById('price').textContent = (data.price ? Number(data.price).toLocaleString() + ' VNĐ' : '0 VNĐ');

    const imgContainer = document.getElementById('img_container');
    if (data.img) {
        imgContainer.innerHTML = `<img id="vehicle_img" src="${data.img}" alt="Ảnh xe" class="rounded-lg border border-gray-300 shadow-md">`;
    } else {
        imgContainer.innerHTML = `<p id="no_img">Không có ảnh</p>`;
    }
});

// pusher.connection.bind('connected', () => {
//     console.log('Pusher connected');
// });
// pusher.connection.bind('error', (err) => {
//     console.error('Pusher error:', err);
// });
