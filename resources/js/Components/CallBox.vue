
<template>
    <div>
        <video ref="localVideo" autoplay playsinline></video>
        <video ref="remoteVideo" autoplay playsinline></video>
        <button @click="startCall">Start Call</button>
        <button @click="hangUp">Hang Up</button>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import Echo from 'laravel-echo';

const localVideo = ref(null);
const remoteVideo = ref(null);
const localStream = ref(null);
const peerConnection = ref(null);

const signalingChannel = new Echo({
    broadcaster: 'pusher',
    key: process.env.VUE_APP_PUSHER_APP_KEY,
    cluster: process.env.VUE_APP_PUSHER_APP_CLUSTER,
    encrypted: true,
});

const startCall = async () => {
    const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
    localStream.value = stream;
    localVideo.value.srcObject = stream;

    peerConnection.value = new RTCPeerConnection({
        iceServers: [{ urls: 'stun:stun.l.google.com:19302' }],
    });

    stream.getTracks().forEach(track => peerConnection.value.addTrack(track, stream));

    peerConnection.value.onicecandidate = event => {
        if (event.candidate) {
            sendSignal('candidate', event.candidate);
        }
    };

    peerConnection.value.ontrack = event => {
        remoteVideo.value.srcObject = event.streams[0];
    };

    const offer = await peerConnection.value.createOffer();
    await peerConnection.value.setLocalDescription(offer);

    sendSignal('offer', offer);
};

const sendSignal = (type, data) => {
    signalingChannel.private(`webrtc.${targetUserId}`).whisper('signal', {
        type,
        data,
        from: currentUserId,
        to: targetUserId,
    });
};

const hangUp = () => {
    if (peerConnection.value) {
        peerConnection.value.close();
        peerConnection.value = null;
    }
};

const handleSignal = async (signal) => {
    const { type, data } = signal;

    if (type === 'offer') {
        await peerConnection.value.setRemoteDescription(new RTCSessionDescription(data));
        const answer = await peerConnection.value.createAnswer();
        await peerConnection.value.setLocalDescription(answer);
        sendSignal('answer', answer);
    } else if (type === 'answer') {
        await peerConnection.value.setRemoteDescription(new RTCSessionDescription(data));
    } else if (type === 'candidate') {
        await peerConnection.value.addIceCandidate(new RTCIceCandidate(data));
    }
};

onMounted(() => {
    signalingChannel.private(`webrtc.${currentUserId}`).listenForWhisper('signal', handleSignal);
});

onBeforeUnmount(() => {
    if (peerConnection.value) {
        peerConnection.value.close();
    }
    signalingChannel.leave(`webrtc.${currentUserId}`);
});
</script>

<style scoped>
video {
    width: 300px;
    height: 200px;
    background-color: black;
    margin: 5px;
}

button {
    margin-top: 10px;
    padding: 10px;
    font-size: 16px;
}
</style>

