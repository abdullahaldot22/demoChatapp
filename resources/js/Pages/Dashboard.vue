<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import VoiceCallPopUp from "@/Components/VoiceCallNotificationPopUp.vue";
import VideoCallNotificationPopUp from "@/Components/VideoCallNotificationPopUp.vue";


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-200 text-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">You're logged in!</div>
                    <div class="box pl-6 border-t-2 border-black pt-3 pb-4">
                        <div class="font-bold mb-3">Users</div>
                        <ul>
                            <li v-for="item in $page.props.users"><a :href="route('chat.page', item.id)">{{ item.name }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

<!--    <VoiceCallPopUp></VoiceCallPopUp>-->
<!--        <video-call-notification-pop-up/>-->
    </AuthenticatedLayout>
</template>
