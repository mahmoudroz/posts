<template>
    <div v-if="token">
        <div class="btn btn-light btn-block m-1">{{ adminData.title }}</div>
        <div
            class="alert alert-secondary m-4"
            role="alert"
            v-text="adminData.have_token"
        ></div>
    </div>
    <div v-else class="container">
        <div class="btn btn-light btn-block m-1">{{ adminData.title }}</div>
        <label
            v-text="adminData.email"
            class="text-center btn-primary btn-block"
        ></label>
        <input type="text" class="form-control m-1" v-model="admin.email" />
        <label
            v-text="adminData.password"
            class="text-center btn-primary btn-block"
        ></label>
        <input
            type="password"
            class="form-control m-1"
            v-model="admin.password"
        />
        <button class="btn btn-dark m-1 btn-block" @click="loginAdmin">
            {{ adminData.login }}
        </button>
        <div v-if="errors" class="alert alert-danger">
            !!! {{ adminData.error }} !!!
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            // data admin login
            admin: {
                email: "",
                password: "",
            },
            errors: false,
            /// label trans
            adminData: {
                email: "",
                password: "",
                login: "",
                error: "",
                title: "",
                have_token: "",
            },
            token: "",
        };
    },
    methods: {
        getToken: function () {
            let admin_token = localStorage.getItem("admin_token");
            let user_token = localStorage.getItem("user_token");
            this.token = !!(admin_token || user_token);
        },
        showLanguage: function () {
            let lang = localStorage.getItem("lang");
            if (lang === "ar") {
                this.adminData = {
                    email: "الايميل",
                    password: "الباسورد",
                    login: "تسجيل الدخول",
                    error: "خطا",
                    title: "تسجيل دخول المشرف",
                    have_token: "سجل الخروج اولا",
                };
            } else {
                this.adminData = {
                    email: "email",
                    password: "password",
                    login: "Login",
                    error: "error",
                    title: "Login Admin",
                    have_token: "Logout First",
                };
            }
        },
        loginAdmin: function () {
            let lang = localStorage.getItem("lang");
            axios
                .post("admin-api/login?lang=" + lang, this.admin)
                .then((response) => {
                    if (response.data.status === "success") {
                        let token = response.data.admin.api_token;
                        localStorage.setItem("admin_token", token);
                        this.errors = false;
                        this.$router.push("ContentAdmin");
                    } else {
                        this.errors = true;
                    }
                })
                .catch((error) => {
                    error ? (this.errors = true) : false;
                });
        },
    },
    created() {
        this.getToken();
        this.showLanguage();
    },
};
</script>
<style scoped lang="scss"></style>
