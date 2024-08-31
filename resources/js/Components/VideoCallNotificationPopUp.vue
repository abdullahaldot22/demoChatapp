<script setup>

import {ref} from "vue";

const micDisable = ref(false);
const camDisable = ref(false);


</script>

<template>
    <div>
        <div class="overlay">
            <div class="text-gray-300 w-[450px] px-7 pt-4 pb-9 rounded-lg bg-teal-950 text-center">
                <h4 class="text-gray-600 pt-5">Video Call</h4>
                <p class="pt-4">{{ $page.props.auth.user.name }}</p>
                <div class="pt-5 pb-8 text-gray-500">Ringing ..</div>
                <div class="flex items-center justify-center">
                    <button class="ringIcon"><img src="/icons/tele.png"></button>
                    <button class="ringIcon"><img src="/icons/hang_up.png"></button>
                </div>
            </div>

        </div>
    </div>

    <div>
        <div class="hardware bg-teal-950">
            <button class="utilityIcon" :class="{ 'disable' : micDisable }" @click="micDisable = !micDisable"><img src="/icons/mic.png" alt="mic"></button>
            <button class="utilityIcon" :class="{ 'disable' : camDisable }" @click="camDisable = !camDisable"><img src="/icons/lens.png" alt="camera"></button>
        </div>
    </div>
</template>

<style scoped>

.overlay {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-color: rgba(38, 38, 38, 0.73);
    display: flex;
    align-items: center;
    justify-content: center;
}
.hardware {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 140px;
    border-radius: 12px;
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    justify-content: space-evenly;


}
.ringIcon {
    background-color: #6e84b4;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all ease-in-out 100ms;
}

.utilityIcon {
    background-color: #54be7d;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all ease-in-out 100ms;
}

.utilityIcon.disable {
    background-color: #c7c5c5;
}


.utilityIcon:hover, .ringIcon:hover {
    transform: scale(1.15);
}


.ringIcon:last-of-type {
    margin-left: 30px;
    background-color: #885454;
    transition: all ease-in-out 100ms;
}
.ringIcon img {
    width: 25px;
}
.utilityIcon img {
    width: 15px;
}
</style>
