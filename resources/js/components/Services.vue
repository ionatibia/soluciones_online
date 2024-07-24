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
                                class="card-title text-primary font-weight-bold title"
                            >
                                {{ item.title }}
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <i
                                v-if="onlymine"
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
                    <div class="price text-center">{{ item.price }} $</div>
                </div>
                <div class="card-footer">
                    <div class="row my-2">
                        <div
                            v-if="onlymine || user.role === 'admin'"
                            :class="
                                onlymine
                                    ? 'col-md-4 text-center'
                                    : user.role === 'admin'
                                    ? 'col-md-6 text-center'
                                    : ''
                            "
                        >
                            <button
                                type="button"
                                class="btn btn-danger"
                                style="width: 80%"
                                @click="destroyService(item)"
                            >
                                <i class="bi bi-trash h4"></i>
                            </button>
                        </div>
                        <div v-if="onlymine" class="col-md-4 text-center">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                style="width: 80%"
                                @click="goToEdit(item)"
                            >
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </div>
                        <div
                            :class="
                                onlymine
                                    ? 'col-md-4 text-center'
                                    : user.role === 'admin'
                                    ? 'col-md-6 text-center'
                                    : 'col-md-12 text-center'
                            "
                        >
                            <button
                                type="button"
                                class="btn btn-primary"
                                :style="
                                    onlymine || user.role === 'admin'
                                        ? 'width: 80%'
                                        : 'width: 50%'
                                "
                                @click="goToDetail(item)"
                            >
                                <i class="bi bi-three-dots h4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="services && services.length === 0 && onlymine">
                No services, please create one
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <ul
                    v-if="pagination_data && pagination_data.last_page > 1"
                    class="pagination pagination-lg justify-content-center"
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
        user: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            services: null,
            pagination_data: null,
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
                url = "/services/list";
            }
            axios.get(url).then((res) => {
                self.services = res.data.data;
                self.pagination_data = res.data;
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
        goToDetail(service) {
            window.location.href = "/services/detail/" + service.id;
        },
        getPage(page) {
            const self = this;
            let url;
            if (this.onlymine) {
                url = "/home/services?page=" + page;
            } else {
                url = "/services/list?page=" + page;
            }
            axios.get(url).then((response) => {
                if (response.status === 200) {
                    self.services = response.data.data;
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
                        self.services = response.data.data;
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
                        self.services = response.data.data;
                        self.pagination_data = response.data;
                    }
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
