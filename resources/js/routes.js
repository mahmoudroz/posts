import LoginAdmin from "./components/Admin/LoginAdmin";
import ContentAdmin from "./components/Admin/ContentAdmin";
import LoginUser from "./components/User/LoginUser";
import RegisterUser from "./components/User/RegisterUser";
import Posts from "./components/User/Post/Posts";
import CreatePost from "./components/User/Post/CreatePost";
const routes = [
    /////////////////  begin Admin Routes /////////////
    {
        path: '/loginAdmin',
        component: LoginAdmin,
        name: 'LoginAdmin'
    },
    {
        path: '/contentAdmin',
        component: ContentAdmin,
        name: 'ContentAdmin'
    },
    /////////////////  end Admin Routes ///////////////
    /////////////////  begin posts Routes /////////////
    {
        path: '/posts',
        component: Posts,
        name: 'Posts'
    },
    {
        path: '/createPost',
        component: CreatePost,
        name: 'CreatePosts'
    },
    /////////////////  end posts Routes //////////////
    /////////////////  begin User Routes /////////////
    {
        path: '/registerUser',
        component: RegisterUser,
        name: RegisterUser
    },
    {
        path: '/loginUser',
        component: LoginUser,
        name: LoginUser
    },
    /////////////////  end User Routes /////////////

]
export default routes
