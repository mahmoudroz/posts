<template>
    <div class="container">
        <table class="table">
            <caption>
                List of users
            </caption>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" v-text="name"></th>
                    <th scope="col" v-text="email"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <th scope="row" v-text="user.id"></th>
                    <td v-text="user.name"></td>
                    <td v-text="user.email"></td>
                    <td
                        class="btn btn-danger m-1 btn-sm"
                        @click="deleteUser(user.id)"
                        v-text="delete_user"
                    ></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            users: {},
            name: "",
            email: "",
            delete_user: "",
        };
    },
    methods: {
        getUsers: function () {
            let token = localStorage.getItem("admin_token");
            let lang = localStorage.getItem("lang");
            axios
                .get("admin-api/getUsers?token=" + token + "&lang=" + lang)
                .then((response) => {
                    if (response.data.status === "success") {
                        this.users = response.data.data;
                        this.lang = localStorage.getItem("lang");
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: "error",
                        });
                    }
                });
        },
        deleteUser: function (id) {
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
                    let token = localStorage.getItem("admin_token");
                    axios
                        .post(
                            "admin-api/deleteUser/" +
                                id +
                                "?lang=" +
                                lang +
                                "&token=" +
                                token
                        )
                        .then((response) => {
                            if (response.data.status === "success") {
                                this.getUsers();
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
        showLanguage: function () {
            let lang = localStorage.getItem("lang");
            if (lang === "en") {
                this.name = "name";
                this.email = "email";
                this.delete_user = "deleteUser";
            } else {
                this.name = "الاسم";
                this.email = "الايميل";
                this.delete_user = "حذف المستخدم";
            }
        },
    },
    created() {
        this.showLanguage();
        this.getUsers();
    },
};
</script>
<style scoped lang="scss"></style>
