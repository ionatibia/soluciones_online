<template>
    <div>
        <div class="row justify-content-center">
            <div
                class="card serviceCard mb-3"
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
                                        ? 'bi bi-eye h3 text-success'
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
                    <div>{{ item.price }}</div>
                </div>
                <div class="card-footer">
                    <div class="row my-2">
                        <div class="col-md-6 text-center">
                            <button
                                type="button"
                                class="btn btn-danger"
                                style="width: 50%"
                                @click="destroyService(item)"
                            >
                                <i class="bi bi-trash h4"></i>
                            </button>
                        </div>
                        <div class="col-md-6 text-center">
                            <button
                                type="button"
                                class="btn btn-primary"
                                style="width: 50%"
                                @click="goToEdit(item)"
                            >
                                <i class="bi bi-three-dots h4"></i>
                            </button>
                        </div>
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
        this.getServices(this.onlymine);
    },
    methods: {
        getServices(onlyMine) {
            const self = this;
            let url;
            if (onlyMine) {
                url = "/home/services";
            } else {
                url = "services";
            }
            axios.get(url).then((res) => {
                self.services = res.data.data;
            });
        },
        goToEdit(service) {
            window.location.href = "/home/edit/" + service.id;
        },
        destroyService(service) {
            const self = this;
            axios.delete("/home/destroy/" + service.id).then(() => {
                self.getServices(self.onlymine);
            });
        },
    },
};
</script>

<style lang="scss" scoped>
.serviceCard {
    width: 400px;
    height: 565px;
    margin: auto;
    padding: 0;
}
</style>
