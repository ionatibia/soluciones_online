<template>
    <div>
        <div class="row justify-content-center">
            <div
                class="card serviceCard"
                v-for="(item, i) in services"
                :key="i"
            >
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5
                                class="card-title text-primary font-weight-bold"
                            >
                                {{ item.title }}
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <i
                                :class="
                                    item.is_published
                                        ? 'bi bi-eye h3'
                                        : 'bi bi-eye-slash h3'
                                "
                            ></i>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div>
                        <img :src="item.img_src" alt="" class="img-fluid" />
                    </div>
                    <div>
                        <p style="text-align: justify">
                            {{ item.description.slice(0, 255) + "..." }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "Services",
    props: {
        onlymine: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            services: null,
        };
    },
    beforeMount() {
        this.getServices(this.onlyMine);
    },
    methods: {
        getServices(onlyMine) {
            const self = this;
            axios.get("/home/services").then((res) => {
                self.services = res.data.data;
            });
        },
    },
};
</script>

<style lang="scss" scoped>
.serviceCard {
    width: 400px;
    margin: auto;
    padding: 0;
}
</style>
