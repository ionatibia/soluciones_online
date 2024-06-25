<template>
    <div>
        <div
            class="modal fade"
            id="createServiceModal"
            tabindex="-1"
            aria-labelledby="createServiceModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1
                            class="modal-title fs-5"
                            id="createServiceModalLabel"
                        >
                            Create new service
                        </h1>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form
                            action="/home/services"
                            method="post"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            <div class="row mb-3">
                                <label
                                    for="name"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Name</label
                                >

                                <div class="col-md-6">
                                    <input
                                        id="name"
                                        type="text"
                                        class="form-control"
                                        name="name"
                                        required
                                        autocomplete="name"
                                        autofocus
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="description"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Description</label
                                >

                                <div class="col-md-6">
                                    <input
                                        id="description"
                                        type="text"
                                        class="form-control"
                                        name="description"
                                        required
                                        autocomplete="description"
                                        autofocus
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="image"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Image</label
                                >

                                <div class="col-md-6">
                                    <input
                                        id="image"
                                        type="file"
                                        class="form-control"
                                        name="image"
                                        @change="previewImg(this)"
                                    />
                                </div>
                            </div>
                            <div class="mb-3 text-center">
                                <img
                                    class="rounded-circle"
                                    id="preview"
                                    width="100"
                                    height="100"
                                    src="/assets/services/default.webp"
                                    alt=""
                                />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CreateService",
    methods: {
        previewImg(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    let elem = document.getElementById("preview");
                    console.log(elem);
                    elem.src = e.target.result;
                    elem.with = "100px";
                };
                reader.readAsDataURL(input.files[0]);
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
