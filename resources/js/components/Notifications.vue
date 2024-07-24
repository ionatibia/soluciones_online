<template>
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="dropdown">
                <i
                    :class="
                        notifications.length > 0
                            ? 'bi bi-bell h3 position-relative mb-0 text-primary'
                            : 'bi bi-bell h3 position-relative mb-0 text-secondary'
                    "
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    id="dropdownMenuButton"
                    type="button"
                >
                    <span
                        v-if="notifications.length > 0"
                        class="position-absolute top-300 start-100 translate-middle badge rounded-pill bg-danger"
                        style="font-size: 0.7rem"
                    >
                        1
                    </span>
                </i>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <div
                        v-if="notifications.length === 0"
                        class="dropdown-item"
                    >
                        No notifications
                    </div>
                    <div
                        v-else
                        v-for="(item, i) in notifications"
                        :key="i"
                        class="dropdown-item"
                    >
                        <div
                            class="dropdown-item"
                            @click="goToDetail()"
                            type="button"
                        >
                            New chat on {{ item.service.title }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div v-for="(item, i) in notifications" :key="i">
            <button class="btn btn-primary" @click="goToDetail(item, i)">
                Ver
            </button>
        </div> -->
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
            window.location.href = "/services/detail/" + 1;
        },
    },
};
</script>

<style lang="scss" scoped></style>
