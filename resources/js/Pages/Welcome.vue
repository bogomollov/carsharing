<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});
</script>

<template>
    <Head title="Главная" />
        <div class="h-screen justify-between min-h-screen bg-gray-100 min-w-screen text-gray-700">
            <header class="w-full bg-white border-gray-100 shadow-sm header">
                <div class="flex items-center justify-between p-5 mx-auto">
                    <nav class="flex font-normal text-lg items-center justify-center mx-auto">
                        <a class="items-center text-gray-900 md:mb-0 header-img">
                            <img src="./images/logo.png" width="50" height="50"/>
                        </a>
                        <a @click="handleClick" class="hover:text-gray-900 header-tarif">Тарифы</a>
                        <a @click="handleClick2" class="pl-5 hover:text-gray-900">Контакты</a>
                        <div v-if="!$page.props.auth.user" class="items-center h-full account2">
                            <Link :href="route('login')" class="pr-5 hover:text-gray-900">Авторизация</Link>
                            <Link :href="route('register')" class="px-4 py-2 text-white transition-all duration-150 rounded shadow outline-none hover:shadow-md focus:outline-none ease header-button">
                                Регистрация</Link>
                        </div>
                        <div v-if="$page.props.auth.user" class="items-center h-full account">
                            <AuthenticatedLayout></AuthenticatedLayout>
                        </div>
                    </nav>
                </div>
            </header>
            <div class="mt-16 main">
                <div class="mx-auto main-content">
                    <a class="font-medium text-2xl">Автопарк</a>
                    <div class="flex slider">
                        <div class="flex flex-wrap slider-img">
                            <div class="bg-white border-gray-100 shadow-sm"><img src="./images/kia k8.png"></div>
                            <div class="bg-white border-gray-100 ml-5 shadow-sm"><img src="./images/audia6.png"></div>
                            <div class="bg-white border-gray-100 ml-5 shadow-sm"><img src="./images/volkswagen polo.png"></div>
                            <div class="bg-white border-gray-100 ml-5 shadow-sm"><img src="./images/mazda 3.png"></div>
                            <div class="bg-white border-gray-100 mt-5 shadow-sm"><img src="./images/mitsubishi lancer.png"></div>
                            <div class="bg-white border-gray-100 ml-5 mt-5 shadow-sm"><img src="./images/dodge challenger.png"></div>
                            <div class="bg-white border-gray-100 ml-5 mt-5 shadow-sm"><img src="./images/toyota matrix.png"></div>
                            <div class="bg-white border-gray-100 ml-5 mt-5 shadow-sm"><img src="./images/hyundai sonata.png"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-16 mb-44 main">
                <div class="mx-auto main-content">
                    <a ref="targetRef" class="font-medium text-2xl">Тарифы</a>
                    <div class="flex slider">
                        <div class="flex flex-wrap content-tarif">
                            <div class="border-gray-100 shadow-sm">
                                <div class="flex namet">
                                    <a class="font-medium text-xl">Суточный</a>
                                    <a class="font-normal text-lg">2310 ₽/24 часа</a>
                                </div>
                            </div>
                            <div class="border-gray-100 shadow-sm ml-5">
                                <div class="flex namet">
                                    <a class="font-medium text-xl">Поминутный (день)</a>
                                    <a class="font-normal text-lg">8 ₽/мин</a>
                                </div>
                            </div>
                            <div class="border-gray-100 shadow-sm ml-5">
                                <div class="flex namet">
                                    <a class="font-medium text-xl">Поминутный (ночь)</a>
                                    <a class="font-normal text-lg">7 ₽/мин</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer ref="targetRef2" class="bg-white border-gray-100 shadow-sm footer">
                <div class="flex items-center justify-between p-5 mx-auto">
                    <nav class="flex font-normal text-lg items-center justify-center mx-auto">
                        <div class="flex items-center text-gray-900 md:mb-0 footer-img">
                            <a href="https://vk.com" target="_blank"><img src="./images/vk.png" width="40" height="24"/></a>
                            <a href="https://web.telegram.org" target="_blank" class="pl-5"><img src="./images/tg.png" width="32" height="27"/></a>
                            <a href="https://web.whatsapp.com" target="_blank" class="pl-5"><img src="./images/whatsapp.png" width="31" height="31"/></a>
                            <a href="https://youtube.com" target="_blank" class="pl-5"><img src="./images/youtube.png" width="40" height="26"/></a>
                        </div>
                        <a href="mailto:info@autoterminal.ru" target="_blank" class="font-normal text-lg hover:text-gray-900 footer-email">info@autoterminal.ru</a>
                        <a href="https://yandex.ru/maps/-/CDqBR2km" target="_blank" class="font-normal text-lg pl-5 hover:text-gray-900">Москва, ул. Житная 52/1</a>
                        <a href="tel:+78003500270" class="font-normal text-lg pl-5 hover:text-gray-900">+7 (800) 350-02-70</a>
                    </nav>
                </div>
            </footer>         
        </div>
    </template>
<script>
export default {
  data() {
    return {
      ref: null
    };
  },
  methods: {
    handleClick() {
        this.$refs.targetRef.scrollIntoView({behavior:'smooth'});
    },
    handleClick2() {
        this.$refs.targetRef2.scrollIntoView({behavior:'smooth'});
    }
  }
};
</script>
<style>
.header-tarif {
    padding-left: 45px;
}
.header-button, .arrow-left, .arrow-right {
    background-color: #4FC3F7;
}
.account {
    padding-left: 1155px;
}
.account2 {
    padding-left: 999px;
}
.main-content {
    width: 1539px;
}
.slider {
    margin-top: 30px;
}
.slider-img div {
    display: flex;
    justify-content: center;
    border-radius: 0.25rem;
    height: 150px;
}
@media screen {
    .slider-img div {
        max-width: 369px;
    }
}
.content-tarif div {
    display: flex;
    border-radius: 0.25rem;
    justify-content: center;
    align-items: center;
    text-align: center;
    width: 499px;
    background-color: white;
}
.namet {
    padding: 20px;
    flex-direction: column;
    align-items: center;
}
.footer-email {
    margin-left: 734px;
}
.footer-img {
    padding: 5px 5px 5px 0px;
}
</style>
