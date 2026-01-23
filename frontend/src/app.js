import Post from "./models/Post.js"
import PostListComponent from "./components/PostListComponent.js"

const postsContainer = document.getElementById("Posts")

async function renderPosts(){
    const result = await Post.getAll()

    if(!result.success){
        postsContainer.innerHTML = `
            <div class = "alert alert-danger">
                ${result.message}
            </div>`
        return
    }

    postsContainer.innerHTML = PostListComponent(result.posts)
}

renderPosts()

