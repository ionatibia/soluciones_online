<template>
    <div>
        <div v-for="(item, i) in notifications" :key="i">
            <button class="btn btn-primary" @click="goToDetail(item)">
                Ver
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "notifications",
    data() {
        return {
            notifications: [],
        };
    },
    props: {
        user: {
            type: Object,
            default: null,
        },
    },
    beforeMount() {
        Echo.channel("newchat").listen("NewChat", async (e) => {
            console.log(e);
            if (e.message.from !== this.user.id) {
                this.notifications.push(e);
            }
        });
    },
    methods: {
        goToDetail(item) {
            window.location.href = "/services/detail/" + item.chat.service_id;
        },
    },
};
</script>

<style lang="scss" scoped></style>
