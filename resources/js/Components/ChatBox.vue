<script setup>
import {onMounted, reactive, ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";
import {Inertia} from "@inertiajs/inertia";

const form = reactive({
    text : null,
    // uid : usePage().props.user.uid,
    sender_id : usePage().props.auth.user.id,
    receiver_id : usePage().props.user.id,
});

// console.log(usePage().props.user.uid);
function submit(e) {
    e.preventDefault();
    router.post(route('message.send'), form);
    form.text = '';
}

// console.log(usePage().props.messages);
// const reloadMessages = () => {
//     Inertia.reload({
//         only: ['messages'], // Only refetch the `messages` prop to optimize performance
//         preserveScroll: true, // Keeps the scroll position unchanged
//     });
// };

// const fetchNewMessages = () => {
//     Inertia.replace(window.location.pathname, {
//         only: ['messages'],
//         preserveScroll: true,
//         preserveState: true,
//     });
// };

// const {props} = usePage();
// const messages = ref(usePage().props.messages);
// defineProps({
//     messages: ref(usePage().props.messages),
// })
// "id" => 79
// "sender_id" => 1
// "receiver_id" => 7
// "text" => "i have doubt"
// "created_at" => "2024-08-24T20:40:39.000000Z"
// "updated_at" => "2024-08-24T20:40:39.000000Z"

onMounted(() => {
    Echo.private(`chat-channel.${form.sender_id}`)
        .listen('MessageSendEvent', (e) => {
            router.reload({
                only: ['messages'],
            })
            // fetchNewMessages();
            // messages.value.push(e.message);
            // let message = e.message;
            // console.log(newMessage);
            // oldMessages.value.push(e.message);
            // console.log(oldMessages);
            // console.log(message);
            // let old = usePage().props.messages;
            // reloadMessages();
            // console.log(e.message);
            // Object.assign(old, message);
            // [message].concat(usePage().props.messages)
        });
})
</script>


<template>
    <div class="bg-gray-200 text-gray-800 shadow overflow-hidden shadow-sm sm:rounded-lg">
        <div id="listBox" class="p-6">
            <ul v-if="$page.props.messages.length == 0">
                <li class="text-center">
                    <span>You havent any conversation yet!</span>
                </li>
            </ul>
            <ul v-else class="flex flex-col w-full">
                <!-- <li>{{ $page.props.user.id }}</li> -->

                <li v-for="message in $page.props.messages.slice(0).reverse()" :class="['mt-1', message.sender_id === $page.props.auth.user.id ? 'flex justify-end' : 'flex justify-start']" >
                    <span style="max-width: 80%;" :class="['px-3 pt-1 pb-1.5 rounded-md text-gray-200', message.sender_id === $page.props.auth.user.id ? 'bg-black' : 'bg-slate-500']">
                        {{ message.text }}
                    </span>
                </li>

            </ul>
        </div>

        <div class="box px-6 border-t-2 border-black pt-3 pb-4">
            <form @submit.prevent="submit" class="w-full flex justify-center px-3 py-2">
                <input type="text" v-model="form.text" class="rounded-md w-full mr-3 bg-gray-300 text-gray-800 focus:border-transparent focus:ring-gray-700">
                <button class="px-4 py-2 bg-slate-900 rounded-md text-white">Send</button>
            </form>

        </div>
    </div>
</template>

<style scoped>

</style>
