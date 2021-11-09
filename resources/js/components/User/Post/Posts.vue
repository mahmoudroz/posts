<template>
    <div v-if="token">
        <div class="container">
            <router-link
                class="btn btn-danger m-2 text-right"
                to="/createPost"
                >{{ dataPosts.create_post }}</router-link
            >

            <div v-for="post in posts.data" :key="post.id">
                <div class="card m-2">
                    <h5 v-if="lang === 'en'" class="card-header">
                        {{ post.title_en }}
                    </h5>
                    <h5 v-else class="card-header">{{ post.title_ar }}</h5>
                    <div class="card-body">
                        <p v-if="lang === 'en'" class="card-text">
                            {{ post.body_en }}
                        </p>
                        <p v-else class="card-text">{{ post.body_ar }}</p>
                        <!-- Button trigger modal -->
                        <button
                            type="button"
                            @click="editPost(post)"
                            class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#exampleModal"
                            v-text="dataPosts.edit_post"
                        ></button>
                        <button
                            type="button"
                            @click="deletePost(post.id)"
                            class="btn btn-dark"
                            v-text="dataPosts.delete_post"
                        ></button>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div
                class="modal fade"
                id="exampleModal"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5
                                class="modal-title"
                                id="exampleModalLabel"
                                v-text="dataPosts.update_post"
                            ></h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label
                                v-text="dataPosts.title_en"
                                class="text-center btn-primary btn-block"
                            ></label>
                            <input
                                type="text"
                                class="form-control m-1"
                                v-model="post.title_en"
                            />
                            <span v-if="errors.title_en">{{
                                errors.title_en[0]
                            }}</span>

                            <label
                                v-text="dataPosts.title_ar"
                                class="text-center btn-primary btn-block"
                            ></label>
                            <input
                                type="text"
                                class="form-control m-1"
                                v-model="post.title_ar"
                            />
                            <span v-if="errors.title_ar">{{
                                errors.title_ar[0]
                            }}</span>

                            <label
                                v-text="dataPosts.body_en"
                                class="text-center btn-primary btn-block"
                            ></label>
                            <input
                                type="text"
                                class="form-control m-1"
                                v-model="post.body_en"
                            />
                            <span v-if="errors.body_en">{{
                                errors.body_en[0]
                            }}</span>

                            <label
                                v-text="dataPosts.body_ar"
                                class="text-center btn-primary btn-block"
                            ></label>
                            <input
                                type="text"
                                class="form-control m-1"
                                v-model="post.body_ar"
                            />
                            <span v-if="errors.body_ar">{{
                                errors.body_ar[0]
                            }}</span>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                                v-text="dataPosts.close"
                            ></button>
                            <button
                                type="button"
                                @click="updatePost(post)"
                                class="btn btn-primary"
                                v-text="dataPosts.update_post"
                            ></button>
                        </div>
                    </div>
                </div>
            </div>
            <pagination
                :data="posts"
                @pagination-change-page="getPosts"
            ></pagination>
        </div>
    </div>
    <div v-else>
        <div
            class="alert alert-primary m-4"
            role="alert"
            v-text="dataPosts.have_token"
        ></div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            token: "",
            post: {
                id: "",
                title_en: "",
                title_ar: "",
                body_en: "",
                body_ar: "",
            },
            dataPosts: {
                edit_post: "",
                delete_post: "",
                title_en: "",
                title_ar: "",
                body_en: "",
                body_ar: "",
                close: "",
                update_post: "",
                have_token: "",
            },
            errors: [],
            posts: {},
            lang: "",
        };
    },
    methods: {
        getToken: function () {
            let user_token = localStorage.getItem("user_token");
            this.token = !!user_token;
        },
        showLanguage: function () {
            let lang = localStorage.getItem("lang");
            if (lang === "ar") {
                this.dataPosts = {
                    delete_post: "مسح المقال",
                    edit_post: "تعديل المقال",
                    title_en: "العنوان بالانجليزي",
                    title_ar: "العنوان بالعربي",
                    body_en: "المحتوي بالانجليزي",
                    body_ar: "المحتوي بالعربي",
                    close: "اغلاق",
                    update_post: "تحديث المقال",
                    create_post: "انشاء المقال",
                    have_token: "يجب ان تسجل الدخول",
                };
            } else {
                this.dataPosts = {
                    delete_post: "Delete Post",
                    edit_post: "Edit Post",
                    title_en: "Title in English",
                    title_ar: "Title in Arabic",
                    body_en: "Content in English",
                    body_ar: "Content in Arabic",
                    close: "close",
                    update_post: "Update Post",
                    create_post: "Create Post",
                    have_token: "you should login",
                };
            }
        },
        getPosts: function (page = 1) {
            if (this.token) {
                let lang = localStorage.getItem("lang");
                let token = localStorage.getItem("user_token");
                axios
                    .get(
                        "api/getPosts?lang=" +
                            lang +
                            "&token=" +
                            token +
                            "&page=" +
                            page
                    )
                    .then((response) => {
                        if (response.data.status === "success") {
                            this.posts = response.data.data;
                            this.lang = localStorage.getItem("lang");
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: "error",
                            });
                        }
                    });
            }
        },
        editPost: function (p) {
            this.post = p;
        },
        updatePost: function (post) {
            let lang = localStorage.getItem("lang");
            let token = localStorage.getItem("user_token");
            axios
                .post(
                    "api/updatePost/" +
                        post.id +
                        "?lang=" +
                        lang +
                        "&token=" +
                        token,
                    post
                )
                .then((response) => {
                    if (response.data.status === "success") {
                        Toast.fire({
                            icon: "success",
                            title: "update successfully",
                        });
                        this.post = {
                            title_en: "",
                            title_ar: "",
                            body_ar: "",
                            body_en: "",
                        };
                        this.errors = "";
                    } else {
                        this.errors = response.data.errors;
                    }
                });
        },
        deletePost: function (id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    let lang = localStorage.getItem("lang");
                    let token = localStorage.getItem("user_token");
                    axios
                        .post(
                            "api/deletePost/" +
                                id +
                                "?lang=" +
                                lang +
                                "&token=" +
                                token
                        )
                        .then((response) => {
                            if (response.data.status === "success") {
                                this.getPosts();
                                Swal.fire(
                                    "Deleted!",
                                    "Your file has been deleted.",
                                    "success"
                                );
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: "Error",
                                });
                            }
                        });
                }
            });
        },
    },
    created() {
        this.getToken();
        this.showLanguage();
        this.getPosts();
    },
};
</script>
