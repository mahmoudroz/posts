<template>
    <div class="container">
        <label
            v-text="dataPosts.title_en"
            class="text-center btn-primary btn-block"
        ></label>
        <input type="text" class="form-control m-1" v-model="post.title_en" />
        <span v-if="errors.title_en">{{ errors.title_en[0] }}</span>

        <label
            v-text="dataPosts.title_ar"
            class="text-center btn-primary btn-block"
        ></label>
        <input type="text" class="form-control m-1" v-model="post.title_ar" />
        <span v-if="errors.title_ar">{{ errors.title_ar[0] }}</span>

        <label
            v-text="dataPosts.body_en"
            class="text-center btn-primary btn-block"
        ></label>
        <input type="text" class="form-control m-1" v-model="post.body_en" />
        <span v-if="errors.body_en">{{ errors.body_en[0] }}</span>

        <label
            v-text="dataPosts.body_ar"
            class="text-center btn-primary btn-block"
        ></label>
        <input type="text" class="form-control m-1" v-model="post.body_ar" />
        <span v-if="errors.body_ar">{{ errors.body_ar[0] }}</span>
        <button
            @click="createPost"
            class="btn badge-danger btn-block"
            v-text="dataPosts.create_post"
        ></button>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            // data post store
            post: {
                title_en: "",
                title_ar: "",
                body_en: "",
                body_ar: "",
            },
            errors: [],
            // label post data
            dataPosts: {
                title_en: "",
                title_ar: "",
                body_en: "",
                body_ar: "",
                create_post: "",
            },
        };
    },
    methods: {
        showLanguage: function () {
            let lang = localStorage.getItem("lang");
            if (lang === "ar") {
                this.dataPosts = {
                    title_en: "العنوان بالانجليزي",
                    title_ar: "العنوان بالعربي",
                    body_en: "المحتوي بالانجليزي",
                    body_ar: "المحتوي بالعربي",
                    close: "اغلاق",
                    create_post: "انشاء المقال",
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
                    create_post: "Create Post",
                };
            }
        },
        createPost: function () {
            let lang = localStorage.getItem("lang");
            let token = localStorage.getItem("user_token");
            axios
                .post(
                    "api/createPost?lang=" + lang + "&token=" + token,
                    this.post
                )
                .then((response) => {
                    if (response.data.status === "success") {
                        Toast.fire({
                            icon: "success",
                            title: "Signed in successfully",
                        });
                        this.errors = [];
                        this.post = [];
                    } else {
                        this.errors = response.data.errors;
                    }
                });
        },
    },
    created() {
        this.showLanguage();
    },
};
</script>
