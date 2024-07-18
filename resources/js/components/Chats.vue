<template>
    <div>
        <div v-if="unique">
            <div v-if="chats[0]" class="row">
                {{ chats[0] }}
            </div>
            <div class="row">
                <input type="text" v-model="text" />
                <button class="btn btn-primary" @click="sendMessage()">
                    Send
                </button>
            </div>
        </div>
        <div v-else></div>
    </div>
</template>

<script>
export default {
    name: "chats",
    data() {
        return {
            text: "",
            inizialited: false,
            chat_id: null,
            unique: true,
            to: null,
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
        chats: {
            type: Array,
            default: [],
        },
    },
    async beforeMount() {
        if (this.user.id === this.service.user_id) this.unique = false;
        await this.getMessages();
    },
    methods: {
        async sendMessage() {
            const self = this;
            if (self.user.id === self.service.user_id) {
                for (let c = 0; c < self.chats.length; c++) {
                    if (self.chats[c].id === self.chat_id) {
                        self.to = self.chats[c].user_id;
                    }
                }
            } else {
                self.to = self.service.user_id;
            }
            try {
                await axios
                    .post("/message", {
                        text: self.text,
                        to: self.to,
                        chat_id: self.chat_id,
                        service_id: self.service.id,
                    })
                    .then(async (res) => {
                        if (self.unique && self.chats.length === 0) {
                            self.chats = res.data.chat;
                        }
                        await getMessages();
                    });
            } catch (error) {
                console.log(error);
            }
        },
        async getMessages() {
            const self = this;
            for (let i = 0; i < self.chats.length; i++) {
                if (!self.chats[i].id) continue;
                const response = await axios.get(
                    "/messages/" + self.chats[i].id
                );
                if (response.status === 200) {
                    self.chats[i].messages = response.data.data;
                    delete response.data.data;
                    self.chats[i].pagination_data = response.data;
                }
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
