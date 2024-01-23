<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;

const updateCars = () => {
    form.put(route('profile.carsupdate'));
};
const form = useForm({
    id: user.id,
    car: user.car
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Информация о каршеринге</h2>
            <p class="mt-1 text-sm text-gray-600">
                Выберите машину для проката
            </p>
        </header>
        <form @submit.prevent="updateCars" class="mt-6 space-y-6">
            <InputLabel value="Машина" style="margin-bottom: -19px;"/>
            <div id="v-model-select-dynamic">
                <select for="car" v-model="form.car" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block">
                    <option id="car" v-for="car in cars" :key="car.id" :value="car.id">
                        {{ car.mark }} {{ car.model }}
                    </option>
                </select>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Сохранить изменения</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Сохранено</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<script>
export default {
    data() {
        return {
            cars: [],
        }
    },
    mounted() {
        this.fetchCars();
    },
    methods: {
        fetchCars() {
            axios.get('/api/auth/cars')
                .then(response => {
                    this.cars = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>