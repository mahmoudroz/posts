<template>
    <div class="container">
        <div class="row">
            <div class="col-10">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="#">{{ langPage.navbar }}</a>
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div
                        class="collapse navbar-collapse"
                        id="navbarSupportedContent"
                    >
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <router-link
                                        to="/registerUser"
                                        class="route"
                                        >{{
                                            langPage.registerUser
                                        }}</router-link
                                    >
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <router-link
                                        to="/loginUser"
                                        class="route"
                                        >{{ langPage.loginUser }}</router-link
                                    >
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <router-link
                                        to="/loginAdmin"
                                        class="route"
                                        >{{ langPage.loginAdmin }}</router-link
                                    >
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <router-link to="/posts" class="route">{{
                                        langPage.posts
                                    }}</router-link>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span @click="logoutUser" class="route">
                                        {{ langPage.logout }}</span
                                    >
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="col-2">
                <select
                    v-model="lang"
                    @click="changeLanguage()"
                    class="btn btn-primary m-2"
                >
                    <optgroup label="language"></optgroup>
                    <option value="en" selected>English</option>
                    <option value="ar">Arabic</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            lang: "",
            lang1: "",
            token: "",
            langPage: {
                navbar: "",
                registerUser: "",
                loginUser: "",
                loginAdmin: "",
                posts: "",
                logout: "",
            },
        };
    },
    methods: {
        getToken: function () {
            let admin_token = localStorage.getItem("admin_token");
            let user_token = localStorage.getItem("user_token");
            this.token = !!(admin_token || user_token);
        },
        changeLanguage: function () {
            localStorage.setItem("lang", this.lang);
            this.showLanguage();
            if (this.lang1 !== this.lang) {
                this.$router.push("MyContent");
                this.lang1 = this.lang;
            }
        },
        showLanguage: function () {
            let lang = localStorage.getItem("lang");
            if (lang === "ar") {
                this.langPage = {
                    navbar: "شريط التنقل",
                    registerUser: "تسجيل مستخدم جديد",
                    loginUser: "تسجيل دخول المستخدم",
                    loginAdmin: "تسجيل دخول المشرف",
                    posts: "المقالات",
                    logout: "تسجيل الخروج",
                };
            } else {
                this.langPage = {
                    navbar: "Navbar",
                    registerUser: "RegisterUser",
                    loginUser: "LoginUser",
                    loginAdmin: "LoginAdmin",
                    posts: "Posts",
                    logout: "Logout",
                };
            }
        },
        showLogin: function () {
            this.$router.push("LoginUser");
        },
        logoutUser: function () {
            let admin_token = localStorage.getItem("admin_token");
            let user_token = localStorage.getItem("user_token");
            let lang = localStorage.getItem("lang");
            this.getToken();
            if (this.token) {
                if (admin_token) {
                    axios
                        .post(
                            "admin-api/logoutAdmin?lang=" +
                                lang +
                                "&token=" +
                                admin_token
                        )
                        .then((response) => {
                            if (response.data.status === "success") {
                                localStorage.setItem("admin_token", "");
                                this.getToken();
                                this.$router.push("LoginAdmin");
                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: "error",
                                });
                            }
                        });
                } else if (user_token) {
                    axios
                        .post(
                            "api/logoutUser?token=" +
                                user_token +
                                "&lang=" +
                                lang
                        )
                        .then((response) => {
                            if (response.data.status === "success") {
                                localStorage.setItem("user_token", "");
                                this.getToken();
                                this.$router.push("LoginUser");
                            }
                        });
                } else {
                    Toast.fire({
                        icon: "error",
                        title: "error",
                    });
                }
            }
        },
    },
    created() {
        this.changeLanguage();
        this.showLogin();
    },
    updated() {
        this.showLogin();
    },
};
</script>
<style scoped lang="scss">
.route {
    color: rgba(0, 0, 0, 0.5);
    text-decoration: none;
}
.route:hover {
    color: rgba(0, 0, 0, 0.9);
}
.dropdown {
    margin-top: 12px;
    margin-left: 176px;
}
</style>
