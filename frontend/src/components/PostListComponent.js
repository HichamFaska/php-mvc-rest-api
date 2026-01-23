import timestampFormater from "../helpers/timestampFormater.js";

export default function PostListComponent(posts) {
    if (!posts || posts.length === 0) {
        return `
            <div class="alert alert-warning text-center">
                Aucun post trouvé
            </div>
        `;
    }

    return `
        <div class="row g-4">
            ${posts.map(post => `
                    <div class="card h-100 shadow-sm">

                        <div class="card-body d-flex flex-column">

                            <!-- Header -->
                            <div class="mb-2">
                                <div class = "d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-1">${post.title}</h5>
                                    <div class="text-end mt-2" style = "font-size:12px;">
                                        <i class="far fa-clock"></i>
                                        ${timestampFormater(post.created_at)}
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <p class="card-text flex-grow-1">
                                ${post.content}
                            </p>

                            <!-- Actions -->
                            <div class="d-flex justify-content-start align-items-center border-top pt-2 mt-3">

                                <button class="btn btn text-dark">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span class="ms-1">${post.likes ?? 0}</span>
                                </button>

                                <button class="btn btn text-dark">
                                    <i class="fas fa-comment"></i>
                                    <span class="ms-1">${post.comments ?? 0}</span>
                                </button>

                                <button class="btn btn text-dark">
                                    <i class="fas fa-share"></i>
                                </button>

                            </div>

                            <!-- Footer -->
                            

                        </div>
                    </div>
                
            `).join("")}
        </div>
    `;
}
