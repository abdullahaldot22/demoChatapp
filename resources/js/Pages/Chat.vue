<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import '@/echo.js';
import ChatBox from "@/Components/ChatBox.vue";
import VoiceCallPopUp from "@/Components/VoiceCallNotificationPopUp.vue";

// const props = defineProps(['text', 'sender_id', 'receiver_id']);

const callClicked = () => {

}



// Echo.private('chat-channel.${this.message.receiver_id}')
//    .listen('.MessageSendEvent', (e) => {
//        // this.$inertia.reload(); // Or handle the message
//        console.log(e);
//    });

</script>

<style scoped>
.box span img {
    height: 30px;
}
.box span:first-of-type {
    margin-right: 40px;
}
.box span:first-of-type img {
    height: 25px;
}

</style>

<template>
    <Head title="Chat" />

    <AuthenticatedLayout>
        <template #header>
            <div class="wrapper flex w-full justify-between">
                <h2 class="font-semibold text-xl leading-tight">{{ $page.props.user.name }}</h2>
                <div class="box flex items-center mr-5">
                    <span><a href="#"><img src="/icons/tele.png" alt="phone"></a></span>
                    <span><a :href="route('video.call.page', $page.props.user.id)"><img src="/icons/video.png" alt="video"></a></span>
                </div>
            </div>
        </template>


        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <ChatBox/>
            </div>
        </div>


    </AuthenticatedLayout>
</template>
