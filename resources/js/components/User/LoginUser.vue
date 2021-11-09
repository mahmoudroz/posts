<template>
    <div class="container">
        <div v-if="token">
            <div class="btn btn-light btn-block m-1">{{ userData.title }}</div>
            <div
                class="alert alert-warning m-4"
                role="alert"
                v-text="userData.have_token"
            ></div>
        </div>
        <div v-else>
            <div class="btn btn-light btn-block m-1">{{ userData.title }}</div>
            <div v-if="error" class="error btn btn-danger btn-block">
                !!! {{ userData.error }} !!!
            </div>
            <label
                v-text="userData.email"
                class="text-center btn-primary btn-block"
            ></label>
            <input type="text" v-model="user.email" class="form-control m-1" />
            <label
                v-text="userData.password"
                class="text-center btn-primary btn-block"
            ></label>
            <input
                type="password"
                v-model="user.password"
                class="form-control m-1"
            />
            <button
                @click="loginUser"
                class="btn btn btn-dark btn-block m-1"
                v-text="userData.login"
            ></button>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            // user data login
            user: {
                email: "",
                password: "",
            },
            // label user trans
            userData: {
                email: "",
                password: "",
                login: "",
                error: "",
                title: "",
                have_token: "",
            },
            error: false,
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
                this.userData = {
                    email: "الايميل",
                    password: "الباسورد",
                    login: "تسجيل الدخول",
                    error: "خطا",
                    title: "تسجيل دخول المستخدم",
                    have_token: "سجل الخروج اولا",
                };
            } else {
                this.userData = {
                    email: "email",
                    password: "password",
                    login: "Login",
                    error: "error",
                    title: "Login User",
                    have_token: "Logout First",
                };
            }
        },
        loginUser: function () {
            let lang = localStorage.getItem("lang");
            axios
                .post("api/loginUser?lang=" + lang, this.user)
                .then((response) => {
                    if (response.data.status === "success") {
                        let user_token = response.data.user.api_token;
                        localStorage.setItem("user_token", user_token);
                        this.error = false;
                        this.$router.push("Posts");
                    } else {
                        this.error = true;
                    }
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
