import Post from "./models/Post.js"
import PostListComponent from "./components/PostListComponent.js"
import postFormModal from "./components/postFormModal.js"

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

function renderForm() {
    const container = document.querySelector(".container")
    container.insertAdjacentHTML("beforeend", postFormModal())

    const modalElement = document.getElementById("modalId")
    const modal = new bootstrap.Modal(modalElement)
    attachAddPostEvent(modal)
}

renderForm()

function attachAddPostEvent(modal) {
    const btn = document.querySelector("#addFromModal")

    btn.addEventListener("click", async (event) => {
        event.preventDefault()
        const title = document.querySelector("#title").value.trim()
        const content = document.querySelector("#content").value.trim()

        if (!title || !content) {
            alert("Tous les champs sont requis")
            return
        }

        const result = await Post.add(1, title, content)

        if (result.erreur) {
            alert(result.message)
            return
        }

        modal.hide()
        renderPosts()
    })
}



