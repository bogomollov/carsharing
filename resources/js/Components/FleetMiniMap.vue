<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const MOSCOW_CENTER = [55.7558, 37.6173];
const LAT_MIN = 55.70;
const LAT_MAX = 55.88;
const LNG_MIN = 37.37;
const LNG_MAX = 37.58;
const STEP = 0.0006;
const TICK_MS = 2000;
const FLEET_SIZE = 7;

const mapContainer = ref(null);
let map = null;
let tickHandle = null;
const markers = new Map();
const fleet = [];

function randomBetween(min, max) {
    return min + Math.random() * (max - min);
}

function drift(value, min, max) {
    const next = value + (Math.random() * 2 - 1) * STEP;
    return Math.min(max, Math.max(min, next));
}

function upsertMarker(car) {
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

function seedFleet() {
    for (let i = 0; i < FLEET_SIZE; i++) {
        fleet.push({
            id: `demo-${i}`,
            latitude: randomBetween(LAT_MIN, LAT_MAX),
            longitude: randomBetween(LNG_MIN, LNG_MAX),
        });
    }
}

function tick() {
    fleet.forEach((car) => {
        car.latitude = drift(car.latitude, LAT_MIN, LAT_MAX);
        car.longitude = drift(car.longitude, LNG_MIN, LNG_MAX);
        upsertMarker(car);
    });
}

onMounted(() => {
    map = L.map(mapContainer.value, {
        zoomControl: false,
        attributionControl: true,
    }).setView(MOSCOW_CENTER, 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    seedFleet();
    fleet.forEach(upsertMarker);

    const bounds = L.latLngBounds(fleet.map((car) => [car.latitude, car.longitude]));
    map.fitBounds(bounds, { padding: [24, 24], maxZoom: 14 });

    tickHandle = window.setInterval(tick, TICK_MS);
});

onBeforeUnmount(() => {
    if (tickHandle) {
        window.clearInterval(tickHandle);
    }
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
