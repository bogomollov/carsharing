<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/Button.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    password_confirmation: '',
    last_name: '',
    first_name: '',
    middle_name: '',
    passport_series: '',
    passport_number: '',
    driverlicense_series: '',
    driverlicense_number: '',
    driverlicense_date: '',
    phone: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Регистрация" />

        <form @submit.prevent="submit">

            <div class="mt-4">
                <InputLabel for="last_name" value="Фамилия" />

                <TextInput
                    id="last_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.last_name"
                    required
                    autocomplete="family-name"
                />

                <InputError class="mt-2" :message="form.errors.last_name" />
            </div>

            <div class="mt-4">
                <InputLabel for="first_name" value="Имя" />

                <TextInput
                    id="first_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.first_name"
                    required
                    autocomplete="given-name"
                />

                <InputError class="mt-2" :message="form.errors.first_name" />
            </div>

            <div class="mt-4">
                <InputLabel for="middle_name" value="Отчество" />

                <TextInput
                    id="middle_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.middle_name"
                    required
                    autocomplete="additional-name"
                />

                <InputError class="mt-2" :message="form.errors.middle_name" />
            </div>

            <div class="mt-4">
                <InputLabel for="phone" value="Номер телефона" />

                <TextInput
                    id="phone"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autocomplete="tel"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="mt-4">
                <InputLabel for="passport_series" value="Серия паспорта" />

                <TextInput
                    id="passport_series"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.passport_series"
                    required
                />

                <InputError class="mt-2" :message="form.errors.passport_series" />
            </div>

            <div class="mt-4">
                <InputLabel for="passport_number" value="Номер паспорта" />

                <TextInput
                    id="passport_number"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.passport_number"
                    required
                />

                <InputError class="mt-2" :message="form.errors.passport_number" />
            </div>

            <div class="mt-4">
                <InputLabel for="driverlicense_series" value="Серия водительского удостоверения" />

                <TextInput
                    id="driverlicense_series"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.driverlicense_series"
                    required
                />

                <InputError class="mt-2" :message="form.errors.driverlicense_series" />
            </div>

            <div class="mt-4">
                <InputLabel for="driverlicense_number" value="Номер водительского удостоверения" />

                <TextInput
                    id="driverlicense_number"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.driverlicense_number"
                    required
                />

                <InputError class="mt-2" :message="form.errors.driverlicense_number" />
            </div>

            <div class="mt-4">
                <InputLabel for="driverlicense_date" value="Дата выдачи водительского удостоверения" />

                <TextInput
                    id="driverlicense_date"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.driverlicense_date"
                    required
                />

                <InputError class="mt-2" :message="form.errors.driverlicense_date" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Почта" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Пароль" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Повтор пароля" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Уже зарегистрированы?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Регистрация
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
