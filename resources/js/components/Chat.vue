<template>
    <div>
        <div v-if="messages" class="row">
            {{ messages.length }}
        </div>
        <div class="row">
            <input type="text" v-model="text" />
            <button class="btn btn-primary" @click="sendMessage()">Send</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "chat",
    data() {
        return {
            text: "",
            messages: null,
            pagination_data: null,
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
    async beforeMount() {
        if (this.chat) {
            this.connect();
        }
        await this.getMessages();
    },
    methods: {
        async sendMessage() {
            const self = this;
            if (self.user.id === self.service.user_id) {
                self.to = self.chat.user_id;
            } else {
                self.to = self.service.user_id;
            }
            try {
                await axios
                    .post("/message", {
                        text: self.text,
                        to: self.to,
                        chat_id: self.chat ? self.chat.id : null,
                        service_id: self.service.id,
                    })
                    .then(async (res) => {
                        if (!self.chat) {
                            self.chat = res.data.chat;
                            self.connect();
                        }
                        /* await self.getMessages(); */
                    });
            } catch (error) {
                console.log(error);
            }
        },
        async getMessages() {
            const self = this;
            if (!self.chat) return;
            const response = await axios.get("/messages/" + self.chat.id);
            if (response.status === 200) {
                self.messages = response.data.data;
                delete response.data.data;
                self.pagination_data = response.data;
            }
        },
        connect() {
            const self = this;
            Echo.private("servicios." + this.chat.id).listen(
                "GotMessage",
                async (e) => {
                    console.log(e);
                    self.text = "";
                    await self.getMessages();
                }
            );
        },
    },
};
</script>

<style lang="scss" scoped></style>
