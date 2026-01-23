<?php
    
    namespace App\Http\Controllers;

    use App\Http\Request;
    use App\Http\Response;
    use App\Models\Post;
    use Exception;

    class PostController{
        
        private Post $post;
        private Request $request;
        private Response $response;

        public function __construct(Request $request){
            $this->post = new Post();
            $this->request = $request;
            $this->response = new Response();
        }

        public function index():void{
            try{
                $posts = $this->post->all();
                $this->response->json([
                    "success" => true,
                    "posts" => $posts
                ])->send();
            }
            catch(Exception $e){
                $this->response->json([
                    "success" => false,
                    "message" => $e->getMessage()
                ],500)->send();
            }
        }

        public function show(int $id):void{
            try{
                $post = $this->post->find($id);
                if(!$post){
                    $this->response->json([
                        "success" => false,
                        "message" => "Post non trouvé"
                    ],404)->send();
                    return;
                }
                $this->response->json([
                    "success" => true,
                    "post" => $post
                ])->send();
            }
            catch(Exception $e){
                $this->response->json([
                    "success" => false,
                    "message" => $e->getMessage()
                ],500)->send();
            }
        }

        public function store():void{
            try{
                $data = $this->request->all();
                
                if(!isset($data['title']) || empty(trim($data['title']))){
                    $this->response->json([
                        "success" => false,
                        "message" => "Le titre est requis"
                    ],400)->send();
                    return;
                }
                
                if(!isset($data['content']) || empty(trim($data['content']))){
                    $this->response->json([
                        "success" => false,
                        "message" => "Le contenu est requis"
                    ],400)->send();
                    return;
                }
                
                if(!isset($data['user_id']) || !is_numeric($data['user_id'])){
                    $this->response->json([
                        "success" => false,
                        "message" => "L'ID utilisateur est requis et doit être un nombre"
                    ],400)->send();
                    return;
                }
                
                $post = $this->post->create($data);

                $this->response->json([
                    "success" => true,
                    "post" => $post
                ],201)->send();
            }catch(Exception $e){
                $this->response->status(500)->json([
                    "success" => false,
                    "message" => $e->getMessage()
                ])->send();
            }
        }

        public function update(int $id):void{
            try{
                $post = $this->post->find($id);
                if(!$post){
                    $this->response->json([
                        "success" => false,
                        "message" => "Post non trouvé"
                    ],404)->send();
                    return;
                }
                
                $data = $this->request->all();
                
                if(!isset($data['title']) || empty(trim($data['title']))){
                    $this->response->json([
                        "success" => false,
                        "message" => "Le titre est requis"
                    ],400)->send();
                    return;
                }
                
                if(!isset($data['content']) || empty(trim($data['content']))){
                    $this->response->json([
                        "success" => false,
                        "message" => "Le contenu est requis"
                    ],400)->send();
                    return;
                }
                
                $this->post->update($id, $data);

                $this->response->json([
                    "success" => true,
                    'message' => "Post mis à jour avec succès"
                ])->send();
            }
            catch(Exception $e){
                $this->response->json([
                    "success" => false,
                    "message" => $e->getMessage()
                ],500)->send();
            }
        }

        public function destroy(int $id):void{
            try{
                $post = $this->post->find($id);
                if(!$post){
                    $this->response->json([
                        "success" => false,
                        "message" => "Post non trouvé"
                    ],404)->send();
                    return;
                }
                
                $this->post->delete($id);
                $this->response->json([
                    "success" => true,
                    "message" => "Post supprimé avec succès"
                ])->send();
            }
            catch(Exception $e){
                $this->response->json([
                    "success" => false,
                    "message" => $e->getMessage()
                ],500)->send();
            }
        }
    }