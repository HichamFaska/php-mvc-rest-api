import buttonComponent from "./buttonComponent.js"

function postFormModal(){
    return `<div class="modal fade" id="modalId" tabindex="-1"
            data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">

            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Ajouter un nouveau post
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre</label>
                                <input type="text" name="title"
                                    class="form-control" id = "title"
                                    placeholder="Le titre du post" required>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Contenu</label>
                                <textarea rows="10" id="content" name="content" id = "content"
                                        class="form-control" required></textarea>
                            </div>

                            ${buttonComponent("poster", `<i class="fa-regular fa-paper-plane"></i>`, "addFromModal")}
                        </form>
                    </div>

                </div>
            </div>
        </div>`
}

export default postFormModal