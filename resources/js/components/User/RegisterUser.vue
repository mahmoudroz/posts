<template>
    <div class="container">
        <div v-if="token">
            <div class="btn btn-light btn-block m-1">{{ userData.title }}</div>
            <div
                class="alert alert-success m-4"
                role="alert"
                v-text="userData.have_token"
            ></div>
        </div>
        <div v-else>
            <label
                v-text="userData.name"
                class="text-center btn-primary btn-block"
            ></label>
            <input v-model="user.name" type="text" class="form-control m-1" />
            <span v-if="errors.name">{{ errors.name[0] }}</span>

            <label
                v-text="userData.email"
                class="text-center btn-primary btn-block"
            ></label>
            <input v-model="user.email" type="text" class="form-control m-1" />
            <span v-if="errors.email">{{ errors.email[0] }}</span>

            <label
                v-text="userData.password"
                class="text-center btn-primary btn-block"
            ></label>
            <input
                v-model="user.password"
                type="password"
                class="form-control m-1"
            />
            <span v-if="errors.password">{{ errors.password[0] }}</span>
            <button
                @click="registerUser"
                class="btn btn-danger btn-block text-center m-1"
                v-text="userData.register"
            ></button>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            token: "",
            // data user register
            user: {
                name: "",
                email: "",
                password: "",
            },
            errors: [],
            // label user trans
            userData: {
                name: "",
                email: "",
                password: "",
                register: "",
                title: "",
                have_token: "",
            },
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
                    name: "الاسم",
                    email: "الايميل",
                    password: "الباسورد",
                    register: "تسجيل",
                    title: "تسجيل مستخدم جديد",
                    have_token: "سجل الخروج اولا",
                };
            } else {
                this.userData = {
                    name: "name",
                    email: "email",
                    password: "password",
                    register: "register",
                    title: "Register User",
                    have_token: "Logout First",
                };
            }
        },
        registerUser: function () {
            let lang = localStorage.getItem("lang");
            axios
                .post("api/registerUser?lang=" + lang, this.user)
                .then((response) => {
                    if (response.data.status === "success") {
                        this.$router.push("LoginUser");
                    } else {
                        this.errors = response.data.errors;
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
