<template>
    <div>
        <div v-if="messages !== null" class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="chat">
                    <div
                        v-for="(message, m) in messages"
                        :key="m"
                        :class="
                            message.from_obj.id === user.id
                                ? 'myMessage message'
                                : 'othersMessage message'
                        "
                    >
                        <div v-if="message.from_obj.id === user.id" class="row">
                            <div class="col-md-10 text-start">
                                <span>{{ message.text }}</span>
                                <br />
                                <span style="font-size: smaller">{{
                                    getDate(message)
                                }}</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <img
                                    class="rounded-circle"
                                    width="40"
                                    height="40"
                                    :src="message.from_obj.avatar"
                                    alt="avatar"
                                />
                            </div>
                        </div>
                        <div v-else class="row">
                            <div class="col-md-2 text-center">
                                <img
                                    class="rounded-circle"
                                    width="40"
                                    height="40"
                                    :src="message.from_obj.avatar"
                                    alt="avatar"
                                />
                            </div>
                            <div class="col-md-10 text-start">
                                <span>{{ message.text }}</span>
                                <br />
                                <span style="font-size: smaller">{{
                                    getDate(message)
                                }}</span>
                            </div>
                        </div>
                    </div>
                    <div v-if="sending" class="myMessage message">
                        <div class="row">
                            <div class="col-md-10 text-start">
                                <div class="progress">
                                    <div
                                        class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar"
                                        aria-valuenow="100"
                                        aria-valuemin=""
                                        aria-valuemax="100"
                                        style="width: 100%"
                                    ></div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <img
                                    class="rounded-circle"
                                    width="40"
                                    height="40"
                                    src="/assets/avatars/default.jpg"
                                    alt="avatar"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <form>
                    <div class="input-group mb-3">
                        <input
                            type="text"
                            class="form-control mb-3"
                            v-model="text"
                            placeholder="Message..."
                        />
                        <div class="input-group-append">
                            <button
                                type="submit"
                                class="btn btn-outline-primary"
                                @click="sendMessage()"
                                :disabled="text === ''"
                            >
                                Send
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>

        <!-- Pagination -->
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <ul
                    v-if="pagination_data && pagination_data.last_page > 1"
                    class="pagination justify-content-center"
                >
                    <li
                        class="page-item"
                        v-show="pagination_data['prev_page_url']"
                    >
                        <a
                            href="#"
                            class="page-link"
                            @click.prevent="getPreviousPage"
                        >
                            <span>
                                <span aria-hidden="true">«</span>
                            </span>
                        </a>
                    </li>
                    <li
                        class="page-item"
                        :class="{
                            active: pagination_data['current_page'] === n,
                        }"
                        v-for="n in pagination_data['last_page']"
                        :key="n"
                    >
                        <a
                            href="#"
                            class="page-link"
                            @click.prevent="getPage(n)"
                        >
                            <span>
                                {{ n }}
                            </span>
                        </a>
                    </li>
                    <li
                        class="page-item"
                        v-show="pagination_data['next_page_url']"
                    >
                        <a
                            href="#"
                            class="page-link"
                            @click="
                                getNextPage(pagination_data['next_page_url'])
                            "
                        >
                            <span>
                                <span aria-hidden="true">»</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Loading -->
        <div v-if="messages === null">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="progress">
                        <div
                            class="progress-bar progress-bar-striped progress-bar-animated"
                            role="progressbar"
                            aria-valuenow="100"
                            aria-valuemin=""
                            aria-valuemax="100"
                            style="width: 100%"
                        ></div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
export default {
    name: "chat",
    data() {
        return {
            text: "",
            messages: null,
            pagination_data: null,
            local_chat: null,
            sending: false,
        };
    },
    props: {
        user: {
            type: Object,
            default: null,
        },
        service: {
            type: Object,
            default: null,
        },
        chat: {
            type: Object,
            default: null,
        },
    },
    async mounted() {
        this.local_chat = this.chat;
        if (this.local_chat) {
            this.connect();
        }
        await this.getMessages();
    },
    methods: {
        async sendMessage() {
            this.sending = true;
            const self = this;
            if (self.user.id === self.service.user_id) {
                self.to = self.local_chat.user_id;
            } else {
                self.to = self.service.user_id;
            }
            const message = self.text;
            self.text = "";
            try {
                await axios
                    .post("/message", {
                        text: message,
                        to: self.to,
                        chat_id: self.local_chat ? self.local_chat.id : null,
                        service_id: self.service.id,
                    })
                    .then(async (res) => {
                        if (!self.local_chat) {
                            self.local_chat = res.data.chat;
                            self.connect();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        async getMessages() {
            const self = this;
            if (!self.local_chat) {
                self.messages = [];
                return;
            }
            console.log(self.local_chat.id);
            const response = await axios.get("/messages/" + self.local_chat.id);
            self.sending = false;
            if (response.status === 200) {
                self.messages = response.data.data;
                delete response.data.data;
                self.pagination_data = response.data;
            }
        },
        connect() {
            const self = this;
            Echo.private("servicios." + this.local_chat.id).listen(
                "GotMessage",
                async (e) => {
                    self.text = "";
                    await self.getMessages();
                }
            );
        },
        getPage(page) {
            const self = this;
            axios
                .get("/messages/" + self.local_chat.id + "?page=" + page)
                .then((response) => {
                    if (response.status === 200) {
                        self.messages = response.data.data;
                        delete response.data.data;
                        self.pagination_data = response.data;
                    }
                });
        },
        getPreviousPage() {
            const self = this;
            axios
                .get(this.pagination_data["prev_page_url"])
                .then((response) => {
                    if (response.status === 200) {
                        self.messages = response.data.data;
                        delete response.data.data;
                        self.pagination_data = response.data;
                    }
                });
        },
        getNextPage(url) {
            const self = this;
            axios
                .get(this.pagination_data["next_page_url"])
                .then((response) => {
                    if (response.status === 200) {
                        self.messages = response.data.data;
                        delete response.data.data;
                        self.pagination_data = response.data;
                    }
                });
        },
        getDate(message) {
            return moment(String(message.created_at)).format("LLL");
        },
    },
};
</script>

<style lang="scss" scoped>
.myMessage {
    /* text-align: right; */
    /* color: green; */
    background-color: aquamarine;
}
.othersMessage {
    /* text-align: left; */
    /* color: grey; */
    background-color: rgb(194, 194, 194);
}
.message {
    border: 1px solid rgb(153, 153, 153);
    border-radius: 15px;
    padding: 8px;
    margin: 9px auto 8px auto;
}
</style>
