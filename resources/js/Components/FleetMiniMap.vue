<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const MOSCOW_CENTER = [55.7558, 37.6173];

const mapContainer = ref(null);
let map = null;
const markers = new Map();

function upsertMarker(car) {
    if (car.latitude == null || car.longitude == null) {
        return;
    }

    const existing = markers.get(car.id);
    if (existing) {
        existing.setLatLng([car.latitude, car.longitude]);
        return;
    }

    const marker = L.circleMarker([car.latitude, car.longitude], {
        radius: 7,
        color: '#5181ff',
        fillColor: '#5181ff',
        fillOpacity: 0.9,
        weight: 2,
    }).addTo(map);

    markers.set(car.id, marker);
}

onMounted(async () => {
    map = L.map(mapContainer.value, {
        zoomControl: false,
        attributionControl: false,
    }).setView(MOSCOW_CENTER, 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    const { data: cars } = await window.axios.get('/api/v1/cars/positions');
    cars.forEach(upsertMarker);

    if (cars.length) {
        const bounds = L.latLngBounds(cars.map((car) => [car.latitude, car.longitude]));
        map.fitBounds(bounds, { padding: [24, 24], maxZoom: 14 });
    }

    window.Echo.channel('cars-tracking').listen('.CarMoved', upsertMarker);
});

onBeforeUnmount(() => {
    window.Echo.leaveChannel('cars-tracking');
    markers.clear();
    map?.remove();
});
</script>

<template>
    <div ref="mapContainer" class="fleet-mini-map"></div>
</template>

<style scoped>
.fleet-mini-map {
    width: 100%;
    height: 320px;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 50px;
}
</style>
